<?php

use TAW\Core\OptionsPage\OptionsPage;
use TAW\Core\Menu\Menu;

$footerMenu    = Menu::get('footer');
$companyName   = OptionsPage::get('company_name');
$companyPhone  = OptionsPage::get('company_phone');
$companyEmail  = OptionsPage::get('company_email');
$companyAddr   = OptionsPage::get('company_address');
$footerText    = OptionsPage::get('footer_text') ?: __('Todos los derechos reservados.', 'taw-theme');

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

                <?php echo (new TAW\Blocks\Molecules\SocialMedia\SocialMedia())->render(); ?>

                <?php if ($companyAddr) : ?>
                    <div class="footer-brand__address text-white/70 text-sm leading-relaxed">
                        <?php echo wp_kses_post($companyAddr); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Navigation column -->
            <?php if ($footerMenu && $footerMenu->hasItems()) : ?>
                <div class="footer-nav flex flex-col gap-4">
                    <h3 class="footer-heading">
                        <?php esc_html_e('Sitio', 'taw-theme'); ?>
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


            <!-- Contact column -->
            <div class="footer-contact">
                <div class="divisions flex flex-col gap-5">
                    <div class="division flex flex-col gap-2">
                        <h3 class="footer-heading">
                            <?php esc_html_e('División Financiera', 'taw-theme'); ?>
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
                    <div class="division flex flex-col gap-2">
                        <h3 class="footer-heading">
                            <?php esc_html_e('División Fiduciaria', 'taw-theme'); ?>
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
                </div>
            </div>

        </div>
    </div>

    <!-- ── Bottom bar ────────────────────────────────────────────── -->
    <div class="footer-bottom bg-primary">
        <div class="section-container--sm py-4 flex flex-col sm:flex-row items-center justify-between gap-3">

            <p class="footer-bottom__copy">
                <?php echo esc_html($companyName ?: get_bloginfo('name')); ?>.
                &copy; <?php echo esc_html(date('Y')); ?>
                <?php echo esc_html($footerText); ?>
            </p>

            <div class="legal flex flex-col sm:flex-row items-start sm:items-center gap-x-6 gap-y-3">
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