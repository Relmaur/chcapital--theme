# CLAUDE.md — Claude Code Instructions

> Full architecture docs + code examples: **`AGENTS.md`** in this repo.
> **This theme's canonical scaffold (source of truth for base-theme sync):** https://github.com/Relmaur/taw-theme — synced via the `update-theme` skill.
> **`taw/core` framework reference (source of truth for framework APIs):** https://github.com/Relmaur/taw-core#readme — fetch when you need authoritative detail on any framework API. When this file and the `taw/core` README disagree, `taw/core` wins. Separate repo/update path from `taw-theme` — see `composer update taw/core`.
> **Live doc lookup:** prefer the `mcp__taw-docs__search_documentation` MCP tool (if available) over fetching docs by hand — it's a hybrid semantic+keyword search over the current indexed docs.
> Full online documentation: https://taw.mlizardo.com/

## Project

TAW Theme — a classic WordPress theme with a component-based block system, Vite, Tailwind v4, Alpine.js, and a bespoke metabox framework.

## Commands

```bash
npm run dev              # Vite dev server (port 5173, HMR)
npm run build            # Production build → public/build/
composer install         # PHP deps (includes taw/core package)
composer update taw/core # Update the core framework package
composer dump-autoload   # Rebuild classmap after new block classes
php bin/taw make:block Name --type=meta --with-style  # Scaffold a new block
php bin/taw export:block Name                         # Export block as ZIP
php bin/taw import:block path/to/Block.zip            # Import block from ZIP
```

## Core Architecture

Framework internals live in the **`taw/core` composer package** (source: `https://github.com/Relmaur/taw-core`), installed at `vendor/taw/core/src/`. The namespace `TAW\Core` maps to that package — do **not** look for these classes in `inc/`.

The package provides:
- **Block system:** `Core\Block\BaseBlock`, `Core\Block\Block`, `Core\Block\MetaBlock`, `Core\Block\BlockLoader`, `Core\Block\BlockRegistry`
- **Data:** `Core\Metabox\Metabox`, `Core\OptionsPage\OptionsPage`
- **Theme:** `Core\Theme\Theme`, `Core\Theme\ThemeUpdater`
- **Navigation:** `Core\Menu\Menu`, `Core\Menu\MenuItem`
- **REST:** `Core\Rest\SearchEndpoints`
- **Forms:** `Core\Form\Form`, `Core\Form\SubmissionsHandler`
- **Mail:** `Core\Mail\Mailer`, `Core\Mail\MailTemplate`, `Core\Mail\MailTester`
- **Helpers:** `Helpers\Framework`, `Helpers\Image`, `Helpers\Svg`, `Helpers\Dump`, `Helpers\Editor`
- **CLI commands** and autoloads `utilities.php` and `performance.php` via composer `files`.

`Core\Editor\VisualEditor` and `Core\Rest\VisualEditorEndpoint` are also part of the package but are **Work in Progress** — do not rely on them yet.

The theme's own `inc/` only contains:
- `options.php` — theme-level options page configuration (required from `functions.php`)
- `Metabox/` — any view/template overrides for metabox fields

Dev blocks live in `Blocks/{Name}/{Name}.php` with namespace `TAW\Blocks\{Name}\{Name}`. The theme's `composer.json` PSR-4 maps only `TAW\\Blocks\\` → `Blocks/`.

Two block types:
- **MetaBlock** — owns metaboxes, fetches post_meta, rendered via `BlockRegistry::render('id')`
- **Block** — presentational, receives props, rendered directly: `(new Button())->render([...])`

Auto-discovery: `BlockLoader::loadAll()` scans `Blocks/*/` — no manual registration needed.

Asset loading: `BlockRegistry::queue('hero', 'stats')` BEFORE `get_header()` → assets land in `<head>`. Fallback prints inline if forgotten.

## Options Page

`OptionsPage` (from `taw/core`) — same field config format as Metabox but stores to `wp_options`.

```php
new OptionsPage(['id' => 'taw_settings', 'title' => 'TAW Settings', 'fields' => [...]]);
OptionsPage::get('company_phone');           // retrieve a value
OptionsPage::get_image_url('logo', 'large'); // retrieve an image URL
```

Theme options configured in `inc/options.php`, required from `functions.php`.

## Navigation Menus

`TAW\Core\Menu\Menu::get('primary')` — typed tree wrapper for WP nav menus. Use instead of `wp_nav_menu()`.

```php
$menu = TAW\Core\Menu\Menu::get('primary');
foreach ($menu->items() as $item) {
    // $item->title(), $item->url(), $item->isActive(), $item->hasChildren(), ...
}
```

Menus (`primary`, `footer`) are registered in `functions.php` via `register_nav_menus()`.

## Helpers

`TAW\Helpers\Image` — performance-optimised `<img>` tag generator.

```php
echo TAW\Helpers\Image::render($id, 'large', 'Alt text');
echo TAW\Helpers\Image::render($id, 'full', 'Hero', ['above_fold' => true]);
echo TAW\Helpers\Image::preload_tag($id, 'full'); // <link rel="preload">
```

`TAW\Helpers\Svg` — SVG upload enablement, sanitization, and rendering.

