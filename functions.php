<?php
//namespace AFMainSite\Theme;

define( 'AFMAINSITE_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );


// Theme foundation
include_once AFMAINSITE_THEME_DIR . 'includes/config.php';
include_once AFMAINSITE_THEME_DIR . 'includes/meta.php';

// Add other includes to this file as needed.

//Register unit/division blocks for about page
function unit_block_init() {
	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// Register a new block.
		acf_register_block_type(array(
			'name'              => 'acf_unit_block',
			'title'             => __('Unit block'),
			'description'       => __('A custom block for displaying units on about us.'),
			'render_template'   => get_template_directory() . '/template-unit-block.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'testimonial', 'quote' ),
		));
	}
}

// Hook into setup.
add_action('acf/init', 'unit_block_init');
