<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 * and the left sidebar conditional
 *
 * @since 1.0.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if IE]><script src="<?php echo BAVOTASAN_THEME_URL; ?>/library/js/html5.js"></script><![endif]-->
	<?php wp_head(); ?>
</head>
<?php
$bavotasan_theme_options = bavotasan_theme_options();
$boxed = $bavotasan_theme_options['boxed'];

$boxed_class = ( $boxed ) ? 'boxed' : '';
?>
<body <?php body_class( $boxed_class ); ?>>

	<div id="page" class="clearfix">

		<header class="<?php echo $bavotasan_theme_options['nav_palette']; ?> navbar navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			          <span class="icon-bar"></span>
			          <span class="icon-bar"></span>
			          <span class="icon-bar"></span>
			        </button>

					<a id="site-title" class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?> <small><?php bloginfo( 'description' ); ?></small></a>
				</div>
				<h3 class="screen-reader-text"><?php _e( 'Main menu', 'ward' ); ?></h3>
				<a class="screen-reader-text" href="#primary" title="<?php esc_attr_e( 'Skip to content', 'ward' ); ?>"><?php _e( 'Skip to content', 'ward' ); ?></a>

				<div class="collapse navbar-collapse">
					<?php
					$social_class = ( is_rtl() ) ? ' navbar-left' : ' navbar-right';

					wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'menu_class' => 'nav navbar-nav', 'fallback_cb' => 'bavotasan_default_menu' ) );

					if ( has_nav_menu( 'social' ) )
						wp_nav_menu( array( 'theme_location' => 'social', 'container' => 'div', 'container_id' => 'menu-social', 'container_class' => 'menu' . $social_class, 'menu_id' => 'menu-social-items', 'menu_class' => 'menu-items', 'depth' => 1, 'link_before' => '<span class="sr-only">', 'link_after' => '</span>', 'fallback_cb' => '' ) );
					?>
				</div>
			</div>
		</header>

		<?php
		bavotasan_jumbotron();
		bavotasan_home_page_default_widgets();

		if ( is_singular() || is_404() || ( function_exists( 'is_bbpress' ) && is_bbpress() ) ) { ?>
			<main class="container">
				<div class="row">
		<?php } else { ?>
			<main>
			<?php
		}