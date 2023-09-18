<!--Unit/Division blocks for About page-->
<?php
if( have_rows('unit') ):
	?>
	<div class="container py-3">
		<div class="row">
			<?php
			while( have_rows('unit') ) : the_row();
				$unit_name = get_sub_field('unit_name');
				$unit_description = get_sub_field('unit_description');
				?>
				<div class="col col-12 col-md-4">
					<h4><?php echo esc_html($unit_name); ?></h4>
					<div class="unit-body">
						<?php echo wp_kses_post($unit_description); ?>
					</div>
				</div>
			<?php
			endwhile;
			?>
		</div>
	</div>
<?php
endif;
?>
