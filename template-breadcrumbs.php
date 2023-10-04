<?php
/**
 * Template Name: Breadcrumbs
 * Template Post Type: page, post
 */
?>
<?php get_header(); the_post(); ?>

	<article class="<?php echo $post->post_status; ?> post-list-item">
		<div class="container-fluid px-0 mt-4 mt-sm-5">
			<?php theme_breadcrumbs(); the_content(); ?>
		</div>
	</article>

<?php get_footer(); ?>
