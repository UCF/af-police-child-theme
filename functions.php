<?php
//namespace AFMainSite\Theme;

define( 'AFMAINSITE_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );


// Theme foundation
include_once AFMAINSITE_THEME_DIR . 'includes/config.php';
include_once AFMAINSITE_THEME_DIR . 'includes/meta.php';

// Add other includes to this file as needed.

/**
 * Register unit/division blocks for about page
 *
 * @author Mike Setzer
 **/
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

/**
 * Block render callback for Units on About Us page
 *
 * @author Mike Setzer
 **/
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
				echo '<div class="card-header bg-inverse" id="'. esc_attr( $heading_id ) .'">';
				echo '<h5 class="mb-0">';
				echo '<button class="btn btn-link text-decoration-none text-primary" type="button" data-toggle="collapse" data-target="#'. esc_attr( $collapse_id ) .'" aria-expanded="'. ($index === 0 ? 'true' : 'false') .'" aria-controls="'. esc_attr( $collapse_id ) .'">';
				echo '<i class="fa fa-chevron-down text-primary"></i> ' . esc_html( $unit_name );
				echo '</button>';
				echo '</h5>';
				echo '</div>';

				echo '<div id="'. esc_attr( $collapse_id ) .'" class="collapse '. ($index === 0 ? 'show' : '') .'" aria-labelledby="'. esc_attr( $heading_id ) .'" data-parent="#'. esc_attr( $accordion_id ) .'">';
				echo '<div class="card-body p-3">';
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

/**
 * Fetch breadcrumbs and display at the top of the page in breadcrumb template
 *
 * @author Mike Setzer
 **/

if ( ! function_exists( 'theme_breadcrumbs' ) ) {
	function theme_breadcrumbs() {
		global $post;

		echo '<div class="container mt-4">';
		echo '<ol class="breadcrumb" role="navigation" aria-label="breadcrumb">';

		// Home link
		echo '<li class="breadcrumb-item"><a href="' . home_url() . '">Home</a></li>';

		// If it's a page and it has a parent
		if (is_page() && $post->post_parent) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();

			while ($parent_id) {
				$page          = get_page($parent_id);
				$breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
				$parent_id     = $page->post_parent;
			}

			// Display the parent pages in correct order
			echo implode(array_reverse($breadcrumbs));
		}

		// Current page or post
		if (is_page() || is_single()) {
			echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
		}

		echo '</ol>';
		echo '</div>';
	}
}

/**
 * Register menu location for department of security and emergency management pages
 *
 * @author Mike Setzer
 **/
function register_my_menus() {
	register_nav_menus(
		array(
			'security-menu' => __( 'Security Menu' ),
			'emergency-management-menu' => __( 'Emergency Management Menu'),
			'resources-menu' => __( 'Resources Menu' ),
			'clery-menu' => __( 'Clery Menu' ),
		)
	);
}
add_action( 'init', 'register_my_menus' );

/**
 * Register walker for security and emergency management menus
 *
 * @author Mike Setzer
 **/
class BS4_Nav_Walker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = [] ) {
		$indent = str_repeat( "\t", $depth );
		$class_to_add = ( $depth >= 0 ) ? 'ml-3' : ''; // Add ml-3 class to nested ul elements only
		$output .= "\n$indent<ul class=\"nav flex-column $class_to_add\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$active_class = '';
		if ( in_array( 'current-menu-item', $item->classes, true ) ) {
			$active_class = ' active bg-primary';
		}
		$output .= '<li class="nav-item' . $active_class . '">';

		$link_classes = [ 'nav-link' ];
		if ( $depth > 0 ) {
			$link_classes[] = 'p';
			$link_classes[] = 'pl-3'; // Add pl-3 to the link classes for nested links
			$link_classes[] = 'text-muted'; // Add text-muted to the link classes for nested links
			$link_classes[] = 'font-size-sm'; // Add font-size-sm to the link classes for nested links
		} else {
			$link_classes[] = 'h6 mb-0';
		}
		$link_class_str = implode( ' ', $link_classes );

		$output .= '<a class="' . $link_class_str . '" href="' . $item->url . '">' . $item->title . '</a>';
	}
}

/**
 * Register a new merge tag for the sequential numbering on the CSA Incident Reporting Form
 *
 * @author Mike Setzer
 **/
add_filter( 'gform_custom_merge_tags', 'add_sequential_number_merge_tag', 10, 4 );
function add_sequential_number_merge_tag( $merge_tags, $form_id, $fields, $element_id ) {
	$configured_form_id = get_option('gf_sequential_form_id');
	if ( $form_id == $configured_form_id ) {
		$merge_tags[] = array(
			'label' => 'Sequential Number',
			'tag'   => '{sequential_number}',
		);
	}
	return $merge_tags;
}

/**
 * Replace the merge tag with the actual sequential number
 *
 * @author Mike Setzer
 **/
add_filter( 'gform_replace_merge_tags', 'replace_sequential_number_merge_tag', 10, 7 );
function replace_sequential_number_merge_tag( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
	if ( !is_array( $form ) || !is_array( $entry ) ) {
		return $text;
	}

	$configured_form_id = get_option('gf_sequential_form_id');
	if ( $form['id'] == $configured_form_id ) {
		$starting_number = get_option('gf_sequential_starting_number');
		$current_year = date('Y');
		$last_year = get_option( 'gf_sequential_year' );
		$last_sequential_number = get_option( 'gf_sequential_number' );

		if ( $last_year == $current_year ) {
			$sequential_number = $last_sequential_number + 1;
		} else {
			$sequential_number = $starting_number;
			update_option( 'gf_sequential_year', $current_year );
		}

		update_option( 'gf_sequential_number', $sequential_number );
		$text = str_replace( '{sequential_number}', $sequential_number, $text );
	}

	return $text;
}