```php
Svg::register(); // enable SVG uploads + auto-sanitize on upload (call in theme setup)
echo Svg::render($attachment_id, 'Logo', ['class' => 'logo']); // <img> tag
echo Svg::inline($attachment_id, ['class' => 'icon']);          // inline <svg>
$url = Svg::url($attachment_id);
```

`TAW\Helpers\Dump` — debug helper. Global `dump()` / `dd()` functions output a styled panel in `wp_footer` — only when `WP_DEBUG` is true.

## Forms

`TAW\Core\Form\Form` — configuration-driven frontend form with CSRF (nonces), honeypot, field validation, PRG pattern, and email delivery.

```php
use TAW\Core\Form\Form;

$form = new Form([
    'id'           => 'contact',
    'submit_label' => 'Send Message',
    'email' => [
        'to_self'   => ['subject' => 'New contact',        'template' => 'contact-self'],
        'to_client' => ['subject' => 'Got your message',   'template' => 'contact-client'],
    ],
    'messages' => ['success' => "Thanks! We'll be in touch."],
    'fields' => [
        ['id' => 'name',    'label' => 'Name',    'type' => 'text',     'required' => true],
        ['id' => 'email',   'label' => 'Email',   'type' => 'email',    'required' => true],
        ['id' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true],
    ],
]);
$form->render();
```

Form field types: `text`, `email`, `textarea`, `select`, plus any standard HTML input type.

`TAW\Core\Form\SubmissionsHandler` — stores submissions as a `taw_submission` CPT and can forward them via webhook (n8n, Zapier, Make, etc.). Instantiate once in `functions.php`.

## Mail

`TAW\Core\Mail\Mailer` — fluent `wp_mail()` wrapper with HTML template support.

```php
use TAW\Core\Mail\Mailer;

(new Mailer())
    ->to('user@example.com')
    ->subject('Welcome!')
    ->template('welcome')           // looks in mails/html/welcome.html
    ->setVariables(['name' => 'Jane'])
    ->send();
```

Templates live in `mails/html/{name}.html` (pre-compiled) or `mails/{name}.mjml` (compiled at runtime in dev via `spatie/mjml-php`). Use `{{variable_name}}` placeholders.

`TAW\Core\Mail\MailTester` — admin page (Tools → Test Emails) for sending test emails. Register it with `(new MailTester())->register()`.

## REST API

`TAW\Core\Rest\SearchEndpoints` (from `taw/core`) — `GET taw/v1/search-posts`. Requires `edit_posts` capability. Powers the `post_selector` metabox field type. Registered automatically in `functions.php`.

## CSS / Asset Pipeline

- `resources/js/app.js` imports `../css/app.css` (Tailwind v4) and `../scss/app.scss` (custom SCSS)
- `resources/scss/critical.scss` — standalone Vite entry, inlined in `<head>` — keep under ~14 KB, **no `@font-face`**
- Self-hosted fonts: WOFF2 in `resources/fonts/`, `@font-face` in `resources/scss/_fonts.scss`, `@use 'fonts'` in `app.scss` only
- Add font preloads via `vite_asset_url('resources/fonts/Name.woff2')` (function provided by `taw/core`)
- `utilities.php` and `performance.php` are part of the `taw/core` package — autoloaded via composer `files`
- `utilities.php` provides global helpers: `vite_asset_url()`, `vite_is_dev()`, `dump()`, `dd()`, `taw_editable()`, `taw_editor_attrs()`

## Key Conventions

- Folder name === class name === `$id` property
- Meta keys: `_taw_{field_id}`, option keys: `_taw_{field_id}`
- Block assets: `style.css` (or `.scss`) and `script.js` — auto-enqueued
- Templates: `index.php` receives `extract()`-ed variables from `getData()`
- PSR-4 (theme): `TAW\Blocks\` → `Blocks/` only — all other `TAW\` classes come from `taw/core`

## Metabox Field Types

`text`, `textarea`, `wysiwyg`, `url`, `number`, `range`, `select`, `image`, `group`, `checkbox`, `color`, `repeater`, `post_select`

## When Creating New Blocks

1. **CLI (preferred):** `php bin/taw make:block Name --type=meta --with-style`, then `composer dump-autoload`
2. **Manual:** Create `Blocks/{Name}/{Name}.php` and `Blocks/{Name}/index.php` — auto-discovered, no `functions.php` changes

## Don't

- Don't manually register blocks in functions.php
- Don't call wp_enqueue_style/script for block assets directly
- Don't mismatch folder/class names (breaks auto-discovery)
- Don't forget `queue()` before `get_header()` in templates
- Don't add `@font-face` to `critical.scss` — inlined CSS can't resolve relative asset paths
- Don't add `resources/css/app.css` as a Vite entry — it's imported by `app.js`
- Don't use `wp_nav_menu()` — use `Menu::get('location')` for full markup control
- Don't look for `TAW\Core` or `TAW\Helpers` classes in `inc/` — they live in `vendor/taw/core/src/`
- Don't edit files inside `vendor/` — to change framework behaviour, update the `taw/core` package in its own repo and bump the version
