<?php

use TAW\Core\OptionsPage\OptionsPage;
use TAW\Core\Menu\Menu;

$footerMenu    = Menu::get('footer');
$companyName   = OptionsPage::get('company_name');
$companyPhone  = OptionsPage::get('company_phone');
$companyEmail  = OptionsPage::get('company_email');
$companyAddr   = OptionsPage::get('company_address');
$footerText    = OptionsPage::get('footer_text') ?: __('All rights reserved.', 'taw-theme');
$socialFb      = OptionsPage::get('social_facebook');
$socialIg      = OptionsPage::get('social_instagram');
$socialTw      = OptionsPage::get('social_twitter');
$socialLi      = OptionsPage::get('social_linkedin');
$socialYt      = OptionsPage::get('social_youtube');

?>

</main><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">

    <!-- ── Main footer body ──────────────────────────────────────── -->
    <div class="footer-main bg-secondary">
        <div class="section-container--sm py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-16">

            <!-- Brand column -->
            <div class="footer-brand flex flex-col gap-5">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand__logo" aria-label="<?php echo esc_attr($companyName ?: get_bloginfo('name')); ?>">
                    <?php echo file_get_contents(get_template_directory() . '/resources/static/svg/ch-logo.svg'); ?>
                </a>

                <?php if ($socialFb || $socialIg || $socialTw || $socialLi || $socialYt) : ?>
                    <div class="footer-social flex items-center gap-4">
                        <?php if ($socialFb) : ?>
                            <a href="<?php echo esc_url($socialFb); ?>" class="footer-social__link" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($socialIg) : ?>
                            <a href="<?php echo esc_url($socialIg); ?>" class="footer-social__link" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($socialTw) : ?>
                            <a href="<?php echo esc_url($socialTw); ?>" class="footer-social__link" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($socialLi) : ?>
                            <a href="<?php echo esc_url($socialLi); ?>" class="footer-social__link" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($socialYt) : ?>
                            <a href="<?php echo esc_url($socialYt); ?>" class="footer-social__link" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($companyAddr) : ?>
                    <div class="footer-brand__address text-white/70 text-sm leading-relaxed">
                        <?php echo wp_kses_post($companyAddr); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Contact column -->
            <div class="footer-contact flex flex-col gap-4">
                <h3 class="footer-heading">
                    <?php esc_html_e('Contact', 'taw-theme'); ?>
                </h3>

                <?php if ($companyEmail) : ?>
                    <a class="footer-contact__link" href="mailto:<?php echo esc_attr($companyEmail); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                        <?php echo esc_html($companyEmail); ?>
                    </a>
                <?php endif; ?>

                <?php if ($companyPhone) : ?>
                    <a class="footer-contact__link" href="tel:<?php echo esc_attr($companyPhone); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                        </svg>
                        <?php echo esc_html($companyPhone); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Navigation column -->
            <?php if ($footerMenu && $footerMenu->hasItems()) : ?>
                <div class="footer-nav flex flex-col gap-4">
                    <h3 class="footer-heading">
                        <?php esc_html_e('Navigation', 'taw-theme'); ?>
                    </h3>
                    <nav aria-label="<?php esc_attr_e('Footer Menu', 'taw-theme'); ?>">
                        <ul class="flex flex-col gap-2.5 list-none m-0 p-0">
                            <?php foreach ($footerMenu->items() as $item) : ?>
                                <li>
                                    <a href="<?php echo esc_url($item->url()); ?>"
                                        class="footer-nav__link <?php echo $item->isActive() ? 'is-active' : ''; ?>">
                                        <?php echo esc_html($item->title()); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ── Bottom bar ────────────────────────────────────────────── -->
    <div class="footer-bottom bg-primary">
        <div class="section-container--sm py-4 flex flex-col sm:flex-row items-center justify-between gap-3">

            <p class="footer-bottom__copy">
                &copy; <?php echo esc_html(date('Y')); ?>
                <?php echo esc_html($companyName ?: get_bloginfo('name')); ?>.
                <?php echo esc_html($footerText); ?>
            </p>

            <div class="legal flex items-center gap-6">
                <a href="https://chcapital.mx/wp-content/uploads/2024/09/UNE-nuevo.pdf" class="footer-bottom__copy text-white">UNE Unidad Especializada de Atención de Clientes</a>
                <a href="https://chcapital.mx/wp-content/uploads/2024/03/aviso.pdf" class="footer-bottom__copy flex items-center gap-1 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                    </svg>
                    Aviso de Privacidad
                </a>
            </div>

        </div>
    </div>

</footer><!-- #colophon -->

<script>
    (function() {
        var header = document.getElementById('masthead');
        if (!header) return;

        function sync() {
            document.documentElement.style.setProperty('--header-height', header.getBoundingClientRect().height + 'px');
        }
        // Run once all styles are applied and layout is stable
        if (document.readyState === 'complete') {
            sync();
        } else {
            window.addEventListener('load', sync, {
                once: true
            });
        }
        // Keep in sync if the header changes height (e.g. mobile ↔ desktop breakpoint)
        if (window.ResizeObserver) {
            new ResizeObserver(sync).observe(header);
        } else {
            window.addEventListener('resize', sync, {
                passive: true
            });
        }
    })();
</script>

<?php wp_footer(); ?>
</body>

</html>