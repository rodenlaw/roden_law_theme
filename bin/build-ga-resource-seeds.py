#!/usr/bin/env python3
"""Build bin/en-seed-resource-page.php seed scripts for the three Georgia resource guides
(data/practice-area-drafts/2026-09/ga-resources/*.json; reviewed by Tyler Love 2026-09-30,
data/facts/attorney-approvals-2026-09-30.md). Creates DRAFTS unless the seeder is run with
`apply publish`.

    python3 bin/build-ga-resource-seeds.py <out-dir>
"""
import json, pathlib, sys
root = pathlib.Path(__file__).resolve().parent.parent
out = pathlib.Path(sys.argv[1]); out.mkdir(parents=True, exist_ok=True)
seeder = (root / 'bin/en-seed-resource-page.php').read_text().split('\n', 1)[1]
for slug in ('georgia-car-seat-laws', 'georgia-uninsured-motorist-coverage', 'georgia-wrongful-death-settlement-value'):
    d = json.loads((root / f'data/practice-area-drafts/2026-09/ga-resources/{slug}.json').read_text())
    assert d['slug'] == slug and d['author_attorney'] == 3730 and d['jurisdiction'] == 'GA'
    faqs = [{'question': f['question'], 'answer': f['answer']} for f in d['faqs']]
    texts = [d['body_html'], d['key_takeaways'], d['title'], d['meta_title'], d['meta_description']] + [f['question'] + f['answer'] for f in faqs]
    assert not any(chr(92) in t for t in texts), 'backslash in content (wp_unslash eats it)'
    assert 'Key Takeaways' not in d['body_html'] and 'Frequently Asked' not in d['body_html']
    assert 'S.C. Code' not in d['body_html'] and len(faqs) >= 6
    assert len(d['meta_title']) <= 60 and len(d['meta_description']) <= 155
    payload = {
        'slug': slug, 'title': d['title'], 'excerpt': d['meta_description'], 'content': d['body_html'],
        'expected_attorney': 'Tyler Love', 'image': '',
        'meta': {
            '_roden_author_attorney': 3730, '_roden_jurisdiction': 'georgia-only',
            '_roden_key_takeaways': d['key_takeaways'], '_roden_faqs': faqs, '_roden_see_also': [],
            '_roden_last_reviewed': '2026-09-30', '_roden_meta_title': d['meta_title'],
            '_roden_meta_description': d['meta_description'],
        },
    }
    (out / f'seed-{slug}.php').write_text("<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n" + json.dumps(payload, ensure_ascii=False) + "\nRODENJSON\n);\n" + seeder)
    print(slug, '| body', len(d['body_html']), '| faqs', len(faqs), '| GA cites', d['body_html'].count('O.C.G.A. §'))
