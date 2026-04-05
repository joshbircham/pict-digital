# Author Block Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an SEO-friendly author block with photo, name, job title, and LinkedIn link between the post body and footer on every post page.

**Architecture:** All markup changes are in `src/pages/posts/[slug].astro`. The author photo is saved to `public/images/josh-bircham.jpg`. No new components or content schema changes needed.

**Tech Stack:** Astro, vanilla CSS, Schema.org microdata

---

### Task 1: Save the author photo

**Files:**
- Create: `public/images/josh-bircham.jpg`

- [ ] **Step 1: Save and resize the headshot**

Save the provided headshot image to `public/images/josh-bircham.jpg`, resized to 200×200px. Use any image tool available (e.g. macOS Preview → Tools → Adjust Size, or `sips`):

```bash
sips -Z 200 /path/to/source-photo.jpg --out /Users/joshbircham/pict-digital/public/images/josh-bircham.jpg
```

The image will be displayed at 64×64px in the browser; 200px gives clean 3× retina rendering.

- [ ] **Step 2: Verify the file exists**

```bash
ls -lh /Users/joshbircham/pict-digital/public/images/josh-bircham.jpg
```

Expected: file exists, size roughly 20–60 KB.

- [ ] **Step 3: Commit**

```bash
git add public/images/josh-bircham.jpg
git commit -m "assets: add Josh Bircham author headshot"
```

---

### Task 2: Add the author block markup and styles

**Files:**
- Modify: `src/pages/posts/[slug].astro`

- [ ] **Step 1: Add the author block between `.post-body` and `.post-footer`**

In `src/pages/posts/[slug].astro`, insert the following block after the closing `</div>` of `.post-body` (line 52) and before `<footer class="post-footer container">`:

```astro
<div class="post-author container">
  <hr class="rule rule--light post-author-rule" aria-hidden="true" />
  <div class="post-author-inner" itemscope itemtype="https://schema.org/Person">
    <img
      src="/images/josh-bircham.jpg"
      alt="Josh Bircham"
      class="post-author-photo"
      width="64"
      height="64"
      itemprop="image"
    />
    <div class="post-author-info">
      <span class="post-author-name" itemprop="name">Josh Bircham</span>
      <span class="specimen-label post-author-title" itemprop="jobTitle">Founder, Pict Digital · Senior Lecturer, Digital Marketing</span>
    </div>
    <a
      href="https://www.linkedin.com/in/josh-bircham/"
      class="post-author-linkedin specimen-label"
      target="_blank"
      rel="noopener noreferrer"
      itemprop="url"
    >LinkedIn →</a>
  </div>
</div>
```

- [ ] **Step 2: Add styles to the `<style>` block**

Append the following before the closing `</style>` tag in `src/pages/posts/[slug].astro`:

```css
/* Author block */
.post-author {
  padding-bottom: var(--space-lg);
}

.post-author-rule {
  margin-bottom: 2rem;
}

.post-author-inner {
  display: flex;
  align-items: center;
  gap: 1.25rem;
}

.post-author-photo {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
}

.post-author-info {
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
  flex: 1;
}

.post-author-name {
  font-family: var(--font-serif);
  font-size: 1rem;
  font-weight: 400;
  color: var(--color-text);
}

.post-author-title {
  color: var(--color-annotation);
}

.post-author-linkedin {
  color: var(--annotation-ink);
  white-space: nowrap;
  transition: color 0.2s ease;
}

.post-author-linkedin:hover {
  color: var(--color-accent);
}

@media (max-width: 639px) {
  .post-author-inner {
    flex-wrap: wrap;
  }
  .post-author-linkedin {
    width: 100%;
  }
}
```

- [ ] **Step 3: Apply the wide-layout left offset to `.post-author`**

In the existing `@media (min-width: 1200px)` block in `src/pages/posts/[slug].astro`, add:

```css
.post-author {
  padding-left: 14rem;
}
```

This keeps the author block aligned with the post body text on wide screens.

- [ ] **Step 4: Start the dev server and visually verify**

```bash
npm run dev
```

Open `http://localhost:4321/posts/why-your-small-business-doesnt-need-a-rebrand` and check:
- Circular author photo appears above the footer
- Name "Josh Bircham" in serif
- Title in small caps / specimen-label style
- "LinkedIn →" link on the right
- Clicking LinkedIn opens `https://www.linkedin.com/in/josh-bircham/` in a new tab
- On mobile, LinkedIn link wraps below the photo/name row

Verify Schema.org microdata in browser DevTools → Elements — confirm `itemscope`, `itemprop="name"`, `itemprop="jobTitle"`, `itemprop="url"`, `itemprop="image"` are all present.

- [ ] **Step 5: Commit**

```bash
git add src/pages/posts/[slug].astro
git commit -m "feat: add SEO author block to post pages"
```

- [ ] **Step 6: Push**

```bash
git push origin main
```
