<?php

use TAW\Core\Block\BlockRegistry;

BlockRegistry::queue('hero_home', 'fideicomitente_p_f', 'fideicomitente_p_m');

get_header();

?>


<?php

BlockRegistry::render('hero_home');

BlockRegistry::render('fideicomitente_p_f');

BlockRegistry::render('fideicomitente_p_m');

?>

<?php get_footer(); ?>