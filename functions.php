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
			//'render_template'   => get_template_directory() . '/template-unit-block.php',
			'render_callback'   => 'my_custom_block_render_callback',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'testimonial', 'quote' ),
		));
	}
}

function my_custom_block_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	global $post;
	if( $is_preview ) {
		// Code to display preview in Gutenberg editor
		if( have_rows('unit') ):
			while( have_rows('unit') ) : the_row();
				$unit_name = get_sub_field('unit_name');
				$unit_description = get_sub_field('unit_description');

				echo '<div style="border: 1px solid #000; padding: 16px; margin: 16px 0;">';
				if( $unit_name ) {
					echo '<h4>' . esc_html( $unit_name ) . '</h4>';
				}
				if( $unit_description ) {
					echo '<p>' . wp_kses_post( $unit_description ) . '</p>';
				}
				echo '</div>';
			endwhile;
		else :
			echo '<div style="border: 1px solid #000; padding: 16px; margin: 16px 0;">No unit fields set</div>';
		endif;
	} else {
		// Use global $post ID to fetch the repeater fields.
		$post_id = $post->ID;

		if( have_rows('unit', $post_id) ):
			$accordion_id = "accordion_" . uniqid();
			echo '<div id="'. esc_attr( $accordion_id ) .'" class="accordion">';

			$index = 0;
			while( have_rows('unit', $post_id) ) : the_row();
				$unit_name = get_sub_field('unit_name');
				$unit_description = get_sub_field('unit_description');
				$heading_id = "heading_" . uniqid();
				$collapse_id = "collapse_" . uniqid();

				echo '<div class="card">';
				echo '<div class="card-header" id="'. esc_attr( $heading_id ) .'">';
				echo '<h5 class="mb-0">';
				echo '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#'. esc_attr( $collapse_id ) .'" aria-expanded="'. ($index === 0 ? 'true' : 'false') .'" aria-controls="'. esc_attr( $collapse_id ) .'">';
				echo esc_html( $unit_name );
				echo '</button>';
				echo '</h5>';
				echo '</div>';

				echo '<div id="'. esc_attr( $collapse_id ) .'" class="collapse '. ($index === 0 ? 'show' : '') .'" aria-labelledby="'. esc_attr( $heading_id ) .'" data-parent="#'. esc_attr( $accordion_id ) .'">';
				echo '<div class="card-body">';
				echo wp_kses_post( $unit_description );
				echo '</div>';
				echo '</div>';
				echo '</div>';

				$index++;
			endwhile;
			echo '</div>';
		endif;
	}
}

// Hook into setup.
add_action('acf/init', 'unit_block_init');
