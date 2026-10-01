#!/usr/bin/env node
// Generate featured images for resource pages that have none. Owner, 2026-10-01:
// "use the resource title to set the image prompt and alt text".
//
// Input: a TSV (ID \t jurisdiction \t slug \t title) of published resources without
// a thumbnail (one header line). Spanish twins (slug es-<x>) are not generated:
// they reuse the English twin's file with a Spanish alt (see bin/attach-resource-image.php).
// Uses the local-SEO pipeline's generator (gpt-image-2, 1536x1024, high, streamed)
// and its JPG encoder. Skips any slug whose JPG already exists, so it resumes.
//
//   node --env-file=.env.local bin/gen-resource-images.mjs <list.tsv> <out-dir> [--only slug,slug] [--jobs 4]
import { readFileSync, existsSync, mkdirSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';
import { generateImage } from '../../internal-ai-scripts/scripts/local-seo/lib/openai-image.mjs';
import { convertToJpg } from '../../internal-ai-scripts/scripts/local-seo/lib/image-encode.mjs';

const [list, out, ...rest] = process.argv.slice(2);
const only = rest.includes('--only') ? rest[rest.indexOf('--only') + 1].split(',') : null;
const jobs = rest.includes('--jobs') ? Number(rest[rest.indexOf('--jobs') + 1]) : 4;
// --extra appends direction to every prompt in this run (e.g. a regeneration that must be calmer).
const extra = rest.includes('--extra') ? rest[rest.indexOf('--extra') + 1] : '';
mkdirSync(out, { recursive: true });

const decode = s => s.replace(/&amp;/g, '&').replace(/&#8217;/g, '’').replace(/&#8211;/g, '–');
const rows = readFileSync(list, 'utf8').trim().split('\n').slice(1).map(l => {
  const [id, juris, slug, title] = l.split('\t');
  return { id: Number(id), juris, slug, title: decode(title) };
}).filter(r => !r.slug.startsWith('es-') && (!only || only.includes(r.slug)));

function place(juris) {
  if (/^(ga|georgia-only)$/.test(juris)) return 'Set in coastal Georgia.';
  if (/^(sc|south-carolina-only)$/.test(juris)) return 'Set in South Carolina.';
  return 'Set in the coastal Georgia and South Carolina region.';
}

export function promptFor(r) {
  return [
    `Photorealistic editorial photograph for a law firm's legal resource article titled "${r.title}".`,
    'Show the subject of the title literally and calmly, as a news photographer would: the specific road, vehicle type, workplace, building, document or everyday scene it is about. Choose a viewpoint and setting specific to this title rather than a generic parked car.',
    place(r.juris),
    'Natural daylight, documentary style, realistic muted colors, wide 16:9 landscape composition.',
    'No readable text, words, numbers, road signs with legible lettering, logos, brand names or license plates.',
    'No identifiable faces, no injuries, blood or close-up wreckage, no police badges, no gavels or scales of justice, no courtroom clichés.',
  ].concat(extra ? [extra] : []).join(' ');
}

const manifestPath = join(out, 'manifest.json');
const manifest = existsSync(manifestPath) ? JSON.parse(readFileSync(manifestPath, 'utf8')) : {};

async function one(r) {
  const jpg = join(out, `${r.slug}.jpg`);
  if (existsSync(jpg)) return;
  const png = join(out, `${r.slug}.png`);
  const prompt = promptFor(r);
  const t0 = Date.now();
  const [img] = await generateImage({ prompt });
  if (!img?.base64) throw new Error('no image returned');
  writeFileSync(png, Buffer.from(img.base64, 'base64'));
  await convertToJpg(png, jpg, 85);
  manifest[r.slug] = { id: r.id, juris: r.juris, title: r.title, alt: r.title, prompt, file: `${r.slug}.jpg`, seconds: Math.round((Date.now() - t0) / 1000) };
  writeFileSync(manifestPath, JSON.stringify(manifest, null, 2));
  console.log(`done ${r.slug} (${manifest[r.slug].seconds}s)`);
}

const queue = rows.slice();
let failed = 0;
await Promise.all(Array.from({ length: jobs }, async () => {
  while (queue.length) {
    const r = queue.shift();
    try { await one(r); } catch (e) { failed++; console.error(`FAILED ${r.slug}: ${e.message}`); }
  }
}));
console.log(`${rows.length} rows, ${Object.keys(manifest).length} in manifest, ${failed} failed`);
process.exit(failed ? 1 : 0);
