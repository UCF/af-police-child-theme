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
			'render_callback'   => 'my_custom_block_render_callback',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'testimonial', 'quote' ),
		));
	}
}

function my_custom_block_render_callback( $block ) {
	// Get the ACF fields for this block
	$unit_fields = get_field('unit');

	// Check if we have any fields to display
	if ($unit_fields) {
		foreach ($unit_fields as $unit_field) {
			// Display the unit name and description
			echo '<div style="border: 1px solid #000; padding: 16px; margin: 16px 0;">';
			echo '<h4>' . esc_html($unit_field['unit_name']) . '</h4>';
			echo '<p>' . wp_kses_post($unit_field['unit_description']) . '</p>';
			echo '</div>';
		}
	} else {
		// Display a message indicating that no fields are set
		echo '<div style="border: 1px solid #000; padding: 16px; margin: 16px 0;">No unit fields set</div>';
	}
}

// Hook into setup.
add_action('acf/init', 'unit_block_init');
