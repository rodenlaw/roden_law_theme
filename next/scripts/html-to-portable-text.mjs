/**
 * HTML → Portable Text converter for the WordPress → Sanity migration.
 *
 * Unlike the original naive stripper (which threw away links, bold/italic, and
 * lists), this preserves the inline marks and block structure that matter for a
 * faithful mirror of the live site:
 *   - block styles: normal, h1–h6, blockquote
 *   - lists: bullet / number, with nesting level
 *   - decorators: strong, em, underline, code
 *   - link annotations: { _type: "link", href } (matches PortableText.tsx renderer)
 *
 * Output shape matches Sanity's default `{ type: "block" }` field, so it slots
 * straight into the existing schemas with no schema changes.
 *
 * Standalone <img>/<figure> tags are dropped (WP media URLs can't be referenced
 * as Sanity image assets without a separate upload step) — htmlToBlocks returns a
 * `droppedImages` count via the optional stats object so callers can report it.
 *
 * Built on node-html-parser (already a dependency) — no jsdom / block-tools.
 */

import { parse } from "node-html-parser";

const NODE_ELEMENT = 1;
const NODE_TEXT = 3;

const BLOCK_STYLE_BY_TAG = {
  P: "normal",
  H1: "h1",
  H2: "h2",
  H3: "h3",
  H4: "h4",
  H5: "h5",
  H6: "h6",
  BLOCKQUOTE: "blockquote",
};

const DECORATOR_BY_TAG = {
  STRONG: "strong",
  B: "strong",
  EM: "em",
  I: "em",
  U: "underline",
  CODE: "code",
};

// Tags that introduce their own block(s) at the top level.
const TOP_LEVEL_BLOCK_TAGS = new Set([
  ...Object.keys(BLOCK_STYLE_BY_TAG),
  "UL",
  "OL",
  "DIV",
  "SECTION",
  "ARTICLE",
  "FIGURE",
  "IMG",
  "TABLE",
  "PRE",
]);

/**
 * Walk inline content of an element, producing { spans, markDefs }.
 * `marks` is the set of active decorator names; `linkKeys` maps an active link
 * markDef key list. We thread both down through recursion.
 */
function walkInline(node, ctx, activeMarks, spans, markDefs) {
  for (const child of node.childNodes) {
    if (child.nodeType === NODE_TEXT) {
      const text = decodeWhitespace(child.text);
      if (text) spans.push(span(ctx, text, activeMarks));
      continue;
    }
    if (child.nodeType !== NODE_ELEMENT) continue;

    const tag = child.tagName;

    // Never emit the contents of these as text (WP content sometimes embeds
    // inline JSON-LD <script> or <style> blocks — they must not leak into body).
    if (tag === "SCRIPT" || tag === "STYLE" || tag === "NOSCRIPT") continue;

    if (tag === "BR") {
      // Soft line break inside a block → newline in the running text.
      spans.push(span(ctx, "\n", activeMarks));
      continue;
    }

    const decorator = DECORATOR_BY_TAG[tag];
    if (decorator) {
      walkInline(child, ctx, addMark(activeMarks, decorator), spans, markDefs);
      continue;
    }

    if (tag === "A") {
      const href = (child.getAttribute("href") || "").trim();
      if (href && href !== "#") {
        const key = `link_${ctx.markCount++}`;
        markDefs.push({ _type: "link", _key: key, href });
        walkInline(child, ctx, addMark(activeMarks, key), spans, markDefs);
      } else {
        walkInline(child, ctx, activeMarks, spans, markDefs);
      }
      continue;
    }

    // SPAN, inline wrappers, or unknown inline tags: descend, keep marks.
    walkInline(child, ctx, activeMarks, spans, markDefs);
  }
}

function buildTextBlock(node, style, ctx) {
  const spans = [];
  const markDefs = [];
  walkInline(node, ctx, [], spans, markDefs);
  const merged = finalizeChildren(mergeSpans(spans, ctx));
  if (!merged.length) return null;
  return {
    _type: "block",
    _key: `block_${ctx.blockCount++}`,
    style,
    markDefs,
    children: merged,
  };
}

function buildListBlocks(node, listItem, level, ctx, out) {
  for (const li of node.childNodes) {
    if (li.nodeType !== NODE_ELEMENT || li.tagName !== "LI") continue;

    // Split the <li> into its own inline content vs nested lists.
    const inlineChildren = [];
    const nestedLists = [];
    for (const c of li.childNodes) {
      if (c.nodeType === NODE_ELEMENT && (c.tagName === "UL" || c.tagName === "OL")) {
        nestedLists.push(c);
      } else {
        inlineChildren.push(c);
      }
    }

    const spans = [];
    const markDefs = [];
    const wrapper = { childNodes: inlineChildren };
    walkInline(wrapper, ctx, [], spans, markDefs);
    const merged = finalizeChildren(mergeSpans(spans, ctx));
    if (merged.length) {
      out.push({
        _type: "block",
        _key: `block_${ctx.blockCount++}`,
        style: "normal",
        listItem,
        level,
        markDefs,
        children: merged,
      });
    }

    for (const nested of nestedLists) {
      const nestedType = nested.tagName === "OL" ? "number" : "bullet";
      buildListBlocks(nested, nestedType, level + 1, ctx, out);
    }
  }
}

