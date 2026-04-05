# Author Block — Design Spec

**Date:** 2026-04-05
**File affected:** `src/pages/posts/[slug].astro`
**Image:** `public/images/josh-bircham.jpg`

---

## Overview

Add an SEO-friendly author block to the bottom of every post page, between the post body and the footer. Hardcoded for single author Josh Bircham — no abstraction needed.

---

## Placement

In `src/pages/posts/[slug].astro`, between `.post-body` and `.post-footer`:

```
[post body]
[hr.rule--light]
[author block]   ← new
[post footer]
```

The author block uses the existing `.container` class for alignment.

---

## Layout

Horizontal row (desktop and mobile):
- Left: circular photo (64×64px)
- Middle: name + title stacked
- Right: LinkedIn link

---

## Content

| Field | Value |
|---|---|
| Photo | `/images/josh-bircham.jpg`, 64×64px, circular (`border-radius: 50%`), `object-fit: cover` |
| Name | "Josh Bircham" — `font-family: var(--font-serif)`, `font-weight: 400` |
| Title | "Founder, Pict Digital · Senior Lecturer, Digital Marketing" — `specimen-label` style |
| LinkedIn | `https://www.linkedin.com/in/josh-bircham/` — "LinkedIn →", opens in new tab, `specimen-label` style, `--annotation-ink` colour with `--color-accent` on hover |

---

## SEO — Structured Data

The author block is wrapped in:

```html
<div itemscope itemtype="https://schema.org/Person">
```

With `itemprop` attributes:
- `itemprop="name"` on the name element
- `itemprop="jobTitle"` on the title element
- `itemprop="url"` on the LinkedIn `<a>`
- `itemprop="image"` on the `<img>`

---

## Photo

Save the provided headshot to `public/images/josh-bircham.jpg`, resized to 200×200px (2× for retina). Displayed at 64×64px via CSS.

---

## What Is Not Changing

- Post header, body, or footer structure
- Any other page
- Content collection schema
