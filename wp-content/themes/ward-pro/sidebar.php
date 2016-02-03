<?php
/**
 * The first/left sidebar widgetized area.
 *
 * If no active widgets in sidebar, alert with default login
 * widget will appear.
 *
 * @since 1.0.0
 */
if ( ! is_bavotasan_full_width() ) {
	// Remove sidebars on Woocommerce shop & products page
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() )
		return;
	?>
	<div id="secondary" <?php bavotasan_sidebar_class(); ?> role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
			<aside id="meta" class="widget">
				<h3 class="widget-title"><?php _e( 'Default Widget', 'ward' ); ?></h3>
				<p><?php printf( __( 'This is just a default widget. It\'ll disappear as soon as you add your own widgets on the %sWidgets admin page%s.', 'ward' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>' ); ?></p>

				<p><?php _e( 'Below is an example of an unordered list.', 'ward' ); ?></p>
				<ul>
					<li><?php _e( 'List item one', 'ward' ); ?></li>
					<li><?php _e( 'List item two', 'ward' ); ?></li>
					<li><?php _e( 'List item three', 'ward' ); ?></li>
					<li><?php _e( 'List item four', 'ward' ); ?></li>
				</ul>
			</aside>
		<?php endif; ?>
	</div><!-- #secondary.widget-area -->

	<?php
	/**
	 * The secondary/right sidebar widgetized area.
	 *
	 * Only appears if a widget has been added.
	 *
	 * @since 1.0.0
	 */
	if ( is_active_sidebar( 'second-sidebar' ) ) {
		?>
		<div id="tertiary" <?php bavotasan_second_sidebar_class(); ?> role="complementary">
			<?php dynamic_sidebar( 'second-sidebar' );?>
		</div><!-- #tertiary.widget-area -->
		<?php
	}
}