/**
 * Convert an HTML string into an array of Portable Text blocks.
 * @param {string} html
 * @param {{droppedImages?: number}} [stats] optional accumulator for reporting
 * @returns {Array<object>}
 */
export function htmlToBlocks(html, stats) {
  if (!html || !html.trim()) return [];
  const root = parse(html, { blockTextElements: { pre: true } });
  const ctx = { blockCount: 0, spanCount: 0, markCount: 0 };
  const blocks = [];

  // Group consecutive top-level inline/text nodes into implicit paragraphs
  // (WP content often has bare text or inline tags with no wrapping <p>).
  let inlineBuffer = [];
  const flushInline = () => {
    if (!inlineBuffer.length) return;
    const block = buildTextBlock({ childNodes: inlineBuffer }, "normal", ctx);
    if (block) blocks.push(block);
    inlineBuffer = [];
  };

  for (const node of root.childNodes) {
    if (node.nodeType === NODE_TEXT) {
      if (node.text.trim()) inlineBuffer.push(node);
      continue;
    }
    if (node.nodeType !== NODE_ELEMENT) continue;

    const tag = node.tagName;

    if (!TOP_LEVEL_BLOCK_TAGS.has(tag)) {
      // Inline-level tag at top level → buffer into a paragraph.
      inlineBuffer.push(node);
      continue;
    }

    flushInline();

    if (BLOCK_STYLE_BY_TAG[tag]) {
      const block = buildTextBlock(node, BLOCK_STYLE_BY_TAG[tag], ctx);
      if (block) blocks.push(block);
    } else if (tag === "UL" || tag === "OL") {
      buildListBlocks(node, tag === "OL" ? "number" : "bullet", 1, ctx, blocks);
    } else if (tag === "IMG") {
      if (stats) stats.droppedImages = (stats.droppedImages || 0) + 1;
    } else if (tag === "FIGURE") {
      if (node.querySelector?.("img") && stats) {
        stats.droppedImages = (stats.droppedImages || 0) + 1;
      }
      // A <figure> may also wrap a <figcaption> with text — keep that as a para.
      const caption = node.querySelector?.("figcaption");
      if (caption) {
        const block = buildTextBlock(caption, "normal", ctx);
        if (block) blocks.push(block);
      }
    } else {
      // DIV / SECTION / ARTICLE / TABLE / PRE wrappers: recurse into children
      // so we don't lose paragraphs nested inside layout wrappers. Tables are
      // flattened to paragraphs (rare in this content).
      const nestedHtml = node.innerHTML;
      if (nestedHtml && nestedHtml.trim()) {
        for (const b of htmlToBlocks(nestedHtml, stats)) {
          b._key = `block_${ctx.blockCount++}`;
          blocks.push(b);
        }
      }
    }
  }

  flushInline();
  return blocks;
}

// --- small helpers ---

function span(ctx, text, marks) {
  return {
    _type: "span",
    _key: `span_${ctx.spanCount++}`,
    text,
    marks: marks.slice(),
  };
}

function addMark(marks, mark) {
  return marks.includes(mark) ? marks : [...marks, mark];
}

// node-html-parser already decodes entities in `.text`; collapse runs of
// whitespace (but keep intentional newlines from <br>) the way HTML rendering would.
function decodeWhitespace(text) {
  return text.replace(/[ \t\r\f\v]*\n[ \t\r\f\v]*/g, "\n").replace(/[ \t]{2,}/g, " ");
}

// Merge adjacent spans that carry identical marks to keep blocks tidy.
function mergeSpans(spans, ctx) {
  const out = [];
  for (const s of spans) {
    const prev = out[out.length - 1];
    if (prev && sameMarks(prev.marks, s.marks)) {
      prev.text += s.text;
    } else {
      out.push({ ...s, _key: `span_${ctx.spanCount++}` });
    }
  }
  return out;
}

// Trim whitespace at the very start/end of a block's children and drop any
// spans that become empty as a result. Internal newlines (from <br>) are kept.
function finalizeChildren(children) {
  if (!children.length) return children;
  children[0].text = children[0].text.replace(/^\s+/, "");
  const last = children[children.length - 1];
  last.text = last.text.replace(/\s+$/, "");
  const kept = children.filter((s) => s.text.length > 0);
  if (kept.every((s) => !s.text.trim())) return [];
  return kept;
}

function sameMarks(a, b) {
  if (a.length !== b.length) return false;
  const sb = new Set(b);
  return a.every((m) => sb.has(m));
}
