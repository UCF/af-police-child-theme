<!--Unit/Division blocks for About page-->
<?php
if( have_rows('unit') ):
	$accordion_id = "accordion_" . uniqid();
	?>
	<div id="<?php echo esc_attr( $accordion_id ); ?>" class="accordion">
		<?php
		$index = 0;
		while( have_rows('unit') ) : the_row();
			$unit_name = get_sub_field('unit_name');
			$unit_description = get_sub_field('unit_description');
			$heading_id = "heading_" . uniqid();
			$collapse_id = "collapse_" . uniqid();
			?>
			<div class="card">
				<div class="card-header" id="<?php echo esc_attr( $heading_id ); ?>">
					<h5 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
							<?php echo esc_html( $unit_name ); ?>
						</button>
					</h5>
				</div>

				<div id="<?php echo esc_attr( $collapse_id ); ?>" class="collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-parent="#<?php echo esc_attr( $accordion_id ); ?>">
					<div class="card-body">
						<?php echo wp_kses_post( $unit_description ); ?>
					</div>
				</div>
			</div>
			<?php
			$index++;
		endwhile;
		?>
	</div>
<?php
endif;
?>
