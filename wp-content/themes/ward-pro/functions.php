<?php
/**
 * Defining constants
 *
 * @since 1.0.0
 */
$bavotasan_theme_data = wp_get_theme();
define( 'BAVOTASAN_THEME_URL', get_template_directory_uri() );
define( 'BAVOTASAN_THEME_TEMPLATE', get_template_directory() );
define( 'BAVOTASAN_THEME_VERSION', trim( $bavotasan_theme_data->Version ) );
define( 'BAVOTASAN_THEME_NAME', $bavotasan_theme_data->Name );
define( 'BAVOTASAN_THEME_FILE', get_option( 'template' ) );
define( 'BAVOTASAN_THEME_CODE', 'war' );

/**
 * Includes
 *
 * @since 1.0.0
 */
require( BAVOTASAN_THEME_TEMPLATE . '/library/customizer.php' ); // Functions for theme options page
require( BAVOTASAN_THEME_TEMPLATE . '/library/custom-css-editor.php' ); // Custom CSS editor
require( BAVOTASAN_THEME_TEMPLATE . '/library/shortcodes.php' ); // Functions to add shortcodes
require( BAVOTASAN_THEME_TEMPLATE . '/library/import-export.php' ); // Functions for the import/export admin page
require( BAVOTASAN_THEME_TEMPLATE . '/library/custom-metaboxes.php' ); // Functions for home page alignment
require( BAVOTASAN_THEME_TEMPLATE . '/library/theme-updater.php' ); // Functions for update API
require( BAVOTASAN_THEME_TEMPLATE . '/library/about.php' ); // Functions for about page

/**
 * Prepare the content width
 *
 * @since 1.0.3
 */
function bavotasan_content_width() {
	$bavotasan_theme_options = bavotasan_theme_options();
	$bavotasan_array_content = array( 'col-md-2' => .1666, 'col-md-3' => .25, 'col-md-4' => .3333, 'col-md-5' => .4166, 'col-md-6' => .5, 'col-md-7' => .5833, 'col-md-8' => .6666, 'col-md-9' => .75, 'col-md-10' => .8333, 'col-md-12' => 1 );

    return round( $bavotasan_array_content[$bavotasan_theme_options['primary']] * $bavotasan_theme_options['width'] - 30 );
}

if ( ! isset( $content_width ) )
	$content_width = bavotasan_content_width();

add_action( 'template_redirect', 'bavotasan_content_width_adjust' );
/**
 * Adjust content_width value for image attachment template.
 *
 @ since 1.0.3
 */
function bavotasan_content_width_adjust() {
	if ( is_bavotasan_full_width() ) {
		$bavotasan_theme_options = bavotasan_theme_options();
		$GLOBALS['content_width'] = $bavotasan_theme_options['width'] - 30;
	}
}

add_action( 'after_setup_theme', 'bavotasan_setup' );
if ( ! function_exists( 'bavotasan_setup' ) ) :
/**
 * Initial setup
 *
 * This function is attached to the 'after_setup_theme' action hook.
 *
 * @uses	load_theme_textdomain()
 * @uses	get_locale()
 * @uses	BAVOTASAN_THEME_TEMPLATE
 * @uses	add_theme_support()
 * @uses	add_editor_style()
 * @uses	add_custom_background()
 * @uses	add_custom_image_header()
 * @uses	register_default_headers()
 *
 * @since 1.0.0
 */
function bavotasan_setup() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
		wp_redirect( admin_url( 'themes.php?page=bavotasan_documentation' ) ); // Your admin page URL

	load_theme_textdomain( 'ward', BAVOTASAN_THEME_TEMPLATE . '/library/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( 'library/css/admin/editor-style.css' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'ward' ) );
	register_nav_menu( 'social', __( 'Social', 'ward' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'audio', 'quote', 'link', 'status', 'aside' ) );

	// This theme uses Featured Images (also known as post thumbnails) for archive pages
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'home-page', 500, 400, true );

	// Add support for custom backgrounds
	add_theme_support( 'custom-background' );

	// Add HTML5 elements
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );

	// Add title tag support
	add_theme_support( 'title-tag' );

	// Infinite scroll
	add_theme_support( 'infinite-scroll', array(
	    'type' => 'click',
	    'container' => 'primary',
		'wrapper' => false,
	) );

	// Remove default gallery styles
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Add Woocommerce support
	add_theme_support( 'woocommerce' );
}
endif; // bavotasan_setup

add_action( 'wp_head', 'bavotasan_styles' );
/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the 'wp_head' action hook.
 *
 * @since 1.0.0
 */
function bavotasan_styles() {
	$bavotasan_theme_options = bavotasan_theme_options();
	?>
<style>
<?php if ( 'on' == $bavotasan_theme_options['boxed'] ) { ?>
.boxed #page { max-width: <?php echo $bavotasan_theme_options['width'] + 180; ?>px; }
.container { max-width: <?php echo $bavotasan_theme_options['width']; ?>px; }
<?php } else { ?>
.container { max-width: <?php echo $bavotasan_theme_options['width']; ?>px; }
<?php } ?>
#carousel-wrap { background-image: url(<?php echo get_header_image(); ?>); background-repeat: no-repeat; background-size: cover; }
a { color: <?php echo $bavotasan_theme_options['link_color']; ?>; }
a:hover { color: <?php echo $bavotasan_theme_options['link_hover_color']; ?>; }
body { <?php echo bavotasan_prepare_font( $bavotasan_theme_options['main_text_font'] ); ?>; }
main { color: <?php echo $bavotasan_theme_options['main_text_color']; ?>; }
h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: <?php echo $bavotasan_theme_options['headers_color']; ?>; <?php echo bavotasan_prepare_font( $bavotasan_theme_options['headers_font'] ); ?>; }
.entry-title, .entry-title a { <?php echo bavotasan_prepare_font( $bavotasan_theme_options['post_title_font'] ); ?>; }
.entry-meta, .entry-meta a { <?php echo bavotasan_prepare_font( $bavotasan_theme_options['post_meta_font'] ); ?>; }
.post-category, .post-category a, .post-format, post-format a, .page-title { <?php echo bavotasan_prepare_font( $bavotasan_theme_options['post_category_font'] ); ?>; }
.middle-circle { color: <?php echo $bavotasan_theme_options['widget_area_color']; ?>; }
#home-page-widgets { background-color: <?php echo $bavotasan_theme_options['widget_area_color']; ?>; }
<?php if ( $custom_css = get_option( 'ward_custom_css' ) ) { ?>
/* Custom CSS */
<?php echo strip_tags( $custom_css ) . "\n"; ?>
/* eof Custom CSS */
	<?php } ?>
