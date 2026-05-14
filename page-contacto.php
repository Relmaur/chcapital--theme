<?php

/**
 * Template Name: Contacto
 *
 * Contact page: Hero → ContactForm → HighlightsRow → FAQs
 */

use TAW\Core\Block\BlockRegistry;

BlockRegistry::queue('hero_standard', 'contact_form', 'highlights_row', 'faqs');

get_header();

BlockRegistry::render('hero_standard');
BlockRegistry::render('contact_form');
BlockRegistry::render('highlights_row');
BlockRegistry::render('faqs');

get_footer();
