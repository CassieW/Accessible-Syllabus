<?php
class Bavotasan_Shortcodes {
	public function __construct() {
		// Process shortcodes in widgets
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'the_content', array( $this, 'clean_shortcodes' ) );

		// New shortcodes
		add_shortcode( 'button', array( $this, 'bavotasan_button_shortcode' ) );
		add_shortcode( 'alert', array( $this, 'bavotasan_alert_shortcode' ) );
		add_shortcode( 'label', array( $this, 'bavotasan_label_shortcode' ) );
		add_shortcode( 'badge', array( $this, 'bavotasan_badge_shortcode' ) );
		add_shortcode( 'jumbotron', array( $this, 'bavotasan_jumbotron_shortcode' ) );
		add_shortcode( 'image', array( $this, 'bavotasan_image_shortcode' ) );
		add_shortcode( 'author_info', array( $this, 'bavotasan_author_info_shortcode' ) );
		add_shortcode( 'columns', array( $this, 'bavotasan_columns_shortcode' ) );
		add_shortcode( 'carousel', array( $this, 'bavotasan_carousel_shortcode' ) );
		add_shortcode( 'carousel_image', array( $this, 'bavotasan_carousel_image_shortcode' ) );
		add_shortcode( 'tooltip', array( $this, 'bavotasan_tooltip_shortcode' ) );
		add_shortcode( 'tabs', array( $this, 'bavotasan_tabs_shortcode' ) );
		add_shortcode( 'tabs_nav', array( $this, 'bavotasan_tabs_nav_shortcode' ) );
		add_shortcode( 'tabs_nav_item', array( $this, 'bavotasan_tabs_nav_item_shortcode' ) );
		add_shortcode( 'tabs_content', array( $this, 'bavotasan_tabs_content_shortcode' ) );
		add_shortcode( 'tabs_content_item', array( $this, 'bavotasan_tabs_content_item_shortcode' ) );
		add_shortcode( 'widetext', array( $this, 'widetext_shortcode' ) );
	}

	public function clean_shortcodes( $content ){
	    return strtr( $content, array (
	        '<p>[' => '[',
	        ']</p>' => ']',
	        ']<br />' => ']'
	    ) );
	}

	####################
	##   SHORTCODES   ##
	####################

	// Button shortcode
	public function bavotasan_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'button',
			'id' => '',
			'style' => 'default',
			'size' => '',
			'href' => '',
			'text' => '',
		), $atts ) );
		$text = ( $text ) ? $text : trim( $content );
		$style = ( $style ) ? ' btn-' . $style : '';
		$size = ( $size ) ? ' btn-' . $size : '';
		$id = ( $id ) ? ' id="' . $id . '"' : '';
		if ( $href )
			return '<a href="' . esc_url( $href ) . '"' . $id . ' class="btn' . $style . $size . '">' . $text . '</a>';

		return '<button' . $id . ' type="' . $type . '" class="btn'. $style . $size . '">' . $text . '</button>';
	}

	// Alert shortcode
	public function bavotasan_alert_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'warning',
		), $atts ) );
		$style = ( $style ) ? ' alert-' . $style : '';

		return '<div class="alert'. $style . '">' . do_shortcode( trim( $content ) ) . '</div>';
	}

	// Label shortcode
	public function bavotasan_label_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'default',
		), $atts ) );
		$style = ( $style ) ? ' label-' . $style : '';

		return '<span class="label'. $style . '">' . trim( $content ) . '</span>';
	}

	// Badge shortcode
	public function bavotasan_badge_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => '',
		), $atts ) );
		$style = ( $style ) ? ' badge-' . $style : '';

		return '<span class="badge'. $style . '">' . trim( $content ) . '</span>';
	}

	// Jumbotron shortcode
	public function bavotasan_jumbotron_shortcode( $atts = null, $content = null ) {
		return '<div class="jumbotron">' . do_shortcode( trim( $content ) ) . '</div>';
	}

	// Image shortcode
	public function bavotasan_image_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'rounded',
		), $atts ) );

		return '<img src="' . trim( $content ) . '" alt="" class="img-' . $style . '" />';
	}

	// Author Info shortcode
	public function bavotasan_author_info_shortcode() {
		global $post;
		$author = $post->post_author;

		return '<div id="author-info" class="well">' . get_avatar( get_the_author_meta( 'email', $author ), '80' ) . '<div class="author-text"><h4>' . get_the_author_meta( 'display_name', $author ) . '</h4><p>' . get_the_author_meta( 'description', $author ) . '</p></div></div>';
	}

	// Columns shortcode
	public function bavotasan_columns_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'size' => '2',
			'gap' => '1em'
		), $atts ) );

		return '<div class="columns" style="-moz-column-count:' . $size . ';-webkit-column-count:' . $size . ';column-count:' . $size . ';-moz-column-gap:' . $gap . ';-webkit-column-gap:' . $gap . ';column-gap:' . $gap . '">' . do_shortcode( trim( $content ) ) . '</div>';
	}

	// Carousel shortcode
	public function bavotasan_carousel_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'interval' => '5000',
			'slide' => '',
			'id' => 'myCarousel'
		), $atts ) );

		return '<div id="' . esc_attr( $id ) . '" data-interval="' . esc_attr( $interval ) . '" class="carousel ' . esc_attr( $slide ) . '"><div class="carousel-inner">' . do_shortcode( trim( $content ) ) . '</div><a class="left carousel-control" href="#' . esc_attr( $id ) . '" data-slide="prev"><i class="fa fa-arrow-circle-left"></i></a><a class="right carousel-control" href="#' . esc_attr( $id ) . '" data-slide="next"><i class="fa fa-arrow-circle-right"></i></a></div>';
	}

	// Carousel Image shortcode
	public function bavotasan_carousel_image_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'caption' => '',
			'active' => ''
		), $atts ) );
		$caption = ( $caption ) ? '<p>' . $caption . '</p>' : '';
		$title = ( $title ) ? '<h3>' . $title . '</h3>' : '';
		$ticap = ( $title || $caption ) ? '<div class="carousel-caption">' . $title . $caption . '</div>' : '';

		return '<div class="item ' . $active . '"><img src="' . trim( $content ) . '" alt="" />' . $ticap . '</div>';
	}

	// Tooltip shortcode
	public function bavotasan_tooltip_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'tip' => '',
			'placement' => 'top'
		), $atts ) );

		return '<a href="#" rel="tooltip" data-placement="' . $placement . '" title="' . $tip . '">' . trim( $content ) . '</a>';
	}

	// Tabs shortcode
	public function bavotasan_tabs_shortcode( $atts, $content = null ) {
		return do_shortcode( trim( $content ) );
	}

	// Tabs Nav shortcode
	public function bavotasan_tabs_nav_shortcode( $atts, $content = null ) {
		return '<ul class="nav nav-tabs" id="myTab">' . do_shortcode( trim( $content ) ) . '</ul>';
	}

	// Tabs Nav Item shortcode
	public function bavotasan_tabs_nav_item_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'active' => '',
			'id' => ''
		), $atts ) );

		return '<li class="' . $active . '"><a href="#' . $id . '">' . do_shortcode( trim( $content ) ) . '</a></li>';
	}

	// Tabs content shortcode
	public function bavotasan_tabs_content_shortcode( $atts, $content = null ) {
		return '<div class="tab-content">' . do_shortcode( trim( $content ) ) . '</div>';
	}

	// Tabs Content Item shortcode
	public function bavotasan_tabs_content_item_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'active' => '',
			'id' => ''
		), $atts ) );

		return '<div class="tab-pane ' . $active . '" id="' . $id . '">' . do_shortcode( trim( $content ) ) . '</div>';
	}

	// Widetext shortcode
	public function widetext_shortcode( $atts = null, $content = null ) {
		return '<span class="widetext">' . trim( $content ) . '</span>';
	}
}
$bavotasan_shortcodes = new Bavotasan_Shortcodes;