<?php
	$full_height = the_sub_field('full_height');
	$class = '';
	if($full_height):
		$class = 'page-section';
	endif;
?>
<section class="<?php echo $class ?> theme-celeste three-up">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="text-center color-black"><?php the_sub_field('headline'); ?> </h2>
			</div>
		</div>
		<div class="row">
			<div class="item">
			</div>
		</div>
	</div>
	<?php
		if($full_height):
	?>
		<a href="#" class="down-arrow position-abs color-black">Down</a>
	<?php
		endif;	
	?>
</section>