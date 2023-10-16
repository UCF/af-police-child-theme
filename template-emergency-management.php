<?php
/**
 * Template Name: Emergency Management Department
 * Template Post Type: page, post
 */
get_header();
the_post();
?>

	<article class="<?php echo esc_attr( $post->post_status ); ?> post-list-item">
		<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
			<?php theme_breadcrumbs(); ?>
			<div class="row">
				<div class="col-12 d-md-none">
					<!-- Responsive Navbar for sm viewports and below -->
					<nav class="navbar navbar-expand-sm navbar-light bg-light"> <!-- Using navbar-expand-sm for sm viewports -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarToggler">
							<?php
							wp_nav_menu(array(
								'theme_location'  => 'emergency-management-menu',
								'depth'           => 2,
								'container'       => false,
								'menu_class'      => 'navbar-nav mr-auto',
								'walker'          => new BS4_Nav_Walker(),
							));
							?>
						</div>
					</nav>
				</div>
				<div class="col-12 col-md-3 d-none d-md-block">
					<!-- Sidebar with Navigation Menu for md viewports and above -->
					<?php
					wp_nav_menu(array(
						'theme_location'  => 'emergency-management-menu',
						'container'       => 'nav',
						'container_class' => 'mb-1',
						'menu_class'      => 'nav flex-column',
						'walker'          => new BS4_Nav_Walker(),
					));
					?>
				</div>

				<!-- Main Content Area -->
				<div class="col-12 col-md-9">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</article>

<?php get_footer(); ?>
