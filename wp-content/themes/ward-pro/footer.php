<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * main, .grid and #page div elements.
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();
		if ( is_singular() || is_404() || ( function_exists( 'is_bbpress' ) && is_bbpress() ) ) { ?>
			</div> <!-- .row -->
		<?php } ?>
	</main> <!-- main -->
</div> <!-- #page -->

<footer id="footer" role="contentinfo">
	<div id="footer-content" class="container">
		<div class="row">
			<?php dynamic_sidebar( 'extended-footer' ); ?>
		</div><!-- .row -->

		<div class="row copyright">
			<div class="col-lg-12">
				<?php $class = ( is_active_sidebar( 'extended-footer' ) ) ? ' active' : ''; ?>
				<span class="line<?php echo $class; ?>"></span>
				<span class="pull-left"><?php echo $bavotasan_theme_options['copyright']; ?></span>
				<span class="credit-link pull-right"><?php printf( __( 'The %s Theme by %s.', 'ward' ), BAVOTASAN_THEME_NAME, '<a href="http://themes.bavotasan.com/themes/ward-pro">bavotasan.com</a>' ); ?></span>
			</div><!-- .col-lg-12 -->
		</div><!-- .row -->
	</div><!-- #footer-content.container -->
</footer><!-- #footer -->

<?php wp_footer(); ?>
</body>
</html>