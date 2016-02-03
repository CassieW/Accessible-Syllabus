<?php
/**
 * Set up the default theme options
 *
 * @since 1.0.0
 */
function bavotasan_theme_options() {
	//delete_option( 'ward_pro_theme_options' );
	if ( ! $options = get_option( 'ward_pro_theme_options' ) ) {
		$options = array(
			'width' => '1200',
			'boxed' => 'on',
			'layout' => 'right',
			'primary' => 'col-md-8',
			'secondary' => 'col-md-2',
			'display_author' => 'on',
			'display_date' => 'on',
			'display_comment_count' => 'on',
			'display_categories' => '',
			'link_color' => '#428BCA',
			'link_hover_color' => '#2A6496',
			'main_text_color' => '#999',
			'nav_palette' => 'navbar-inverse',
			'headers_color' => '#333',
			'widget_area_color' => '#F0AD4E',
			'widget_area_icon' => 'fa-off',
			'excerpt_content' => 'excerpt',
			'read_more' => 'Read more',
			'read_more_color' => 'warning',
			'extended_footer_columns' => 'col-md-3',
			'copyright' => 'Copyright &copy; ' . date( 'Y' ) . ' <a href="' . home_url() . '">' . get_bloginfo( 'name' ) .'</a>. All Rights Reserved.',
			'main_text_font' => '"Helvetica Neue", Helvetica, sans-serif',
			'headers_font' => 'Lato, sans-serif',
			'post_title_font' => 'Raleway, cursive',
			'post_meta_font' => '"Helvetica Neue", Helvetica, sans-serif',
			'post_category_font' => 'Lato Light, sans-serif',
			'jumbo_headline_title' => 'Jumbo Headline!',
			'jumbo_headline_text' => 'Got something important to say? Then make it stand out by using the jumbo headline option and get your visitor\'s attention right away.',
			'jumbo_headline_button_text' => 'Learn More',
			'jumbo_headline_button_link' => '#',
			'jumbo_headline_button_color' => 'danger',

		);
		add_option( 'ward_pro_theme_options', $options );
	}

	return $options;
}

