<?php
/**
 * Template Name: Leadership Team
 * Template Post Type: page, post
 */
get_header();
the_post();
?>

	<article class="<?php echo esc_attr( $post->post_status ); ?> post-list-item">
		<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
			<?php theme_breadcrumbs(); ?>

			<!-- Leadership Team Section -->
			<div class="row">
				<div class="col-12">
					<?php
					$args = array(
						'post_type'      => 'leadership-post',
						'posts_per_page' => -1, // Retrieve all posts
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) :
						while ($query->have_posts()) :
							// The style you provided for displaying each leadership post
							$query->the_post();
							$post_id = get_the_ID();

							// Fetch ACF fields
							$person_image = get_field('image', $post_id);
							$person_name = get_field('name', $post_id);
							$person_title = get_field('title', $post_id);
							$person_email = get_field('email', $post_id);
							$person_phone = get_field('phone', $post_id);
							$person_bio = get_field('bio', $post_id); // Changed from 'leadership_bio' to 'bio'

							// Unique ID for the collapse element
							$collapse_id = 'person_bio_' . $post_id;

							// HTML structure for each person
							include('path/to/your/person-display-template.php'); // You can separate the display logic into a different file for clarity

						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>

			<?php
			// Check if there is content before displaying the Main Content Area
			if (!empty(get_the_content())) : ?>
				<!-- Main Content Area -->
				<div class="row">
					<div class="col-12">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</article>

<?php get_footer(); ?>
