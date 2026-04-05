# Field Notes Grid Layout — Design Spec

**Date:** 2026-04-05
**File affected:** `src/pages/posts/index.astro`

---

## Overview

Replace the current horizontal row list on the Field Notes page with a 3-column image-led card grid. Each card shows the post's featured image above the title, category, excerpt, and a read link.

---

## Layout

- **Desktop (≥1024px):** 3-column CSS grid
- **Tablet (≥640px):** 2-column CSS grid
- **Mobile (<640px):** 1-column stack

The existing `hr.rule--light` separator above the list is retained. The page header (title, intro, back link) is unchanged.

---

## Card Structure

Each card is a full `<a>` link wrapping:

1. **Image wrapper** — `overflow: hidden` to contain the hover scale
   - `<img>` with `aspect-ratio: 3 / 2`, `object-fit: cover`, `width: 100%`
   - If `featuredImage` is absent: image slot shows `--color-bg` (no broken image, no placeholder text)
2. **Card body** (padding below image)
   - Category + date — inline, `specimen-label` style, separated by ` · `
   - Title — `font-family: var(--font-serif)`, `font-weight: 400`
   - Excerpt — `font-size: 0.875rem`, capped to 2 lines via `-webkit-line-clamp: 2`
   - "Read →" — `specimen-label` style

---

## Hover State

- Image scales to `transform: scale(1.03)` with `transition: transform 0.4s ease`
- Title colour shifts to `var(--color-accent)`
- No box shadow, no card elevation — keeps the design flat and editorial

---

## Fallback (no featured image)

The image slot renders as a solid `--color-bg` block at the correct aspect ratio. No alt text issues, no layout shift.

---

## What Is Not Changing

- Page header (`h1`, intro, back link)
- Navigation component
- Individual post page (`[slug].astro`)
- Font choices, colour tokens, spacing variables
- The `specimen-label` and `post-category` / `post-date` class styles (reused)