if ( class_exists( 'WP_Customize_Control' ) ) {
	class Bavotasan_Icon_Select_Control extends WP_Customize_Control {
		public function render_content() {
			?>
			<div id="widgets-right" class="widget-content">
			<label class="customize-control-select"><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="custom-icon-container"><i class="fa <?php echo esc_attr( $this->value() ); ?>"></i></span>
				<input type="hidden" class="image-widget-custom-icon" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
				<a href="#" class="view-icons"><?php _e( 'View Icons', 'ward' ); ?></a> | <a href="#" class="delete-icon"><?php _e( 'Remove Icon', 'ward' ); ?></a>
				<?php bavotasan_font_awesome_icons( false ); ?>
			</label>
			</div>
			<?php
		}
	}

	class Bavotasan_Post_Layout_Control extends WP_Customize_Control {
	    public function render_content() {
			if ( empty( $this->choices ) )
				return;

			$name = '_customize-radio-' . $this->id;

			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
			foreach ( $this->choices as $value => $label ) :
				?>
				<label>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<?php
					$value = ( is_active_sidebar( 'second-sidebar' ) ) ? $value . ' second-sidebar' : $value;
					echo '<div class="' . esc_attr( $value ) . '"></div>'; ?>
				</label>
				<?php
			endforeach;
			echo '<p class="description">' . sprintf( __( 'For layout options with two sidebars, add at least one widget to the Second Sidebar area on the %sWidgets admin page%s.', 'ward' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ) . '</p>';
	    }
	}
}

class Bavotasan_Customizer {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_sidebar' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
		add_action( 'customize_controls_print_styles', array( $this, 'customize_controls_print_styles' ) );
	}

	public function customize_preview_init() {
		wp_enqueue_script( 'bavotasan_customizer', BAVOTASAN_THEME_URL . '/library/js/admin/customizer.js', array( 'jquery', 'customize-preview' ), '', true );
	}

	public function customize_controls_print_styles() {
		wp_enqueue_script( 'bavotasan_image_widget', BAVOTASAN_THEME_URL . '/library/js/admin/image-widget.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'bavotasan_image_widget_css', BAVOTASAN_THEME_URL . '/library/css/admin/image-widget.css' );
		wp_enqueue_style( 'font_awesome', BAVOTASAN_THEME_URL .'/library/css/font-awesome.css', false, '4.3.0', 'all' );
	}

	/**
	 * Add a 'customize' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'customize_theme', 'title' => __( 'Customize', 'ward' ), 'href' => admin_url( 'customize.php' ) ) );
	}

	/**
	 * Adds theme options to the Customizer screen
	 *
	 * This function is attached to the 'customize_register' action hook.
	 *
	 * @param	class $wp_customize
	 *
	 * @since 1.0.0
	 */
	public function customize_register( $wp_customize ) {
		$bavotasan_theme_options = bavotasan_theme_options();

		// Layout section panel
		$wp_customize->add_section( 'bavotasan_layout', array(
			'title' => __( 'Layout', 'ward' ),
			'priority' => 35,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[boxed]', array(
			'default' => $bavotasan_theme_options['boxed'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_boxed', array(
			'label' => __( 'Boxed', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[boxed]',
			'type' => 'checkbox',
			'priority' => 5,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[width]', array(
			'default' => $bavotasan_theme_options['width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_width', array(
			'label' => __( 'Site Width', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[width]',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'1200' => __( '1200px', 'ward' ),
				'992' => __( '992px', 'ward' ),
			),
		) );

		$choices =  array(
			'col-md-2' => '17%',
			'col-md-3' => '25%',
			'col-md-4' => '34%',
			'col-md-5' => '42%',
			'col-md-6' => '50%',
			'col-md-7' => '58%',
			'col-md-8' => '66%',
			'col-md-9' => '75%',
			'col-md-10' => '83%',
		);

		$wp_customize->add_setting( 'ward_pro_theme_options[primary]', array(
			'default' => $bavotasan_theme_options['primary'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_primary_column', array(
			'label' => __( 'Main Content', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[primary]',
			'priority' => 15,
			'type' => 'select',
			'choices' => $choices,
		) );

		if ( is_active_sidebar( 'second-sidebar' ) ) {
			$wp_customize->add_setting( 'ward_pro_theme_options[secondary]', array(
				'default' => $bavotasan_theme_options['secondary'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
			) );

			$wp_customize->add_control( 'bavotasan_secondary_column', array(
				'label' => __( 'First Sidebar', 'ward' ),
				'section' => 'bavotasan_layout',
				'settings' => 'ward_pro_theme_options[secondary]',
				'priority' => 20,
				'type' => 'select',
				'choices' => $choices,
			) );
		}

		$wp_customize->add_setting( 'ward_pro_theme_options[layout]', array(
			'default' => $bavotasan_theme_options['layout'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
		) );

		$layout_choices = array(
			'left' => __( 'Left', 'ward' ),
			'right' => __( 'Right', 'ward' ),
		);

		if ( is_active_sidebar( 'second-sidebar' ) )
			$layout_choices['separate'] = __( 'Separate', 'ward' );

		$wp_customize->add_control( new Bavotasan_Post_Layout_Control( $wp_customize, 'layout', array(
			'label' => __( 'Sidebar Layout', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[layout]',
			'size' => false,
			'priority' => 25,
			'choices' => $layout_choices,
		) ) );

		$wp_customize->add_setting( 'ward_pro_theme_options[excerpt_content]', array(
			'default' => $bavotasan_theme_options['excerpt_content'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_excerpt_content', array(
			'label' => __( 'Post Content Display', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[excerpt_content]',
			'priority' => 30,
			'type' => 'radio',
			'choices' => array(
				'excerpt' => __( 'Teaser Excerpt', 'ward' ),
				'content' => __( 'Full Content', 'ward' ),
			),
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[read_more]', array(
			'default' => $bavotasan_theme_options['read_more'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_read_more', array(
			'label' => __( '"Read More" Text', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[read_more]',
			'priority' => 33,
			'type' => 'text',
		) );

		$colors = array(
			'info' => __( 'Light Blue', 'ward' ),
			'primary' => __( 'Blue', 'ward' ),
			'danger' => __( 'Red', 'ward' ),
			'warning' => __( 'Yellow', 'ward' ),
			'success' => __( 'Green', 'ward' ),
		);

		$wp_customize->add_setting( 'ward_pro_theme_options[read_more_color]', array(
			'default' => $bavotasan_theme_options['read_more_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_read_more_color', array(
			'label' => __( 'Read More Color', 'ward' ),
			'section' => 'bavotasan_layout',
			'settings' => 'ward_pro_theme_options[read_more_color]',
			'priority' => 34,
			'type' => 'select',
			'choices' => $colors,
		) );

		// Jumbo headline section panel
		$wp_customize->add_section( 'bavotasan_jumbo', array(
			'title' => __( 'Jumbo Headline', 'ward' ),
			'priority' => 36,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[jumbo_headline_title]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_title'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_title', array(
			'label' => __( 'Title', 'ward' ),
			'section' => 'bavotasan_jumbo',
			'settings' => 'ward_pro_theme_options[jumbo_headline_title]',
			'priority' => 26,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[jumbo_headline_text]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_text'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_text', array(
			'label' => __( 'Text', 'ward' ),
			'section' => 'bavotasan_jumbo',
			'settings' => 'ward_pro_theme_options[jumbo_headline_text]',
			'priority' => 27,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[jumbo_headline_button_text]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_button_text'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_button_text', array(
			'label' => __( 'Button Text', 'ward' ),
			'section' => 'bavotasan_jumbo',
			'settings' => 'ward_pro_theme_options[jumbo_headline_button_text]',
			'priority' => 28,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[jumbo_headline_button_link]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_button_link'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_button_link', array(
			'label' => __( 'Button Link', 'ward' ),
			'section' => 'bavotasan_jumbo',
			'settings' => 'ward_pro_theme_options[jumbo_headline_button_link]',
			'priority' => 29,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[jumbo_headline_button_color]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_button_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_button_color', array(
			'label' => __( 'Button Color', 'ward' ),
			'section' => 'bavotasan_jumbo',
			'settings' => 'ward_pro_theme_options[jumbo_headline_button_color]',
			'priority' => 30,
			'type' => 'select',
			'choices' => $colors,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[widget_area_icon]', array(
			'default' => $bavotasan_theme_options['widget_area_icon'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_control( new Bavotasan_Icon_Select_Control( $wp_customize, 'widget_area_icon', array(
			'label' => __( 'Icon', 'ward' ),
			'section' => 'bavotasan_jumbo',
			'settings' => 'ward_pro_theme_options[widget_area_icon]',
			'priority' => 35,
		) ) );

		// Fonts panel
		$mixed_fonts = array_merge( bavotasan_websafe_fonts() , bavotasan_google_fonts() );
		asort( $mixed_fonts );

		$wp_customize->add_section( 'bavotasan_fonts', array(
			'title' => __( 'Fonts', 'ward' ),
			'priority' => 40,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[main_text_font]', array(
			'default' => $bavotasan_theme_options['main_text_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_main_text_font', array(
			'label' => __( 'Main Text', 'ward' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'ward_pro_theme_options[main_text_font]',
			'priority' => 10,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[headers_font]', array(
			'default' => $bavotasan_theme_options['headers_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_headers_font', array(
			'label' => __( 'Headers (h1, h2, h3, etc...)', 'ward' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'ward_pro_theme_options[headers_font]',
			'priority' => 15,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[post_title_font]', array(
			'default' => $bavotasan_theme_options['post_title_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_post_title_font', array(
			'label' => __( 'Post Title', 'ward' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'ward_pro_theme_options[post_title_font]',
			'priority' => 30,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[post_meta_font]', array(
			'default' => $bavotasan_theme_options['post_meta_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_meta_font', array(
			'label' => __( 'Post Meta', 'ward' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'ward_pro_theme_options[post_meta_font]',
			'priority' => 35,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[post_category_font]', array(
			'default' => $bavotasan_theme_options['post_category_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_post_category_font', array(
			'label' => __( 'Post Category', 'ward' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'ward_pro_theme_options[post_category_font]',
			'priority' => 40,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		// Color panel
		$wp_customize->add_setting( 'ward_pro_theme_options[headers_color]', array(
			'default' => $bavotasan_theme_options['headers_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headers_color', array(
			'label' => __( 'Headers (h1, h2, h3, etc...)', 'ward' ),
			'section'  => 'colors',
			'settings' => 'ward_pro_theme_options[headers_color]',
			'priority' => 20,
		) ) );

		$wp_customize->add_setting( 'ward_pro_theme_options[main_text_color]', array(
			'default' => $bavotasan_theme_options['main_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_text_color', array(
			'label' => __( 'Main Text Color', 'ward' ),
			'section'  => 'colors',
			'settings' => 'ward_pro_theme_options[main_text_color]',
			'priority' => 25,
		) ) );

		$wp_customize->add_setting( 'ward_pro_theme_options[link_color]', array(
			'default' => $bavotasan_theme_options['link_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label' => __( 'Link Color', 'ward' ),
			'section'  => 'colors',
			'settings' => 'ward_pro_theme_options[link_color]',
			'priority' => 50,
		) ) );

		$wp_customize->add_setting( 'ward_pro_theme_options[link_hover_color]', array(
			'default' => $bavotasan_theme_options['link_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
			'label' => __( 'Link Hover Color', 'ward' ),
			'section'  => 'colors',
			'settings' => 'ward_pro_theme_options[link_hover_color]',
			'priority' => 55,
		) ) );

		$wp_customize->add_setting( 'ward_pro_theme_options[widget_area_color]', array(
			'default' => $bavotasan_theme_options['widget_area_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'widget_area_color', array(
			'label' => __( 'Widget Area Background Color', 'ward' ),
			'section'  => 'colors',
			'settings' => 'ward_pro_theme_options[widget_area_color]',
			'priority' => 56,
		) ) );

		// Nav panel
			$wp_customize->add_setting( 'ward_pro_theme_options[nav_palette]', array(
			'default' => $bavotasan_theme_options['nav_palette'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_nav_palette', array(
			'label' => __( 'Nav Color', 'ward' ),
			'section' => 'nav',
			'settings' => 'ward_pro_theme_options[nav_palette]',
			'priority' => 40,
			'type' => 'select',
			'choices' => array(
				'navbar-default' => __( 'Light', 'ward' ),
				'navbar-inverse' => __( 'Dark', 'ward' ),
			),
		) );

		// Posts panel
		$wp_customize->add_section( 'bavotasan_posts', array(
			'title' => __( 'Posts', 'ward' ),
			'priority' => 45,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[display_categories]', array(
			'default' => $bavotasan_theme_options['display_categories'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_categories', array(
			'label' => __( 'Display Categories', 'ward' ),
			'section' => 'bavotasan_posts',
			'settings' => 'ward_pro_theme_options[display_categories]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[display_author]', array(
			'default' => $bavotasan_theme_options['display_author'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_author', array(
			'label' => __( 'Display Author', 'ward' ),
			'section' => 'bavotasan_posts',
			'settings' => 'ward_pro_theme_options[display_author]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[display_date]', array(
			'default' => $bavotasan_theme_options['display_date'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_date', array(
			'label' => __( 'Display Date', 'ward' ),
			'section' => 'bavotasan_posts',
			'settings' => 'ward_pro_theme_options[display_date]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[display_comment_count]', array(
			'default' => $bavotasan_theme_options['display_comment_count'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_comment_count', array(
			'label' => __( 'Display Comment Count', 'ward' ),
			'section' => 'bavotasan_posts',
			'settings' => 'ward_pro_theme_options[display_comment_count]',
			'type' => 'checkbox',
		) );

		// Footer panel
		$wp_customize->add_section( 'bavotasan_footer', array(
			'title' => __( 'Footer', 'ward' ),
			'priority' => 50,
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[extended_footer_columns]', array(
			'default' => $bavotasan_theme_options['extended_footer_columns'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( 'bavotasan_extended_footer_columns', array(
			'label' => __( 'Extended Footer Columns', 'ward' ),
			'section' => 'bavotasan_footer',
			'settings' => 'ward_pro_theme_options[extended_footer_columns]',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'col-md-12' => __( '1 Column', 'ward' ),
				'col-md-6' => __( '2 Columns', 'ward' ),
				'col-md-4' => __( '3 Columns', 'ward' ),
				'col-md-3' => __( '4 Columns', 'ward' ),
				'col-md-2' => __( '6 Columns', 'ward' ),
			),
		) );

		$wp_customize->add_setting( 'ward_pro_theme_options[copyright]', array(
			'default' => $bavotasan_theme_options['copyright'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_copyright', array(
			'label' => __( 'Copyright Notice', 'ward' ),
			'section' => 'bavotasan_footer',
			'settings' => 'ward_pro_theme_options[copyright]',
			'priority' => 20,
		) );
	}

	/**
	 * jQuery for Customizer screen
	 *
	 * This function is attached to the 'customize_controls_print_footer_scripts' action hook.
	 *
	 * @since Gridiculous Pro 1.0.0
	 */
	public function customize_sidebar() {
		?>
<script>
( function($){
	var start_value = $( 'input[name="_customize-radio-bavotasan_site_layout"]:checked' ).val();
	show_controls( start_value );
	$( 'input[name="_customize-radio-bavotasan_site_layout"]' ).change(function() {
		var value = $( 'input[name="_customize-radio-bavotasan_site_layout"]:checked' ).val();
		show_controls( value );
	});
	function show_controls( value ) {
		if ( 1 == value || 2 == value || 6 == value )
			$( '#customize-control-bavotasan_secondary_column' ).hide();
		else
			$( '#customize-control-bavotasan_secondary_column' ).show();
	}
} )(jQuery);
</script>
		<?php
	}
}
$bavotasan_customizer = new Bavotasan_Customizer;

/**
 * Prepare font CSS
 *
 * @param	string $font  The select font
 *
 * @since 1.0.0
 */
function bavotasan_prepare_font( $font ) {
	$font_family = ( 'Lato Light, sans-serif' == $font ) ? 'Lato' : $font;
	$font_family = ( 'Arvo Bold, serif' == $font ) ? 'Arvo' : $font_family;
	$font_weight = ( 'Lato Light, sans-serif' == $font ) ? ' font-weight: 300' : 'font-weight: normal';
	$font_weight = ( 'Lato, sans-serif' == $font ) ? ' font-weight: 400' : $font_weight;
	$font_weight = ( 'Raleway, cursive' == $font ) ? ' font-weight: 100' : $font_weight;
	$font_weight = ( 'Lato Bold, sans-serif' == $font || 'Arvo Bold, serif' == $font ) ? ' font-weight: 900' : $font_weight;

	return 'font-family: ' . html_entity_decode( $font_family ) . '; ' . $font_weight;
}

if ( ! function_exists( 'bavotasan_websafe_fonts' ) ) :
/**
 * Array of websafe fonts
 *
 * @return	Array of fonts
 *
 * @since 1.0.0
 */
function bavotasan_websafe_fonts() {
    return array(
        'Arial, sans-serif' => 'Arial',
        '"Avant Garde", sans-serif' => 'Avant Garde',
        'Cambria, Georgia, serif' => 'Cambria',
        'Copse, sans-serif' => 'Copse',
        'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
        'Georgia, serif' => 'Georgia',
        '"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
        'Tahoma, Geneva, sans-serif' => 'Tahoma'
    );
}
endif;

if ( ! function_exists( 'bavotasan_google_fonts' ) ) :
/**
 * Array of Google Fonts
 *
 * @return	Array of fonts
 *
 * @since 1.0.0
 */
function bavotasan_google_fonts() {
    return array(
        'Arvo, serif' => 'Arvo *',
        'Arvo Bold, serif' => 'Arvo Bold *',
        'Copse, sans-serif' => 'Copse *',
        'Droid Sans, sans-serif' => 'Droid Sans *',
        'Droid Serif, serif' => 'Droid Serif *',
        'Exo, sans-serif' => 'Exo *',
        'Lato Light, sans-serif' => 'Lato Light *',
        'Lato, sans-serif' => 'Lato *',
        'Lato Bold, sans-serif' => 'Lato Bold *',
        'Lobster, cursive' => 'Lobster *',
        'Nobile, sans-serif' => 'Nobile *',
        'Open Sans, sans-serif' => 'Open Sans *',
        'Oswald, sans-serif' => 'Oswald *',
        'Pacifico, cursive' => 'Pacifico *',
        'Raleway, cursive' => 'Raleway *',
        'Rokkitt, serif' => 'Rokkit *',
        'Russo One, sans-serif' => 'Russo One *',
        'PT Sans, sans-serif' => 'PT Sans *',
        'Quicksand, sans-serif' => 'Quicksand *',
        'Quattrocento, serif' => 'Quattrocento *',
        'Ubuntu, sans-serif' => 'Ubuntu *',
        'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz *'
    );
}
endif;