</style>
	<?php
}

add_action( 'admin_bar_menu', 'bavotasan_admin_bar_menu', 999 );
/**
 * Add menu item to toolbar
 *
 * This function is attached to the 'admin_bar_menu' action hook.
 *
 * @param	array $wp_admin_bar
 *
 * @since 2.0.4
 */
function bavotasan_admin_bar_menu( $wp_admin_bar ) {
    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
    	$wp_admin_bar->add_node( array( 'id' => 'bavotasan_toolbar', 'title' => BAVOTASAN_THEME_NAME, 'href' => admin_url( 'themes.php?page=bavotasan_documentation' ) ) );
}

add_action( 'wp_enqueue_scripts', 'bavotasan_add_js' );
if ( ! function_exists( 'bavotasan_add_js' ) ) :
/**
 * Load all JavaScript to header
 *
 * This function is attached to the 'wp_enqueue_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	BAVOTASAN_THEME_URL
 *
 * @since 1.0.0
 */
function bavotasan_add_js() {
	$bavotasan_theme_options = bavotasan_theme_options();
	$slider_options = get_option( 'ward_slider_settings' );

	$var = array(
		'carousel' => false,
		'tooltip' => false,
		'tabs' => false
	);

	if ( is_singular() ) {
		if ( get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		global $post;
		$content = $post->post_content;
		if ( false !== strpos( $content, '[widetext' ) )
			wp_enqueue_script( 'widetext', BAVOTASAN_THEME_URL .'/library/js/widetext.min.js', array( 'jquery' ), '1.0.1', true );

		if ( false !== strpos( $content, '[carousel' ) )
			$var['carousel'] = true;

		if ( false !== strpos( $content, '[tooltip' ) )
			$var['tooltip'] = true;

		if ( false !== strpos( $content, '[tabs' ) )
			$var['tabs'] = true;
	}

	if ( is_front_page() && $slider_options['autoplay'] )
		$var['carousel'] = true;

	wp_enqueue_script( 'bootstrap', BAVOTASAN_THEME_URL .'/library/js/bootstrap.min.js', array( 'jquery' ), '3.0.0', true );

	wp_enqueue_script( 'theme_js', BAVOTASAN_THEME_URL .'/library/js/theme.js', array( 'bootstrap' ), '', true );
	wp_localize_script( 'theme_js', 'theme_js_vars', $var );
	wp_enqueue_style( 'theme_stylesheet', get_stylesheet_uri() );

	// Fonts stuff
	$selected_fonts = array(
		$bavotasan_theme_options['main_text_font'],
		$bavotasan_theme_options['headers_font'],
		$bavotasan_theme_options['post_title_font'],
		$bavotasan_theme_options['post_meta_font'],
		$bavotasan_theme_options['post_category_font'],
	);
	$selected_fonts = array_unique( $selected_fonts );

	$google_fonts = bavotasan_google_fonts();
	$font_string = '';
	foreach ( $selected_fonts as $font ) {
		$main_font = ( $font == $bavotasan_theme_options['main_text_font'] );
		$font = html_entity_decode( $font );
		if ( array_key_exists( $font, $google_fonts ) ) {
			$font = explode( ',', $font );
			$font = $font[0];
			switch( $font ) {
				case 'Lato':
					$font = 'Lato:400';
					break;
				case 'Lato Bold':
					$font = 'Lato:900';
					break;
				case 'Lato Light':
					$font = 'Lato:300';
					break;
				case 'Raleway':
					$font = 'Raleway:100';
					break;
				case 'Exo':
					$font = 'Exo:100';
					break;
				case 'Arvo Bold':
					$font = 'Arvo:900';
					break;
			}
			$font = str_replace( array( ' ', '"' ), array( '+', '' ), $font );
			$font = ( $main_font ) ? $font . ":400,400italic,700,700italic" : $font;
			$font_string .= $font . '|';
		}
	}
	if ( $font_string )
		wp_enqueue_style( 'google_fonts', '//fonts.googleapis.com/css?family=' . $font_string, false, null, 'all' );

	wp_enqueue_style( 'font_awesome', BAVOTASAN_THEME_URL .'/library/css/font-awesome.css', false, '4.3.0', 'all' );
}
endif; // bavotasan_add_js

add_action( 'widgets_init', 'bavotasan_widgets_init' );
if ( ! function_exists( 'bavotasan_widgets_init' ) ) :
/**
 * Creating the two sidebars
 *
 * This function is attached to the 'widgets_init' action hook.
 *
 * @uses	register_sidebar()
 *
 * @since 1.0.0
 */
function bavotasan_widgets_init() {
	$bavotasan_theme_options = bavotasan_theme_options();
	require( BAVOTASAN_THEME_TEMPLATE . '/library/widgets/widget-image-icon.php' ); // Custom Image/Icon Text widget

	register_sidebar( array(
		'name' => __( 'First Sidebar', 'ward' ),
		'id' => 'sidebar',
		'description' => __( 'This is the first sidebar widgetized area. All defaults widgets work great here.', 'ward' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Sidebar', 'ward' ),
		'id' => 'second-sidebar',
		'description' => __( 'This is the second sidebar widgetized area. All defaults widgets work great here.', 'ward' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Home Page Top Area', 'ward' ),
		'id' => 'home-page-top-area',
		'description' => __( 'Widgetized area on the home page directly below the navigation menu. Specifically designed for 4 text widgets. Must be turned on in the Layout options on the Theme Options admin page.', 'ward' ),
		'before_widget' => '<aside id="%1$s" class="home-widget col-md-3 %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="home-widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Extended Footer', 'ward' ),
		'id' => 'extended-footer',
		'description' => __( 'This is the extended footer widgetized area. Widgets will appear in three columns. All defaults widgets work great here.', 'ward' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget ' . $bavotasan_theme_options['extended_footer_columns'] . ' %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
endif; // bavotasan_widgets_init

if ( !function_exists( 'bavotasan_pagination' ) ) :
/**
 * Add pagination
 *
 * @uses	paginate_links()
 * @uses	add_query_arg()
 *
 * @since 1.0.0
 */
function bavotasan_pagination() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'ward' ); ?></h1>
					<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'ward' ) ); ?></div>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'ward' ) ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</nav><!-- .navigation -->
	<?php
}
endif; // bavotasan_pagination

if ( ! function_exists( 'bavotasan_comment' ) ) :
/**
 * Callback function for comments
 *
 * Referenced via wp_list_comments() in comments.php.
 *
 * @uses	get_avatar()
 * @uses	get_comment_author_link()
 * @uses	get_comment_date()
 * @uses	get_comment_time()
 * @uses	edit_comment_link()
 * @uses	comment_text()
 * @uses	comments_open()
 * @uses	comment_reply_link()
 *
 * @since 1.0.0
 */
function bavotasan_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '' :
		?>
		<li <?php comment_class(); ?>>
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link() . ' '; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf( __( '%1$s at %2$s', 'ward' ), get_comment_date(), get_comment_time() );
						edit_comment_link( __( '(edit)', 'ward' ), '  ', '' );
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) { echo '<em>' . __( 'Your comment is awaiting moderation.', 'ward' ) . '</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if ( $args['max_depth'] != $depth && comments_open() && 'pingback' != $comment->comment_type ) { ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php
			break;

		case 'pingback'  :
		case 'trackback' :
		?>
		<li id="comment-<?php comment_ID(); ?>" class="pingback">
			<div class="comment-body">
				<i class="fa fa-paper-clip"></i>
				<?php _e( 'Pingback:', 'ward' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', 'ward' ), ' ' ); ?>
			</div>
			<?php
			break;
	endswitch;
}
endif; // bavotasan_comment

add_filter( 'excerpt_more', 'bavotasan_excerpt' );
if ( ! function_exists( 'bavotasan_excerpt' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'excerpt_more' filter hook.
 *
 * @param	int $more
 *
 * @return	Custom excerpt ending
 *
	 * @since 1.0.0
 */
function bavotasan_excerpt( $more ) {
	return '&hellip;';
}
endif; // bavotasan_excerpt

add_filter( 'wp_trim_excerpt', 'bavotasan_excerpt_more' );
if ( ! function_exists( 'bavotasan_excerpt_more' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'wp_trim_excerpt' filter hook.
 *
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 1.0.0
 */
function bavotasan_excerpt_more( $text ) {
	$bavotasan_theme_options = bavotasan_theme_options();
	return '<p class="lead">' . $text . '</p><p class="more-link-p"><a class="btn btn-' . $bavotasan_theme_options['read_more_color'] . '" href="' . get_permalink( get_the_ID() ) . '">' . $bavotasan_theme_options['read_more'] . '</a></p>';
}
endif; // bavotasan_excerpt_more

add_filter( 'the_content_more_link', 'bavotasan_content_more_link', 10, 2 );
if ( ! function_exists( 'bavotasan_content_more_link' ) ) :
/**
 * Customize read more link for content
 *
 * This function is attached to the 'the_content_more_link' filter hook.
 *
 * @param	string $link
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 1.0.0
 */
function bavotasan_content_more_link( $link, $text ) {
	$bavotasan_theme_options = bavotasan_theme_options();
	return '<p class="more-link-p"><a class="btn btn-' . $bavotasan_theme_options['read_more_color'] . '" href="' . get_permalink( get_the_ID() ) . '">' . $text . '</a></p>';
}
endif; // bavotasan_content_more_link

add_filter( 'excerpt_length', 'bavotasan_excerpt_length', 999 );
if ( ! function_exists( 'bavotasan_excerpt_length' ) ) :
/**
 * Custom excerpt length
 *
 * This function is attached to the 'excerpt_length' filter hook.
 *
 * @param	int $length
 *
 * @return	Custom excerpt length
 *
 * @since 1.0.0
 */
function bavotasan_excerpt_length( $length ) {
	return 60;
}
endif; // bavotasan_excerpt_length

/**
 * Full width conditional check
 *
 * @since 1.0.0
 *
 * @return	boolean
 */
function is_bavotasan_full_width() {
	$single_layout = ( is_singular() ) ? get_post_meta( get_the_ID(), 'bavotasan_single_layout', true ) : '';
	if ( 'on' == $single_layout || is_home() || is_archive() || is_search() )
		return true;
}

/**
 * Create the required attributes for the #primary container
 *
 * @since 1.0.0
 */
function bavotasan_primary_attr() {
	$push = '';
	if ( is_bavotasan_full_width() ) {
		$class = 'col-sm-12';
	} else {
		$bavotasan_theme_options = bavotasan_theme_options();
		$primary = str_replace( 'col-md-', '', $bavotasan_theme_options['primary'] );
		$secondary = ( is_active_sidebar( 'second-sidebar' ) ) ? str_replace( 'col-md-', '', $bavotasan_theme_options['secondary'] ) : 12 - $primary;
		$tertiary = 12 - $primary - $secondary;
		$class = $bavotasan_theme_options['primary'];

		if ( is_active_sidebar( 'second-sidebar' ) ) {
			$push = ( 'left' == $bavotasan_theme_options['layout'] ) ? ' col-md-push-' . ( $secondary + $tertiary ) : '';
			$push = ( 'separate' == $bavotasan_theme_options['layout'] ) ? ' col-md-push-' . $secondary: $push;
		} else {
			$class = ( 'left' == $bavotasan_theme_options['layout'] ) ? $class . ' pull-right' : $class;
		}
	}
	echo 'class="' . esc_attr( $class ) . esc_attr( $push ) . '"';
}

/**
 * Create the required classes for the #secondary sidebar container
 *
 * @since 1.0.0
 */
function bavotasan_sidebar_class() {
	$bavotasan_theme_options = bavotasan_theme_options();
	$primary = str_replace( 'col-md-', '', $bavotasan_theme_options['primary'] );
	$pull = '';

	if ( is_active_sidebar( 'second-sidebar' ) ) {
		$class = $bavotasan_theme_options['secondary'];
		$pull = ( 'right' != $bavotasan_theme_options['layout'] ) ? ' col-md-pull-' . $primary : '';
	} else {
		$end = ( 'right' == $bavotasan_theme_options['layout'] ) ? ' end' : '';
		$class = 'col-md-' . ( 12 - $primary ) . $end;
	}

	echo 'class="' . esc_attr( $class ) . esc_attr( $pull ) . '"';
}

/**
 * Create the required classes for the #tertiary sidebar container
 *
 * @since 1.0.0
 */
function bavotasan_second_sidebar_class() {
	$bavotasan_theme_options = bavotasan_theme_options();
	$primary = str_replace( 'col-md-', '', $bavotasan_theme_options['primary'] );
	$secondary = str_replace( 'col-md-', '', $bavotasan_theme_options['secondary'] );
	$pull = ( 'left' == $bavotasan_theme_options['layout'] ) ? ' col-md-pull-' . $primary : '';

	$end = ( 'left' != $bavotasan_theme_options['layout'] ) ? ' end' : '';
	$class = 'col-md-' . ( 12 - $primary - $secondary ) . $end;

	echo 'class="' . esc_attr( $class ) . esc_attr( $pull ) . '"';
}

add_filter( 'next_posts_link_attributes', 'bavotasan_add_attr' );
add_filter( 'previous_posts_link_attributes', 'bavotasan_add_attr' );
/**
 * Add 'btn' class to previous and next posts links
 *
 * This function is attached to the 'next_posts_link_attributes' and 'previous_posts_link_attributes' filter hook.
 *
 * @param	string $format
 *
 * @return	Modified string
 *
 * @since 1.0.0
 */
function bavotasan_add_attr() {
	return 'class="btn btn-primary btn-lg"';
}

add_filter( 'next_post_link', 'bavotasan_add_class' );
add_filter( 'previous_post_link', 'bavotasan_add_class' );
add_filter( 'next_image_link', 'bavotasan_add_class' );
add_filter( 'previous_image_link', 'bavotasan_add_class' );
/**
 * Add 'btn' class to previous and next post links
 *
 * This function is attached to the 'next_post_link' and 'previous_post_link' filter hook.
 *
 * @param	string $format
 *
 * @return	Modified string
 *
 * @since 1.0.0
 */
function bavotasan_add_class( $format ){
	return str_replace( 'href=', 'class="btn btn-primary" href=', $format );
}

/**
 * Default menu
 *
 * Referenced via wp_nav_menu() in header.php.
 *
 * @since 1.0.0
 */
function bavotasan_default_menu( $args ) {
	extract( $args );

	$output = wp_list_categories( array(
		'title_li' => '',
		'echo' => 0,
		'number' => 5,
		'depth' => 1,
	) );
	echo "<ul class='" . $menu_class . "'>$output</ul>";
}

/**
 * Add bootstrap classes to menu items
 *
 * @since 1.0.0
 */
class Bavotasan_Page_Navigation_Walker extends Walker_Nav_Menu {
	function check_current( $classes ) {
		return preg_match( '/(current[-_])|active|dropdown/', $classes );
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );

		if ( $item->is_dropdown && ( $depth === 0 ) ) {
			$item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html );
			$item_html = str_replace( '</a>', ' <span class="caret"></span></a>', $item_html );
		} elseif ( stristr( $item_html, 'li class="divider' ) ) {
			$item_html = preg_replace( '/<a[^>]*>.*?<\/a>/iU', '', $item_html );
		} elseif ( stristr( $item_html, 'li class="nav-header' ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html );
		}

		$output .= $item_html;
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_dropdown = !empty( $children_elements[$element->ID] );

		if ( $element->is_dropdown ) {
			if ( $depth === 0 ) {
				$element->classes[] = 'dropdown';
			} elseif ( $depth > 0 ) {
				$element->classes[] = 'dropdown-submenu';
			}
		}
		$element->classes[] = ( $element->current || in_array( 'current-menu-parent', $element->classes ) ) ? 'active' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

add_filter( 'wp_nav_menu_args', 'bavotasan_nav_menu_args' );
/**
 * Set our new walker only if a menu is assigned and a child theme hasn't modified it to one level deep
 *
 * This function is attached to the 'wp_nav_menu_args' filter hook.
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 1.0.0
 */
function bavotasan_nav_menu_args( $args ) {
    if ( 1 !== $args[ 'depth' ] && has_nav_menu( 'primary' ) && 'primary' == $args[ 'theme_location' ] )
        $args[ 'walker' ] = new Bavotasan_Page_Navigation_Walker;

    return $args;
}

/**
 * Create the default widgets that are displayed in the home page top area
 *
 * @since 1.0.0
 */
function bavotasan_home_page_default_widgets() {
	global $paged;
	$bavotasan_theme_options = bavotasan_theme_options();
	if ( is_front_page() && 2 > $paged && is_active_sidebar( 'home-page-top-area' ) ) {
 		?>
	<div id="home-page-widgets">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar( 'home-page-top-area' ); ?>
			</div>
		</div>
	</div>
	<?php
	}
}

/**
 * Create the jumbo headline section on the home page
 *
 * @since 1.0.0
 */
function bavotasan_jumbotron() {
	$bavotasan_theme_options = bavotasan_theme_options();
	if ( ! empty( $bavotasan_theme_options['jumbo_headline_title'] ) ) {
	?>
	<div class="home-top">
		<div class="container">
			<div class="row">
				<div class="home-jumbotron jumbotron col-lg-10 col-lg-offset-1 col-sm-12">
					<h1><?php echo $bavotasan_theme_options['jumbo_headline_title']; ?></h1>
					<p class="lead"><?php echo $bavotasan_theme_options['jumbo_headline_text']; ?></p>
					<?php if ( ! empty( $bavotasan_theme_options['jumbo_headline_button_text'] ) ) { ?>
					<a class="btn btn-lg btn-<?php echo $bavotasan_theme_options['jumbo_headline_button_color']; ?>" href="<?php echo $bavotasan_theme_options['jumbo_headline_button_link']; ?>"><?php echo $bavotasan_theme_options['jumbo_headline_button_text']; ?></a>
					<?php } ?>
					<i class="middle-circle fa <?php echo $bavotasan_theme_options['widget_area_icon']; ?>"></i>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
}

/**
 * Gathers icons from Font Awesome stylesheet
 *
 * @since 1.0.8
 */
function bavotasan_font_awesome_icons( $display_name = true ) {
	$icons = array( 'fa-glass' => '\f000', 'fa-music' => '\f001', 'fa-search' => '\f002', 'fa-envelope-o' => '\f003', 'fa-heart' => '\f004', 'fa-star' => '\f005', 'fa-star-o' => '\f006', 'fa-user' => '\f007', 'fa-film' => '\f008', 'fa-th-large' => '\f009', 'fa-th' => '\f00a', 'fa-th-list' => '\f00b', 'fa-check' => '\f00c', 'fa-times' => '\f00d', 'fa-search-plus' => '\f00e', 'fa-search-minus' => '\f010', 'fa-power-off' => '\f011', 'fa-signal' => '\f012', 'fa-cog' => '\f013', 'fa-trash-o' => '\f014', 'fa-home' => '\f015', 'fa-file-o' => '\f016', 'fa-clock-o' => '\f017', 'fa-road' => '\f018', 'fa-download' => '\f019', 'fa-arrow-circle-o-down' => '\f01a', 'fa-arrow-circle-o-up' => '\f01b', 'fa-inbox' => '\f01c', 'fa-play-circle-o' => '\f01d', 'fa-repeat' => '\f01e', 'fa-refresh' => '\f021', 'fa-list-alt' => '\f022', 'fa-lock' => '\f023', 'fa-flag' => '\f024', 'fa-headphones' => '\f025', 'fa-volume-off' => '\f026', 'fa-volume-down' => '\f027', 'fa-volume-up' => '\f028', 'fa-qrcode' => '\f029', 'fa-barcode' => '\f02a', 'fa-tag' => '\f02b', 'fa-tags' => '\f02c', 'fa-book' => '\f02d', 'fa-bookmark' => '\f02e', 'fa-print' => '\f02f', 'fa-camera' => '\f030', 'fa-font' => '\f031', 'fa-bold' => '\f032', 'fa-italic' => '\f033', 'fa-text-height' => '\f034', 'fa-text-width' => '\f035', 'fa-align-left' => '\f036', 'fa-align-center' => '\f037', 'fa-align-right' => '\f038', 'fa-align-justify' => '\f039', 'fa-list' => '\f03a', 'fa-outdent' => '\f03b', 'fa-indent' => '\f03c', 'fa-video-camera' => '\f03d', 'fa-picture-o' => '\f03e', 'fa-pencil' => '\f040', 'fa-map-marker' => '\f041', 'fa-adjust' => '\f042', 'fa-tint' => '\f043', 'fa-pencil-square-o' => '\f044', 'fa-share-square-o' => '\f045', 'fa-check-square-o' => '\f046', 'fa-arrows' => '\f047', 'fa-step-backward' => '\f048', 'fa-fast-backward' => '\f049', 'fa-backward' => '\f04a', 'fa-play' => '\f04b', 'fa-pause' => '\f04c', 'fa-stop' => '\f04d', 'fa-forward' => '\f04e', 'fa-fast-forward' => '\f050', 'fa-step-forward' => '\f051', 'fa-eject' => '\f052', 'fa-chevron-left' => '\f053', 'fa-chevron-right' => '\f054', 'fa-plus-circle' => '\f055', 'fa-minus-circle' => '\f056', 'fa-times-circle' => '\f057', 'fa-check-circle' => '\f058', 'fa-question-circle' => '\f059', 'fa-info-circle' => '\f05a', 'fa-crosshairs' => '\f05b', 'fa-times-circle-o' => '\f05c', 'fa-check-circle-o' => '\f05d', 'fa-ban' => '\f05e', 'fa-arrow-left' => '\f060', 'fa-arrow-right' => '\f061', 'fa-arrow-up' => '\f062', 'fa-arrow-down' => '\f063', 'fa-share' => '\f064', 'fa-expand' => '\f065', 'fa-compress' => '\f066', 'fa-plus' => '\f067', 'fa-minus' => '\f068', 'fa-asterisk' => '\f069', 'fa-exclamation-circle' => '\f06a', 'fa-gift' => '\f06b', 'fa-leaf' => '\f06c', 'fa-fire' => '\f06d', 'fa-eye' => '\f06e', 'fa-eye-slash' => '\f070', 'fa-exclamation-triangle' => '\f071', 'fa-plane' => '\f072', 'fa-calendar' => '\f073', 'fa-random' => '\f074', 'fa-comment' => '\f075', 'fa-magnet' => '\f076', 'fa-chevron-up' => '\f077', 'fa-chevron-down' => '\f078', 'fa-retweet' => '\f079', 'fa-shopping-cart' => '\f07a', 'fa-folder' => '\f07b', 'fa-folder-open' => '\f07c', 'fa-arrows-v' => '\f07d', 'fa-arrows-h' => '\f07e', 'fa-bar-chart' => '\f080', 'fa-twitter-square' => '\f081', 'fa-facebook-square' => '\f082', 'fa-camera-retro' => '\f083', 'fa-key' => '\f084', 'fa-cogs' => '\f085', 'fa-comments' => '\f086', 'fa-thumbs-o-up' => '\f087', 'fa-thumbs-o-down' => '\f088', 'fa-star-half' => '\f089', 'fa-heart-o' => '\f08a', 'fa-sign-out' => '\f08b', 'fa-linkedin-square' => '\f08c', 'fa-thumb-tack' => '\f08d', 'fa-external-link' => '\f08e', 'fa-sign-in' => '\f090', 'fa-trophy' => '\f091', 'fa-github-square' => '\f092', 'fa-upload' => '\f093', 'fa-lemon-o' => '\f094', 'fa-phone' => '\f095', 'fa-square-o' => '\f096', 'fa-bookmark-o' => '\f097', 'fa-phone-square' => '\f098', 'fa-twitter' => '\f099', 'fa-facebook' => '\f09a', 'fa-github' => '\f09b', 'fa-unlock' => '\f09c', 'fa-credit-card' => '\f09d', 'fa-rss' => '\f09e', 'fa-hdd-o' => '\f0a0', 'fa-bullhorn' => '\f0a1', 'fa-bell' => '\f0f3', 'fa-certificate' => '\f0a3', 'fa-hand-o-right' => '\f0a4', 'fa-hand-o-left' => '\f0a5', 'fa-hand-o-up' => '\f0a6', 'fa-hand-o-down' => '\f0a7', 'fa-arrow-circle-left' => '\f0a8', 'fa-arrow-circle-right' => '\f0a9', 'fa-arrow-circle-up' => '\f0aa', 'fa-arrow-circle-down' => '\f0ab', 'fa-globe' => '\f0ac', 'fa-wrench' => '\f0ad', 'fa-tasks' => '\f0ae', 'fa-filter' => '\f0b0', 'fa-briefcase' => '\f0b1', 'fa-arrows-alt' => '\f0b2', 'fa-users' => '\f0c0', 'fa-link' => '\f0c1', 'fa-cloud' => '\f0c2', 'fa-flask' => '\f0c3', 'fa-scissors' => '\f0c4', 'fa-files-o' => '\f0c5', 'fa-paperclip' => '\f0c6', 'fa-floppy-o' => '\f0c7', 'fa-square' => '\f0c8', 'fa-bars' => '\f0c9', 'fa-list-ul' => '\f0ca', 'fa-list-ol' => '\f0cb', 'fa-strikethrough' => '\f0cc', 'fa-underline' => '\f0cd', 'fa-table' => '\f0ce', 'fa-magic' => '\f0d0', 'fa-truck' => '\f0d1', 'fa-pinterest' => '\f0d2', 'fa-pinterest-square' => '\f0d3', 'fa-google-plus-square' => '\f0d4', 'fa-google-plus' => '\f0d5', 'fa-money' => '\f0d6', 'fa-caret-down' => '\f0d7', 'fa-caret-up' => '\f0d8', 'fa-caret-left' => '\f0d9', 'fa-caret-right' => '\f0da', 'fa-columns' => '\f0db', 'fa-sort' => '\f0dc', 'fa-sort-desc' => '\f0dd', 'fa-sort-asc' => '\f0de', 'fa-envelope' => '\f0e0', 'fa-linkedin' => '\f0e1', 'fa-undo' => '\f0e2', 'fa-gavel' => '\f0e3', 'fa-tachometer' => '\f0e4', 'fa-comment-o' => '\f0e5', 'fa-comments-o' => '\f0e6', 'fa-bolt' => '\f0e7', 'fa-sitemap' => '\f0e8', 'fa-umbrella' => '\f0e9', 'fa-clipboard' => '\f0ea', 'fa-lightbulb-o' => '\f0eb', 'fa-exchange' => '\f0ec', 'fa-cloud-download' => '\f0ed', 'fa-cloud-upload' => '\f0ee', 'fa-user-md' => '\f0f0', 'fa-stethoscope' => '\f0f1', 'fa-suitcase' => '\f0f2', 'fa-bell-o' => '\f0a2', 'fa-coffee' => '\f0f4', 'fa-cutlery' => '\f0f5', 'fa-file-text-o' => '\f0f6', 'fa-building-o' => '\f0f7', 'fa-hospital-o' => '\f0f8', 'fa-ambulance' => '\f0f9', 'fa-medkit' => '\f0fa', 'fa-fighter-jet' => '\f0fb', 'fa-beer' => '\f0fc', 'fa-h-square' => '\f0fd', 'fa-plus-square' => '\f0fe', 'fa-angle-double-left' => '\f100', 'fa-angle-double-right' => '\f101', 'fa-angle-double-up' => '\f102', 'fa-angle-double-down' => '\f103', 'fa-angle-left' => '\f104', 'fa-angle-right' => '\f105', 'fa-angle-up' => '\f106', 'fa-angle-down' => '\f107', 'fa-desktop' => '\f108', 'fa-laptop' => '\f109', 'fa-tablet' => '\f10a', 'fa-mobile' => '\f10b', 'fa-circle-o' => '\f10c', 'fa-quote-left' => '\f10d', 'fa-quote-right' => '\f10e', 'fa-spinner' => '\f110', 'fa-circle' => '\f111', 'fa-reply' => '\f112', 'fa-github-alt' => '\f113', 'fa-folder-o' => '\f114', 'fa-folder-open-o' => '\f115', 'fa-smile-o' => '\f118', 'fa-frown-o' => '\f119', 'fa-meh-o' => '\f11a', 'fa-gamepad' => '\f11b', 'fa-keyboard-o' => '\f11c', 'fa-flag-o' => '\f11d', 'fa-flag-checkered' => '\f11e', 'fa-terminal' => '\f120', 'fa-code' => '\f121', 'fa-reply-all' => '\f122', 'fa-star-half-o' => '\f123', 'fa-location-arrow' => '\f124', 'fa-crop' => '\f125', 'fa-code-fork' => '\f126', 'fa-chain-broken' => '\f127', 'fa-question' => '\f128', 'fa-info' => '\f129', 'fa-exclamation' => '\f12a', 'fa-superscript' => '\f12b', 'fa-subscript' => '\f12c', 'fa-eraser' => '\f12d', 'fa-puzzle-piece' => '\f12e', 'fa-microphone' => '\f130', 'fa-microphone-slash' => '\f131', 'fa-shield' => '\f132', 'fa-calendar-o' => '\f133', 'fa-fire-extinguisher' => '\f134', 'fa-rocket' => '\f135', 'fa-maxcdn' => '\f136', 'fa-chevron-circle-left' => '\f137', 'fa-chevron-circle-right' => '\f138', 'fa-chevron-circle-up' => '\f139', 'fa-chevron-circle-down' => '\f13a', 'fa-html5' => '\f13b', 'fa-css3' => '\f13c', 'fa-anchor' => '\f13d', 'fa-unlock-alt' => '\f13e', 'fa-bullseye' => '\f140', 'fa-ellipsis-h' => '\f141', 'fa-ellipsis-v' => '\f142', 'fa-rss-square' => '\f143', 'fa-play-circle' => '\f144', 'fa-ticket' => '\f145', 'fa-minus-square' => '\f146', 'fa-minus-square-o' => '\f147', 'fa-level-up' => '\f148', 'fa-level-down' => '\f149', 'fa-check-square' => '\f14a', 'fa-pencil-square' => '\f14b', 'fa-external-link-square' => '\f14c', 'fa-share-square' => '\f14d', 'fa-compass' => '\f14e', 'fa-caret-square-o-down' => '\f150', 'fa-caret-square-o-up' => '\f151', 'fa-caret-square-o-right' => '\f152', 'fa-eur' => '\f153', 'fa-gbp' => '\f154', 'fa-usd' => '\f155', 'fa-inr' => '\f156', 'fa-jpy' => '\f157', 'fa-rub' => '\f158', 'fa-krw' => '\f159', 'fa-btc' => '\f15a', 'fa-file' => '\f15b', 'fa-file-text' => '\f15c', 'fa-sort-alpha-asc' => '\f15d', 'fa-sort-alpha-desc' => '\f15e', 'fa-sort-amount-asc' => '\f160', 'fa-sort-amount-desc' => '\f161', 'fa-sort-numeric-asc' => '\f162', 'fa-sort-numeric-desc' => '\f163', 'fa-thumbs-up' => '\f164', 'fa-thumbs-down' => '\f165', 'fa-youtube-square' => '\f166', 'fa-youtube' => '\f167', 'fa-xing' => '\f168', 'fa-xing-square' => '\f169', 'fa-youtube-play' => '\f16a', 'fa-dropbox' => '\f16b', 'fa-stack-overflow' => '\f16c', 'fa-instagram' => '\f16d', 'fa-flickr' => '\f16e', 'fa-adn' => '\f170', 'fa-bitbucket' => '\f171', 'fa-bitbucket-square' => '\f172', 'fa-tumblr' => '\f173', 'fa-tumblr-square' => '\f174', 'fa-long-arrow-down' => '\f175', 'fa-long-arrow-up' => '\f176', 'fa-long-arrow-left' => '\f177', 'fa-long-arrow-right' => '\f178', 'fa-apple' => '\f179', 'fa-windows' => '\f17a', 'fa-android' => '\f17b', 'fa-linux' => '\f17c', 'fa-dribbble' => '\f17d', 'fa-skype' => '\f17e', 'fa-foursquare' => '\f180', 'fa-trello' => '\f181', 'fa-female' => '\f182', 'fa-male' => '\f183', 'fa-gratipay' => '\f184', 'fa-sun-o' => '\f185', 'fa-moon-o' => '\f186', 'fa-archive' => '\f187', 'fa-bug' => '\f188', 'fa-vk' => '\f189', 'fa-weibo' => '\f18a', 'fa-renren' => '\f18b', 'fa-pagelines' => '\f18c', 'fa-stack-exchange' => '\f18d', 'fa-arrow-circle-o-right' => '\f18e', 'fa-arrow-circle-o-left' => '\f190', 'fa-caret-square-o-left' => '\f191', 'fa-dot-circle-o' => '\f192', 'fa-wheelchair' => '\f193', 'fa-vimeo-square' => '\f194', 'fa-try' => '\f195', 'fa-plus-square-o' => '\f196', 'fa-space-shuttle' => '\f197', 'fa-slack' => '\f198', 'fa-envelope-square' => '\f199', 'fa-wordpress' => '\f19a', 'fa-openid' => '\f19b', 'fa-university' => '\f19c', 'fa-graduation-cap' => '\f19d', 'fa-yahoo' => '\f19e', 'fa-google' => '\f1a0', 'fa-reddit' => '\f1a1', 'fa-reddit-square' => '\f1a2', 'fa-stumbleupon-circle' => '\f1a3', 'fa-stumbleupon' => '\f1a4', 'fa-delicious' => '\f1a5', 'fa-digg' => '\f1a6', 'fa-pied-piper' => '\f1a7', 'fa-pied-piper-alt' => '\f1a8', 'fa-drupal' => '\f1a9', 'fa-joomla' => '\f1aa', 'fa-language' => '\f1ab', 'fa-fax' => '\f1ac', 'fa-building' => '\f1ad', 'fa-child' => '\f1ae', 'fa-paw' => '\f1b0', 'fa-spoon' => '\f1b1', 'fa-cube' => '\f1b2', 'fa-cubes' => '\f1b3', 'fa-behance' => '\f1b4', 'fa-behance-square' => '\f1b5', 'fa-steam' => '\f1b6', 'fa-steam-square' => '\f1b7', 'fa-recycle' => '\f1b8', 'fa-car' => '\f1b9', 'fa-taxi' => '\f1ba', 'fa-tree' => '\f1bb', 'fa-spotify' => '\f1bc', 'fa-deviantart' => '\f1bd', 'fa-soundcloud' => '\f1be', 'fa-database' => '\f1c0', 'fa-file-pdf-o' => '\f1c1', 'fa-file-word-o' => '\f1c2', 'fa-file-excel-o' => '\f1c3', 'fa-file-powerpoint-o' => '\f1c4', 'fa-file-image-o' => '\f1c5', 'fa-file-archive-o' => '\f1c6', 'fa-file-audio-o' => '\f1c7', 'fa-file-video-o' => '\f1c8', 'fa-file-code-o' => '\f1c9', 'fa-vine' => '\f1ca', 'fa-codepen' => '\f1cb', 'fa-jsfiddle' => '\f1cc', 'fa-life-ring' => '\f1cd', 'fa-circle-o-notch' => '\f1ce', 'fa-rebel' => '\f1d0', 'fa-empire' => '\f1d1', 'fa-git-square' => '\f1d2', 'fa-git' => '\f1d3', 'fa-hacker-news' => '\f1d4', 'fa-tencent-weibo' => '\f1d5', 'fa-qq' => '\f1d6', 'fa-weixin' => '\f1d7', 'fa-paper-plane' => '\f1d8', 'fa-paper-plane-o' => '\f1d9', 'fa-history' => '\f1da', 'fa-circle-thin' => '\f1db', 'fa-header' => '\f1dc', 'fa-paragraph' => '\f1dd', 'fa-sliders' => '\f1de', 'fa-share-alt' => '\f1e0', 'fa-share-alt-square' => '\f1e1', 'fa-bomb' => '\f1e2', 'fa-futbol-o' => '\f1e3', 'fa-tty' => '\f1e4', 'fa-binoculars' => '\f1e5', 'fa-plug' => '\f1e6', 'fa-slideshare' => '\f1e7', 'fa-twitch' => '\f1e8', 'fa-yelp' => '\f1e9', 'fa-newspaper-o' => '\f1ea', 'fa-wifi' => '\f1eb', 'fa-calculator' => '\f1ec', 'fa-paypal' => '\f1ed', 'fa-google-wallet' => '\f1ee', 'fa-cc-visa' => '\f1f0', 'fa-cc-mastercard' => '\f1f1', 'fa-cc-discover' => '\f1f2', 'fa-cc-amex' => '\f1f3', 'fa-cc-paypal' => '\f1f4', 'fa-cc-stripe' => '\f1f5', 'fa-bell-slash' => '\f1f6', 'fa-bell-slash-o' => '\f1f7', 'fa-trash' => '\f1f8', 'fa-copyright' => '\f1f9', 'fa-at' => '\f1fa', 'fa-eyedropper' => '\f1fb', 'fa-paint-brush' => '\f1fc', 'fa-birthday-cake' => '\f1fd', 'fa-area-chart' => '\f1fe', 'fa-pie-chart' => '\f200', 'fa-line-chart' => '\f201', 'fa-lastfm' => '\f202', 'fa-lastfm-square' => '\f203', 'fa-toggle-off' => '\f204', 'fa-toggle-on' => '\f205', 'fa-bicycle' => '\f206', 'fa-bus' => '\f207', 'fa-ioxhost' => '\f208', 'fa-angellist' => '\f209', 'fa-cc' => '\f20a', 'fa-ils' => '\f20b', 'fa-meanpath' => '\f20c', 'fa-buysellads' => '\f20d', 'fa-connectdevelop' => '\f20e', 'fa-dashcube' => '\f210', 'fa-forumbee' => '\f211', 'fa-leanpub' => '\f212', 'fa-sellsy' => '\f213', 'fa-shirtsinbulk' => '\f214', 'fa-simplybuilt' => '\f215', 'fa-skyatlas' => '\f216', 'fa-cart-plus' => '\f217', 'fa-cart-arrow-down' => '\f218', 'fa-diamond' => '\f219', 'fa-ship' => '\f21a', 'fa-user-secret' => '\f21b', 'fa-motorcycle' => '\f21c', 'fa-street-view' => '\f21d', 'fa-heartbeat' => '\f21e', 'fa-venus' => '\f221', 'fa-mars' => '\f222', 'fa-mercury' => '\f223', 'fa-transgender' => '\f224', 'fa-transgender-alt' => '\f225', 'fa-venus-double' => '\f226', 'fa-mars-double' => '\f227', 'fa-venus-mars' => '\f228', 'fa-mars-stroke' => '\f229', 'fa-mars-stroke-v' => '\f22a', 'fa-mars-stroke-h' => '\f22b', 'fa-neuter' => '\f22c', 'fa-facebook-official' => '\f230', 'fa-pinterest-p' => '\f231', 'fa-whatsapp' => '\f232', 'fa-server' => '\f233', 'fa-user-plus' => '\f234', 'fa-user-times' => '\f235', 'fa-bed' => '\f236', 'fa-viacoin' => '\f237', 'fa-train' => '\f238', 'fa-subway' => '\f239', 'fa-medium' => '\f23a' );
	?>
	<div class="font-awesome-picker">
		<?php
		foreach ( $icons as $icon => $code ) {
			?>
			<div class="c4" data-value="<?php echo $icon; ?>"><div><i class="fa <?php echo $icon; ?>"></i><?php if ( $display_name ) echo $icon; ?></div></div>
			<?php
		}
		?>
	</div>
	<?php
}

/**
 * Woocommerce compatibility
 *
 * @since 1.0.8
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action('woocommerce_before_main_content', 'bavotasan_wrapper_start', 10 );
function bavotasan_wrapper_start() {
	?>
	<div class="container">
		<div class="row">
			<div id="primary" class="col-md-12">
	<?php
}

add_action('woocommerce_after_main_content', 'bavotasan_wrapper_end', 10 );
function bavotasan_wrapper_end() {
	?>
			</div>
		</div>
	</div>
	<?php
}