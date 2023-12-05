<?php
/**
 * Template Name: Recruiting
 * Template Post Type: page, post
 */
get_header();
the_post();
?>

	<article class="<?php echo $post->post_status; ?> post-list-item">
		<div class="container-fluid px-0 mt-4 mt-sm-5">
			<?php
			theme_breadcrumbs();
			the_content();

			// Check if the repeater field has rows of data
			if( have_rows('job') ):

				echo '<div class="container">';
					// Loop through the rows of data
					while ( have_rows('job') ) : the_row();

						// Fetch sub field values
						$job_title = get_sub_field('job_title');
						$base_pay = get_sub_field('base_pay');
						$description = get_sub_field('description');
						$job_link = get_sub_field('job_link');
						$salary_link = get_sub_field('salary_link');

						// Display the sub field values
						echo '<div class="row pt-5 mt-5" style="border-top: 1px solid #ccc;">';
						echo '<div class="col col-12">';

						if ( !empty($job_title) ) {echo '<h2 class="h5 heading-underline">' . $job_title . '</h2>'; }
						if ( !empty($base_pay) ) { echo '<span class="font-weight-black text-uppercase h3 letter-spacing-1">' . $base_pay . '</span>'; }
						if ( !empty($description) ) { echo '<div>' . $description . '</div>'; }
						if ( !empty($job_link) ) { echo '<a href="' . $job_link . '" class="btn btn-primary">Apply</a>'; }
						if ( !empty($salary_link) ) { echo '<a href="' . $salary_link . '" class="btn btn-secondary ml-2">Salary Breakdown</a>'; }
						echo '</div>';
						echo '</div>';

					endwhile;
				echo '</div>';

			else :

				// No rows found

			endif;
			?>
		</div>
	</article>

<?php get_footer(); ?>
