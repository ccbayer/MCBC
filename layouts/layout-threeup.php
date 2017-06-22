<?php
	$full_height = get_sub_field('full_height');
	$class = '';
	if($full_height):
		$class = 'page-section';
	endif;
?>
<section class="<?php echo $class ?> theme-celeste three-up" id="section-<?php echo $i; ?>">
	<?php
	if($full_height):
		echo '<div class="vertical-center">';
	endif;
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="text-center color-white"><?php the_sub_field('headline'); ?></h2>
			</div>
		</div>
		<?php 
			$items = get_sub_field('item');
			if($items):
		?>
		<div class="row">
			<?php
				foreach($items as $item):
			?>
			<div class="item">
				<?php if($item['image']): ?>
					<?php 
						if($item['link']):
							$href = $item['link'];
							echo '<a href="'.$href.'">';
						endif;
					?>
					<img src="<?php echo $item['image']['url']?>" alt="" class="icon-round"/>
					<?php 
						if($item['link']):
							echo '</a>';
						endif;
					?>
				<?php endif; ?>
				<h3>
					<?php 
						if($item['link']):
							echo '<a href="'.$href.'">';
						endif;
					?>
					<?php echo $item['heading']; ?>
					<?php 
						if($item['link']):
							echo '</a>';
						endif;
					?>
				</h3>
				<hr/>
				<p><?php echo $item['content']; ?></p>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php
		if($full_height):
	?>
		</div>
	<?php
		if(is_home()):
	?>
		<a href="#section-<?php echo $next; ?>" class="down-arrow down-arrow-black position-abs color-black">Down</a>
	<?php
		endif;	
	?>
	<?php
		endif;	
	?>
</section>