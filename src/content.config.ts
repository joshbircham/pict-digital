import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const posts = defineCollection({
  loader: glob({ pattern: '**/*.{md,mdx}', base: './src/content/posts' }),
  schema: z.object({
    title: z.string(),
    date: z.coerce.date(),
    description: z.string(),
    category: z.enum(['Strategy', 'Client Work', 'Content Creation', 'For Businesses']),
    tags: z.array(z.string()).optional(),
    featuredImage: z.string().optional(),
    draft: z.boolean().default(false),
  }),
});

export const collections = { posts };
