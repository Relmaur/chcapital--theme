<?php

/**
 * Menu Block Template
 *
 * @var string $text
 */

// Add menu-specific metaboxes

?>

<div class="menu flex flex-col" x-data="Menu" :class="{ 'is-top-hidden': topHidden }">
    <div class="nav__top py-3 bg-primary flex-1">
        <div class="site-branding section-container--sm flex flex-col sm:flex-row items-center justify-between">
            <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo file_get_contents(get_template_directory() . '/resources/static/svg/ch-logo.svg') ?></a>
            </div>
            <div class="search-bar-and-address flex items-center">
                <?php if (TAW\Core\OptionsPage\OptionsPage::get('company_address')) : ?>
                    <div class="text-white! pr-4 mr-4 border-r text-xs text-right leading-5" href="tel:<?php echo esc_attr(TAW\Core\OptionsPage\OptionsPage::get('company_address')); ?>">
                        <?php echo wp_kses_post(TAW\Core\OptionsPage\OptionsPage::get('company_address')); ?>
                    </div>
                <?php endif; ?>
                <button class="search-icon text-white cursor-pointer" @click="open = true" aria-label="Abrir búsqueda">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 relative hover:-translate-y-0.5 transition-all">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Search Overlay -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="search-overlay"
        @click.self="closeSearch()"
        role="dialog"
        aria-modal="true"
        aria-label="Search"
        style="display:none"
        x-cloak>
        <div class="search-overlay__panel" x-show="open" x-cloak>
            <div class="search-overlay__header">
                <label for="taw-search-input" class="search-overlay__label">¿Qué estás buscando?</label>
                <button class="search-overlay__close" @click="closeSearch()" aria-label="Cerrar búsqueda">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="search-overlay__input-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="search-overlay__input-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                    id="taw-search-input"
                    x-ref="searchInput"
                    x-model="query"
                    type="search"
                    class="search-overlay__input"
                    placeholder="Buscar en publicaciones y páginas…"
                    autocomplete="off" />
                <div x-show="loading" class="search-overlay__spinner" aria-hidden="true"></div>
            </div>

            <!-- Suggested pages -->
            <?php
            $suggested_query = new WP_Query([
                'post_type'      => 'page',
                'post_status'    => 'publish',
                'posts_per_page' => 3,
                'orderby'        => 'rand',
            ]);
            $suggested_pages = array_map(fn($p) => [
                'url'   => get_permalink($p->ID),
                'title' => $p->post_title,
            ], $suggested_query->posts);
            wp_reset_postdata();
            ?>
            <?php if (!empty($suggested_pages)): ?>
            <div class="search-overlay__suggested" x-show="!query.trim()">
                <p class="search-overlay__suggested-label">Tal vez te interese</p>
                <ul class="search-overlay__suggested-list">
                    <?php foreach ($suggested_pages as $page): ?>
                        <li>
                            <a href="<?php echo esc_url($page['url']); ?>" class="search-overlay__result-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="search-overlay__suggested-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                                <span class="search-overlay__result-title"><?php echo esc_html($page['title']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Results -->
            <ul x-show="results.length > 0" class="search-overlay__results">
                <template x-for="result in results" :key="result.id">
                    <li class="search-overlay__result">
                        <a :href="result.url" class="search-overlay__result-link">
                            <div class="search-overlay__result-body">
                                <span class="search-overlay__result-title" x-text="result.title"></span>
                                <span class="search-overlay__result-meta" x-text="result.subtype"></span>
                            </div>
                        </a>
                    </li>
                </template>
            </ul>

            <!-- Empty state -->
            <p
                x-show="!loading && results.length === 0 && query.trim().length > 0"
                class="search-overlay__empty">No se encontraron resultados para "<span x-text="query"></span>".</p>
        </div>
    </div>

    <div class="nav__bottom py-2 sm:py-4 bg-secondary flex-1">
        <div class="section-container--sm flex gap-4 items-center justify-center sm:justify-between flex-wrap">
            <?php

            use TAW\Core\Menu\Menu;

            $menu = Menu::get('primary');
            ?>
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'taw-theme'); ?>">
                <?php if ($menu && $menu->hasItems()): ?>
                    <nav class="hidden sm:flex items-center gap-x-8 gap-y-3 flex-wrap">
                        <?php foreach ($menu->items() as $item): // dump($item); 
                        ?>
                            <?php $icon = get_post_meta($item->wpPost()->ID, '_taw_menu_item_icon', true); ?>
                            <div class="relative group" <?php if ($item->hasChildren()): ?>x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" <?php endif; ?>>
                                <a href="<?php echo esc_url($item->url()); ?>" class="menu__item flex items-center gap-1.5 text-white transition-colors text-xs uppercase <?php echo $item->isInActiveTrail() ? 'opacity-100 font-semibold' : 'opacity-85 hover:opacity-100'; ?>">
                                    <?php if ($icon): ?>
                                        <span class="menu__item-icon text-primary w-5"><?php echo $icon; ?></span>
                                    <?php endif; ?>
                                    <?php echo esc_html($item->title()); ?>
                                    <?php if ($item->hasChildren()): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-3 mt-px transition-transform duration-200 group-hover:rotate-180">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    <?php endif; ?>
                                </a>
                                <?php if ($item->hasChildren()): ?>
                                    <div x-show="open" x-transition class="submenu absolute top-full left-0 pt-6 z-50 min-w-68">
                                        <div class="bg-white shadow-xl rounded-md p-3 border border-gray-200">
                                            <?php foreach ($item->children() as $child): ?>
                                                <?php $child_icon = get_post_meta($child->wpPost()->ID, '_taw_menu_item_icon', true); ?>
                                                <a href="<?php echo esc_url($child->url()); ?>"
                                                    class="menu__item flex items-center gap-2 p-2 border-sm text-sm text-gray-700 hover:bg-gray-100 <?php echo $child->isInActiveTrail() ? 'bg-gray-100' : ''; ?>">
                                                    <?php if ($child_icon): ?>
                                                        <span class="menu__item-icon text-primary w-5"><?php echo $child_icon; ?></span>
                                                    <?php endif; ?>
                                                    <?php echo esc_html($child->title()); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </nav>
                <?php endif; ?>
            </nav>

            <div class="contact hidden sm:flex items-center justify-center">
                <?php if (TAW\Core\OptionsPage\OptionsPage::get('company_email')) : ?>
                    <a class="text-white flex items-center justify-center gap-1 text-xs pr-4 mr-4 border-r border-white" href="mailto:<?php echo esc_attr(TAW\Core\OptionsPage\OptionsPage::get('company_email')); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                        <?php echo esc_html(TAW\Core\OptionsPage\OptionsPage::get('company_email')); ?>
                    </a>
                <?php endif; ?>
                <?php if (TAW\Core\OptionsPage\OptionsPage::get('company_phone')) : ?>
                    <a class="text-white flex items-center justify-center gap-1 text-xs" href="tel:<?php echo esc_attr(TAW\Core\OptionsPage\OptionsPage::get('company_phone')); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                        </svg>
                        <?php echo esc_html(TAW\Core\OptionsPage\OptionsPage::get('company_phone')); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Hamburger button (mobile only) -->
            <button
                class="hamburger sm:hidden! max-w-6"
                :class="{ 'is-open': mobileOpen }"
                @click="mobileOpen = !mobileOpen"
                :aria-expanded="mobileOpen"
                aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <!-- Mobile drawer backdrop -->
    <div
        x-show="mobileOpen"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mobile-drawer-backdrop sm:hidden"
        @click="mobileOpen = false"
        aria-hidden="true"
        x-cloak>
    </div>

    <!-- Mobile drawer panel (slides in from left) -->
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="mobile-drawer-panel sm:hidden"
        role="dialog"
        aria-modal="true"
        aria-label="Navigation menu"
        x-cloak>

        <!-- Drawer header -->
        <div class="mobile-drawer-panel__header">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-drawer-panel__logo">
                <?php echo file_get_contents(get_template_directory() . '/resources/static/svg/ch-logo.svg') ?>
            </a>
            <button
                class="mobile-drawer-panel__close"
                @click="mobileOpen = false"
                aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Drawer nav -->
        <?php if ($menu && $menu->hasItems()): ?>
            <ul class="mobile-drawer-panel__nav">
                <?php foreach ($menu->items() as $item): ?>
                    <li x-data="{ subOpen: false }" class="mobile-drawer-panel__item">
                        <?php $mobile_icon = get_post_meta($item->wpPost()->ID, '_taw_menu_item_icon', true); ?>
                        <?php if ($item->hasChildren()): ?>
                            <div class="mobile-drawer-panel__row">
                                <a href="<?php echo esc_url($item->url()); ?>"
                                    class="mobile-drawer-panel__link flex items-center gap-2 <?php echo $item->isInActiveTrail() ? 'is-active' : ''; ?>">
                                    <?php if ($mobile_icon): ?><span class="menu__item-icon"><?php echo $mobile_icon; ?></span><?php endif; ?>
                                    <?php echo esc_html($item->title()); ?>
                                </a>
                                <button
                                    class="mobile-drawer-panel__caret"
                                    @click="subOpen = !subOpen"
                                    :aria-expanded="subOpen"
                                    aria-label="Toggle submenu">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4 transition-transform duration-200" :class="{ 'rotate-180': subOpen }">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </div>
                            <ul
                                x-show="subOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="mobile-drawer-panel__submenu">
                                <?php foreach ($item->children() as $child): ?>
                                    <?php $child_mobile_icon = get_post_meta($child->wpPost()->ID, '_taw_menu_item_icon', true); ?>
                                    <li>
                                        <a href="<?php echo esc_url($child->url()); ?>"
                                            class="mobile-drawer-panel__sublink flex items-center gap-2 <?php echo $child->isActive() ? 'is-active' : ''; ?>">
                                            <?php if ($child_mobile_icon): ?>
                                                <span class="menu__item-icon w-6">
                                                    <?php echo $child_mobile_icon; ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php echo esc_html($child->title()); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <a href="<?php echo esc_url($item->url()); ?>"
                                class="mobile-drawer-panel__link flex items-center gap-2 <?php echo $item->isInActiveTrail() ? 'is-active' : ''; ?>">
                                <?php if ($mobile_icon): ?>
                                    <span class="menu__item-icon w-6">
                                        <?php echo $mobile_icon; ?>
                                    </span>
                                <?php endif; ?>
                                <?php // dump($mobile_icon) 
                                ?>
                                <?php echo esc_html($item->title()); ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Drawer contact -->
        <div class="mobile-drawer-panel__contact">
            <?php if (TAW\Core\OptionsPage\OptionsPage::get('company_email')) : ?>
                <a class="mobile-drawer-panel__contact-link" href="mailto:<?php echo esc_attr(TAW\Core\OptionsPage\OptionsPage::get('company_email')); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <?php echo esc_html(TAW\Core\OptionsPage\OptionsPage::get('company_email')); ?>
                </a>
            <?php endif; ?>
            <?php if (TAW\Core\OptionsPage\OptionsPage::get('company_phone')) : ?>
                <a class="mobile-drawer-panel__contact-link" href="tel:<?php echo esc_attr(TAW\Core\OptionsPage\OptionsPage::get('company_phone')); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    <?php echo esc_html(TAW\Core\OptionsPage\OptionsPage::get('company_phone')); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>