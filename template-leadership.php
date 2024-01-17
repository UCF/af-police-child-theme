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
			<p>Test</p>
			<div class="row">
				<div class="col-12">
					<?php
					$args = array(
						'post_type'      => 'leadership-post',
						'posts_per_page' => -1, // Retrieve all posts
						//'orderby'        => 'meta_value_num', // Order by numeric meta value
						//'meta_key'       => 'order', // Field to sort by
						//'order'          => 'ASC', // Ascending order
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) :
						while ($query->have_posts()) :
							$query->the_post();
							$post_id = get_the_ID();

							// Fetch ACF fields
							$person_image = get_field('image', $post_id);
							$person_name = get_field('name', $post_id);
							$person_title = get_field('title', $post_id);
							$person_email = get_field('email', $post_id);
							$person_phone = get_field('phone', $post_id);
							$person_bio = get_field('bio', $post_id);

							// Unique ID for the collapse element
							$collapse_id = 'person_bio_' . $post_id;
							?>

							<div class="container pb-5">
								<div class="row">
									<div class="col col-4 col-md-3">
										<?php if ($person_image): ?>
											<img src="<?php echo esc_url($person_image['url']); ?>" alt="<?php echo esc_attr($person_image['alt']); ?>" class="img-thumbnail rounded-circle border-0" />
										<?php endif; ?>
									</div>
									<div class="col col-8 col-md-9">
										<h3><?php echo esc_html($person_name); ?></h3>
										<p><?php echo esc_html($person_title); ?></p>
										<?php if ($person_email): ?>
											<fa class="fa fa-envelope mr-2"></fa> <a href="mailto:<?php echo esc_attr($person_email); ?>"><?php echo esc_html($person_email); ?></a><br>
										<?php endif; ?>
										<?php if ($person_phone): ?>
											<fa class="fa fa-phone mr-2"></fa> <a href="tel:<?php echo esc_attr($person_phone); ?>"><?php echo esc_html($person_phone); ?></a><br>
										<?php endif; ?>

										<?php if ($person_bio): ?>
											<!-- Button to toggle the bio -->
											<a class="btn btn-primary btn-sm mt-3" data-toggle="collapse" href="#<?php echo $collapse_id; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $collapse_id; ?>">Bio</a>

											<!-- Collapsible container for the bio -->
											<div class="collapse" id="<?php echo $collapse_id; ?>">
												<div class="card card-body p-2 pt-3 border-0"><?php echo $person_bio; ?></div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>

			<?php if (!empty(get_the_content())) : ?>
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
