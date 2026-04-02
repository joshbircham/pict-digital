// @ts-check
import { defineConfig } from 'astro/config';
import mdx from '@astrojs/mdx';
import keystatic from '@keystatic/astro';
import react from '@astrojs/react';

const isDev = process.argv.includes('dev');

// https://astro.build/config
export default defineConfig({
  site: 'https://pictdigital.com',
  integrations: [
    mdx(), // always — content collections use .mdx files
    ...(isDev ? [react(), keystatic()] : []),
  ],
});
