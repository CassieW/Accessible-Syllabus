<?php
/**
 * The template for displaying a page.
 *
 * @since 1.0.7
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( ! is_front_page() ) { ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } ?>

	    <div class="entry-content">
		    <?php the_content( $bavotasan_theme_options['read_more'] ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article><!-- #post-<?php the_ID(); ?> -->