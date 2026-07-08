import { defineConfig } from 'vite';
import fullReload from 'vite-plugin-full-reload';
import tailwindcss from '@tailwindcss/vite';
import { readdirSync, writeFileSync, unlinkSync, mkdirSync } from 'fs';
import { dirname } from 'path';

const componentAssets = readdirSync('Blocks', { recursive: true })
    .filter(f => f.endsWith('style.css') || f.endsWith('style.scss') || f.endsWith('script.js'))
    .map(f => `Blocks/${f}`);

/**
 * Writes public/build/hot with the dev server URL on start.
 * PHP detects dev mode by checking for this file rather than probing the port.
 * The file is removed when the server stops, and emptyOutDir wipes it on build.
 */
function hotFilePlugin(hotPath = 'public/build/hot') {
    const cleanup = () => { try { unlinkSync(hotPath); } catch {} };
    return {
        name: 'taw-hot-file',
        configureServer(server) {
            server.httpServer?.once('listening', () => {
                mkdirSync(dirname(hotPath), { recursive: true });
                const { port } = server.httpServer.address();
                writeFileSync(hotPath, `http://localhost:${port}`);
            });
            process.on('exit', cleanup);
            for (const sig of ['SIGINT', 'SIGTERM', 'SIGHUP']) {
                process.on(sig, () => { cleanup(); process.exit(); });
            }
        },
    };
}

export default defineConfig(({ command }) => ({
    // './' makes font/asset URLs relative in the compiled CSS so they
    // resolve correctly from any subdirectory (e.g. WordPress theme paths).
    // Dev mode must stay '/' — Vite's HMR breaks with a relative base when
    // scripts are served cross-origin (localhost:5173 → taw.local).
    base: command === 'build' ? './' : '/',
    plugins: [
        hotFilePlugin(),
        tailwindcss(),
        fullReload(['**/*.php', 'resources/views/**/*.twig']),
    ],
    build: {
        outDir: 'public/build',
        emptyDirOnBuild: true,
        manifest: 'manifest.json',
        rollupOptions: {
            input: [
                'resources/scss/critical.scss',
                'resources/js/app.js',
                ...componentAssets,
            ],
        },
    },
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
        cors: true,
        // Tell Vite to embed full absolute URLs for assets in injected CSS.
        // Without this, Vite writes `/resources/fonts/...` (absolute path)
        // which the browser resolves against the page origin (taw.local),
        // not the Vite server (localhost:5173) — causing font 404s.
        origin: 'http://localhost:5173',
        watch: {
            usePolling: true,
        },
    },
}));