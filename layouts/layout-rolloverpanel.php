<?php
	$hero_img = get_sub_field('hero_image');
	$full_height = get_sub_field('full_height');
	$class = '';
	if($full_height):
		$class = 'page-section';
	endif;
	$panels = get_sub_field('rollover_panels');
		
?>
<section class="<?php echo $class ?> panel-module theme-<?php echo end($panels)['theme']; ?>" id="section-<?php echo $i; ?>">
	<?php if($hero_img): ?>
	<div class="container-full-width b-lazy" data-src="<?php echo $hero_img['url']; ?>"></div>
	<?php endif; ?>
	<div class="container-full-width theme-darkgrey">
		<div class="introduction">
			<h2><?php echo the_sub_field('headline'); ?></h2>
		</div>
	</div>
	<div class="container-full-width position-rel panel-module-wrapper equalize">
		<?php 
			foreach($panels as $panel) {
				// deal with destination link and title
				if($panel['link_type'] === 'targets') {
					$destination = $panel['destination'];
					$link = get_term_link($destination);					
					$headline = $destination->name;
				} else if($panel['link_type'] === 'page') {
					$destination = $panel['destination_page'];
					$headline = $destination->title;
					$link = get_permalink($destination->id);
				}else{
					$destination = false;
					$headline = $panel['headline'];
					$link = false;
				}
				
				
				if($panel['custom_title']) {
					$headline = $panel['headline'];
				}
		?>
			<div class="panel width-<?php echo $panel['panel_width']; ?> theme-<?php echo $panel['theme'];?>">
				<div class="img-wrap" data-hover-img="<?php echo $panel['hover_image']['url']?>"/></div>
				<?php
					if($link) {
						echo '<a href="'.$link.'" title="'.$headline.'">';
					}
				?>
				<div class="content-block">
					<?php 
						if($panel['main_image']) {
							echo '<img src="'.$panel['main_image']['url'].'" alt="" class="main-img"/>';
						}	
					?>
					<h3><?php echo $headline; ?></h3>
					<hr/>
					<p><?php echo $panel['content']; ?></p>
				</div>
				<?php
					if($link) {
						echo '</a>';
					}
				?>
			</div>	
		<?php
			}	
		?>
	</div>
	<?php
		if($full_height):
	?>
		<a href="#section-<?php echo $next; ?>" class="down-arrow down-arrow-celeste position-abs color-celeste">Down</a>
	<?php
		endif;	
	?>
</section>