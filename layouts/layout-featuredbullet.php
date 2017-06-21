<?php
	$full_height = get_sub_field('full_height');
	$class = '';
	if($full_height):
		$class = 'page-section';
	endif;
?>
<section class="<?php echo $class ?> theme-darkteal featured-bullets" id="section-<?php echo $i; ?>">
	<div class="container">
		<div class="row">		
			<h2 class="text-center"><?php the_sub_field('headline'); ?></h2>
			<?php 
				$bullets = get_sub_field('bullets');
				if($bullets):
				echo '<ul>';
					foreach($bullets as $bullet) {
						echo '<li>'.$bullet['bullet_content'].'</li>';						
					}
				echo '</ul>';
				endif;
			?>
		</div>
	</div>
	<?php
		if($full_height && is_home()):
	?>
		<a href="#section-<?php echo $next; ?>" class="down-arrow down-arrow-black position-abs color-black">Down</a>
	<?php
		endif;	
	?>
</section>