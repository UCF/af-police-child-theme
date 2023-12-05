<?php
/**
 * Template Name: Resource Forms
 * Template Post Type: page, post
 */
get_header();
the_post();
?>

<article class="<?php echo esc_attr( $post->post_status ); ?> post-list-item">
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<?php theme_breadcrumbs(); ?>
		<div class="row">
			<!-- Main Content Area -->
			<div class="col-12">
				<?php the_content(); ?>
				<?php
				// Check if the repeater field has rows of data
				if( have_rows('form_repeater') ):

					// Loop through the rows of data
					while ( have_rows('form_repeater') ) : the_row();
						// Load sub field values
						$form_title = get_sub_field('form_title');
						$form_shortcode = get_sub_field('form_shortcode');
						$form_wysiwyg = get_sub_field('form_wysiwyg');
						$unique_id = uniqid('form_'); // Generate a unique ID for each form

						// Display the data
						?>
						<div class="accordion" id="accordionExample">
							<div class="card">
								<div class="card-header" id="heading<?php echo $unique_id; ?>">
									<h5 class="mb-0">
										<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $unique_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $unique_id; ?>">
											<?php echo esc_html($form_title); ?>
										</button>
									</h5>
								</div>

								<div id="collapse<?php echo $unique_id; ?>" class="collapse" aria-labelledby="heading<?php echo $unique_id; ?>" data-parent="#accordionExample">
									<div class="card-body p-3">
										<?php
										// Display the form shortcode or WYSIWYG content, if available
										if( !empty($form_shortcode) && !empty($form_wysiwyg) ) {
											// Echo Title, Text, and Form
											echo "<h4>" . htmlspecialchars($form_title) . "</h4>";
											echo $form_wysiwyg;
											echo do_shortcode($form_shortcode);
										} elseif( !empty($form_shortcode) ) {
											// Echo only form, not title needed as form shortcode will display the title
											echo do_shortcode($form_shortcode);
										} elseif( !empty($form_wysiwyg) ) {
											// No form, echo title and text
											echo "<h4>" . htmlspecialchars($form_title) . "</h4>";
											echo $form_wysiwyg;
										} else {
											echo '<p>No content available.</p>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
					<?php
					endwhile;

				else :
					// No rows found
					echo '<p>No forms or content available.</p>';
				endif;
				?>

			</div>
		</div>
	</div>
</article>

<?php get_footer(); ?>
