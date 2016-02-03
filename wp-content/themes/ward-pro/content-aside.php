<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @since 1.0.6
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( ! is_single() ) { ?>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
		<?php } ?>
				<h3 class="post-format"><i class="fa fa-asterisk"></i><?php _e( 'Aside', 'ward' ); ?></h3>

			    <div class="entry-content">
				    <?php the_content( $bavotasan_theme_options['read_more'] ); ?>
			    </div><!-- .entry-content -->

			    <?php get_template_part( 'content', 'footer' ); ?>
		<?php if ( ! is_single() ) { ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</article>