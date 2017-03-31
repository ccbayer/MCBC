<?php 
/* 
	Template Name: Home	
*/
	get_header();
?>

<?php 
	if( have_rows('layout') ):
	$i = 0;
	echo '<ul class="navigation-follow">';
	echo '<li class="navindicator active" id="indicator-0"><a href="#section-0" class="scroll-to">0</a></li>';
	while ( have_rows('layout') ) : the_row();
		$i ++;
		echo '<li class="navindicator" id="indicator-'.$i.'"><a href="#section-'.$i.'" class="scroll-to">'.$i.'</a></li>';
	endwhile;
	echo '</ul>';
endif;	
?>


<section class="page-section" id="section-0">
	<?php get_template_part('modules/slider', 'fullwidth'); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="introduction">
					<h1 class="text-center color-celeste"><?php the_field('headline'); ?></h1>
					<hr class="minute"/>
					<p><?php the_field('subheadline'); ?></p>
				</div>
			</div>
		</div>
	</div>
	<a href="#section-1" class="down-arrow down-arrow-celeste position-abs color-celeste">Down</a>
</section>

<?php
	
// check if the flexible content field has rows of data
if( have_rows('layout') ):
	$i = 0;
	while ( have_rows('layout') ) : the_row();
		$i ++;
		$next = $i + 1;
			$template_name = 'layouts/layout-' . get_row_layout();
			include(locate_template($template_name . '.php'));				
	endwhile;
	
endif;
?>
<?php get_footer(); ?>	