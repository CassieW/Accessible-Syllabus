<?php
class Bavotasan_Documentation {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 1 );
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1 );
	}

	/**
	 * Add a 'Documentation' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @param	array $wp_admin_bar
	 *
	 * @since 1.0.0
	 */
	function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
			$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'bavotasan_documentation', 'title' => sprintf( __( 'About %s', 'ward' ), BAVOTASAN_THEME_NAME ), 'href' => admin_url( 'themes.php?page=bavotasan_documentation' ) ) );
	}

	/**
	 * Add a 'Documentation' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( sprintf( __( 'Welcome to %s %s', 'ward' ), BAVOTASAN_THEME_NAME, BAVOTASAN_THEME_VERSION ), sprintf( __( 'About %s', 'ward' ), BAVOTASAN_THEME_NAME ), 'edit_theme_options', 'bavotasan_documentation', array( $this, 'bavotasan_documentation' ) );
	}

	public function bavotasan_documentation() {
		?>
		<style>
		.featured-image {
			margin: 20px auto !important;
		}

		.about-wrap .dfw h3 {
			text-align: left;
		}

		.about-wrap .dfw h3,
		.about-wrap ul,
		.featured-image {
			max-width: 68%;
		}

		.about-wrap .dfw h3,
		.about-wrap ul {
			margin-left: auto;
			margin-right: auto;
		}

		.about-wrap ul {
			padding-left: 60px;
			list-style: disc;
			margin-bottom: 20px;
		}

		.about-wrap .theme-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		@media only screen and (max-width: 500px) {
			.featured-image,
			.about-wrap .dfw h3,
			.about-wrap ul {
				max-width: 90%;
			}

			.about-wrap .theme-badge {
				display: none;
			}
		}
		</style>
		<div class="wrap about-wrap" id="custom-background">
			<h1><?php echo get_admin_page_title(); ?></h1>

			<div class="about-text">
				<?php printf( __( 'Read through the following documentation to learn more about <em>%s</em> and how to use the available theme options. Or %scheck out the demo%s to see it in action.', 'ward' ), BAVOTASAN_THEME_NAME, '<a href="//demos.bavotasan.com/' . sanitize_title( BAVOTASAN_THEME_NAME ) . '">', '</a>' ); ?>
			</div>

			<div class="theme-badge">
				<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/screenshot_sml.jpg" />
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'The Customizer', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/customizer.jpg" />
				</div>

				<p><?php printf( __( 'All theme options for <em>%s</em> are controlled under %sAppearance &rarr; Customize%s. From there, you can modify layout, colors, custom menus, and more.', 'ward' ), BAVOTASAN_THEME_NAME, '<a href="' . admin_url( 'customize.php' ) . '">', '</a>' ); ?></p>

				<h3><?php _e( 'Boxed', 'ward' ); ?></h3>

				<p><?php _e( 'By default, the theme will have the Boxed option checked. That means your site will appear within a container on screens larger than the site width. Uncheck the box to turn this off.', 'ward' ); ?></p>

				<p><?php _e( 'You can set the background color for the space outside of your site in the Colors section of the Customizer.', 'ward' ); ?></p>

				<h3><?php _e( 'Site &amp; Main Content Width', 'ward' ); ?></h3>

				<p><?php _e( 'There are two width options for your site: 1200px &amp; 992px. You can select the width of your main content, based on a 12 column grid. Resizing your main content will also resize your sidebar. If two sidebars are displayed, you can select the width of the first sidebar as well.', 'ward' ); ?></p>

				<h3><?php _e( 'Sidebar Layout', 'ward' ); ?></h3>

				<p><?php printf( __( 'With the sidebar layout option, you can decide whether to display your sidebar(s) on the left or right of your main content. To display two sidebars, first add a widget to the second sidebar under %sAppearance &rarr; Widgets%s. Once that&rsquo;s done, the two-sidebar option will appear.', 'ward' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Custom Menus', 'ward' ); ?></h2>

				<p><?php printf( __( '<em>%s</em> includes two Custom Menu locations: the Primary top menu and the Social menu.', 'ward' ), BAVOTASAN_THEME_NAME ); ?></p>

				<p><?php printf( __( 'To add a navigation menu to the header, go to %sAppearance &rarr; Menus%s. By default, a list of categories will appear in this location if no custom menu is set.', 'ward' ), '<a href="' . admin_url( 'nav-menus.php' ) . '">', '</a>' ); ?></p>

				<p><?php _e( 'Clicking on a top-level link in the primary navigation will open up one dropdown list of sub-menu links.', 'ward' ); ?></p>

				<h3><?php _e( 'Social Menu', 'ward' ); ?></h3>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/social-menu-setup.jpg" />
				</div>

				<p><?php printf( __( 'To use the social menu, go to %sAppearance &rarr; Menus%s and create a new menu. Call it "Social" just to make it easy to remember. Use the Link panel on the left to add any of the following social sites:', 'ward' ), '<a href="' . admin_url( 'nav-menus.php' ) . '">', '</a>' ); ?></p>

				<ul>
					<li>Twitter</li>
					<li>Facebook</li>
					<li>Pinterest</li>
					<li>Google+</li>
					<li>Dribbble</li>
					<li>GitHub</li>
					<li>Tumblr</li>
					<li>YouTube</li>
					<li>Flickr</li>
					<li>Vimeo</li>
					<li>Instagram</li>
					<li>LinkedIn</li>
					<li>Bitbucket</li>
				</ul>

				<p><?php _e( 'Once you&rsquo;ve added the social sites you want with a link to each profile – like <code>https://twitter.com/bavotasan</code> – check the Social box at the bottom of the menu and click <strong>Save Menu</strong>. Your social links will now be displayed at the top right of your site.', 'ward' );?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Jumbo Headline', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/jumbo-headline.jpg" />
				</div>

				<p><?php printf( __( 'You can modify the Jumbo Headline text by going to %sAppearance &rarr; Customize%s. If you want to remove it completely, just delete each text field under the Jumbo Headline section.', 'ward' ), '<a href="' . admin_url( 'customize.php' ) . '">', '</a>' ); ?></p>

				<h3><?php _e( 'Icon', 'ward' ); ?></h3>
				<p><?php _e( 'You can choose from over 400 different Font Awesome icons to display in your Jumbo Headline. Click <strong>View Icons</strong> to see a list of all the available icons. Clicking on an icon will select it. To remove it, just click <strong>Remove Icon</strong>.', 'ward' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Home Page Top Area', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/home-page-widgets.jpg" />
				</div>

				<p><?php printf( __( 'The section where the four widgets appear on the homepage will only display once a widget is added to the Homepage Top Area in %sAppearance &rarr; Widgets%s. The demo uses the custom Image & Text widget that comes with <em>%s</em> to display an image accompanied by text. You can even have the image and text link to a page or a post, by adding a URL in the field provided.', 'ward' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>', BAVOTASAN_THEME_NAME ); ?></p>

				<p><?php _e( 'In order for your image to appear circular, be sure to upload a square image. The demo uses images that are 150px by 150px.', 'ward' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Jetpack', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/jetpack.jpg" />
				</div>

				<h3><?php _e( 'Infinite Scroll', 'ward' ); ?></h3>

				<p><?php printf( __( '%sJetpack&rsquo;s Infinite Scroll%s allows your visitors to view all your posts without having to click through to the next page. As they scroll, new posts will be added. To activate go to %sJetpack &rarr; Settings%s. ', 'ward' ), '<a href="//jetpack.me/support/infinite-scroll/">', '</a>', '<a href="' . admin_url( 'admin.php?page=jetpack_modules' ) . '">', '</a>' ); ?></p>

				<h3><?php _e( 'Tiled Galleries', 'ward' ); ?></h3>

				<p><?php printf( __( '%sJetpack&rsquo;s Tiled Galleries%s will display your images in a beautiful mosaic layout. Go to %sJetpack &rarr; Settings%s to turn it on. ', 'ward' ), '<a href="//jetpack.me/support/tiled-galleries/">', '</a>', '<a href="' . admin_url( 'admin.php?page=jetpack_modules' ) . '">', '</a>' ); ?></p>

				<h3><?php _e( 'Carousel', 'ward' ); ?></h3>

				<p><?php printf( __( 'With %sJetpack&rsquo;s Carousel%s, clicking on one of your gallery images will open up a featured lightbox slideshow. Turn it on by going to %sJetpack &rarr; Settings%s.', 'ward' ), '<a href="//jetpack.me/support/carousel/">', '</a>', '<a href="' . admin_url( 'admin.php?page=jetpack_modules' ) . '">', '</a>' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'The Extended Footer', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/extended-footer.jpg" />
				</div>

				<p><?php printf( __( 'To display widgets in your footer go to %sAppearance &rarr; Widgets%s and add at least one widget to the Extended Footer area.', 'ward' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>' ); ?></p>

				<p><?php _e( 'You can customize the copyright notice in the Footer section of the Customizer.', 'ward' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Shortcodes', 'ward' ); ?></h2>

				<p><?php printf( __( '<em>%s</em> comes with tons of great shortcodes to help spice up your posts and pages. Learn more by %schecking out the demo%s.', 'ward' ), BAVOTASAN_THEME_NAME, '<a href="//demos.bavotasan.com/' . sanitize_title( BAVOTASAN_THEME_NAME ) . '/shortcodes/">', '</a>' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Full-Width Post/Page', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/full-width-page.jpg" />
				</div>

				<p><?php _e( 'To set a full-width post or page, meaning one without any sidebars, check the box in the Layout panel when you&rsquo;re editing the post or page in the admin.', 'ward' ); ?></p>
			</div>
			<hr />

			<div class="changelog headline-feature dfw">
				<h2><?php _e( 'Pull Quotes', 'ward' ); ?></h2>

				<div class="featured-image dfw-container">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/pull-quotes.jpg" />
				</div>

				<p><?php _e( 'You can easily include a pull quote within your text by using the following code within the Text/HTML editor:', 'ward' ); ?></p>

				<p><code><?php _e( '&lt;blockquote class="pullquote"&gt;This is a pull quote that will appear within your text.&lt;/blockquote&gt;', 'ward' ); ?></code></p>
				<p><?php _e( 'You can also align it to the right with this code:', 'ward' ); ?></p>

				<p><code><?php _e( '&lt;blockquote class="pullquote alignright"&gt;This is a pull quote that will appear within your text.&lt;/blockquote&gt;', 'ward' ); ?></code></p>
			</div>
			<hr />

			<p><?php printf( __( 'For more information, check out the %sDocumentation &amp; FAQs%s section on my site.', 'ward' ), '<a href="//themes.bavotasan.com/documentation/" target="_blank">', '</a>' ); ?></p>
		</div>
		<?php
	}
}
$bavotasan_documentation = new Bavotasan_Documentation;