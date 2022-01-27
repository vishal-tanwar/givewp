<?php

get_header();

do_action( 'give_before_main_content' );

while ( have_posts() ) :
	the_post();

	give_get_template_part( 'single-give-form/content', 'single-give-form' );

endwhile; // end of the loop.

do_action( 'give_after_main_content' );

do_action( 'give_sidebar' );

get_footer();
