# Field Notes Grid Layout Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the horizontal row list on `/posts` with a 3-column image-led card grid.

**Architecture:** All changes are confined to `src/pages/posts/index.astro`. The card markup replaces the existing `.post-row` structure; the `<style>` block is rewritten to support the grid. No new components or files are created.

**Tech Stack:** Astro, vanilla CSS (CSS Grid, aspect-ratio, line-clamp)

---

### Task 1: Replace the post list markup with a card grid

**Files:**
- Modify: `src/pages/posts/index.astro`

- [ ] **Step 1: Replace the posts listing section markup**

In `src/pages/posts/index.astro`, replace the entire `<section class="posts-listing section">` block (lines 29–49) with:

```astro
<section class="posts-listing section">
  <div class="container">
    <hr class="rule rule--light" aria-hidden="true" />

    <div class="posts-grid">
      {posts.map((post) => (
        <a href={`/posts/${post.id.replace(/\.(md|mdx)$/, '')}`} class="post-card">
          <div class="post-card-image">
            {post.data.featuredImage && (
              <img
                src={post.data.featuredImage}
                alt={post.data.featuredImageAlt ?? post.data.title}
                loading="lazy"
              />
            )}
          </div>
          <div class="post-card-body">
            <div class="post-card-meta">
              <span class="specimen-label post-category">{post.data.category}</span>
              <span class="specimen-label post-date"> · {formatDate(post.data.date)}</span>
            </div>
            <h2 class="post-card-title">{post.data.title}</h2>
            <p class="post-card-excerpt">{post.data.description}</p>
            <span class="post-card-read specimen-label">Read →</span>
          </div>
        </a>
      ))}
    </div>
  </div>
</section>
```

- [ ] **Step 2: Replace the entire `<style>` block**

Replace everything inside `<style>` ... `</style>` (lines 53–135) with:

```css
.page-header {
  padding-top: 6rem;
  padding-bottom: var(--space-md);
}

.back-link {
  display: inline-block;
  color: var(--color-annotation);
  margin-bottom: 2rem;
  transition: color 0.2s ease;
}

.back-link:hover { color: var(--color-accent); }

.page-header h1 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  margin-bottom: 1rem;
}

.page-intro {
  max-width: 480px;
}

.posts-listing { padding-top: 0; }

/* Grid */
.posts-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 3rem 2.5rem;
  padding-top: var(--space-md);
}

@media (min-width: 640px) {
  .posts-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 1024px) {
  .posts-grid { grid-template-columns: repeat(3, 1fr); }
}

/* Card */
.post-card {
  display: flex;
  flex-direction: column;
  color: inherit;
  text-decoration: none;
}

.post-card:hover .post-card-title { color: var(--color-accent); }
.post-card:hover .post-card-read  { color: var(--color-accent); }

/* Image */
.post-card-image {
  aspect-ratio: 3 / 2;
  overflow: hidden;
  background-color: var(--color-rule-light);
  margin-bottom: 1.25rem;
}

.post-card-image img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.post-card:hover .post-card-image img {
  transform: scale(1.03);
}

/* Body */
.post-card-body {
  display: flex;
  flex-direction: column;
  flex: 1;
}

.post-card-meta {
  margin-bottom: 0.6rem;
}

.post-category { color: var(--color-accent); }
.post-date     { color: var(--color-annotation); }

.post-card-title {
  font-family: var(--font-serif);
  font-size: clamp(1.05rem, 1.6vw, 1.25rem);
  font-weight: 400;
  line-height: 1.35;
  color: var(--color-text);
  margin-bottom: 0.6rem;
  transition: color 0.2s ease;
}

.post-card-excerpt {
  font-size: 0.875rem;
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 1rem;
}

.post-card-read {
  color: var(--annotation-ink);
  transition: color 0.2s ease;
  margin-top: auto;
}
```

- [ ] **Step 3: Start the dev server and visually verify**

```bash
npm run dev
```

Open `http://localhost:4321/posts` and check:
- Cards render in a 3-column grid on desktop
- Cards render 2-column at ~640px viewport width
- Cards render 1-column on mobile
- Featured image fills the top of each card at 3:2 ratio
- Hovering scales the image and turns the title amber
- "Read →" turns amber on hover
- Clicking a card navigates to the correct post

- [ ] **Step 4: Commit**

```bash
git add src/pages/posts/index.astro
git commit -m "feat: replace Field Notes row list with 3-column image card grid"
```

- [ ] **Step 5: Push**

```bash
git push origin main
```
