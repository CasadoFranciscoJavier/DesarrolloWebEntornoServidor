<?php
/**
 * CV Workfolio functions
 */

//Admin css
	add_editor_style( array( 'assets/css/admin.css' ) );

if ( ! function_exists( 'cv_workfolio_setup' ) ) :
function cv_workfolio_setup() {

    load_theme_textdomain( 'cv-workfolio', get_template_directory() . '/languages' );

	// Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'cv_workfolio_custom_background_args', array(
	    'default-color' => 'ffffff',
	    'default-image' => '',
    ) ) );

	/**
	 * About Theme Function
	 */
	require get_theme_file_path( '/about-theme/about-theme.php' );

	/**
	 * Customizer
	 */
	require get_template_directory() . '/inc/customizer.php';
}
endif; 
add_action( 'after_setup_theme', 'cv_workfolio_setup' );

if ( ! function_exists( 'cv_workfolio_styles' ) ) :
	function cv_workfolio_styles() {
		// Register theme stylesheet.
		wp_register_style('cv-workfolio-style',
			get_template_directory_uri() . '/style.css',array(),
			wp_get_theme()->get( 'Version' )
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'cv-workfolio-style' );

		wp_style_add_data( 'cv-workfolio-style', 'rtl', 'replace' );

		wp_enqueue_script( 'cv-workfolio-custom-script', get_theme_file_uri( '/assets/js/custom-script.js' ), array( 'jquery' ), true );
	}
endif;
add_action( 'wp_enqueue_scripts', 'cv_workfolio_styles' );