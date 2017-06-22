<?php 
/* 
	Template Name: Page Programs	
*/


/*	$url = getcwd().'lib/index.php?network=twitter'; 

	$networks = array('twitter','facebook'); 
	$random = $networks[array_rand($networks)];
	$postdata = http_build_query(array('network' => $random));	
	$opts = array('http' =>
		array(
    		'method'  => 'GET',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)	
	);

	$context  = stream_context_create($opts);
	$result = file_get_contents('index.php?'.$postdata, false, $context);
	var_dump($result);
*/
// require_once 'lib/index.php';
// $output = getFacebookFeed();

?>
<?php get_header(); ?>
<?php
$hero_image = get_field('featured_hero_image');
$tablet = get_field('hero_image_tablet');
$mobile = get_field('hero_image_mobile');
					
if($hero_image):
?>
<div class="container-full-width b-lazy" data-src="<?php echo $hero_image['url']; ?>" data-src-med="<?php echo $tablet['url']; ?>" data-src-small="<?php echo $mobile['url']; ?>"></div>
<?php 
endif;	
?>
<section class="theme-white default-pad article-wrapper">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<article>
				<div class="title">
					<h1>
					<?php 
						if(get_field('subheading')):
					?>
						<small>
							<?php the_field('subheading'); ?>
						</small>
					<?php endif; ?>
						<?php the_title(); ?>
					</h1>
				</div>
				<div class="content page-content">
					<?php the_content(); ?>
				</div>
				<?php get_template_part('modules/events', 'list');?>
				<?php get_template_part('modules/page', 'cta'); ?>
			</article>
			<?php endwhile; wp_reset_query(); ?>
		</div>
	</div>
</section>
<?php
//
$layouts = count(get_field('layouts'));	
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
<?php 
	get_template_part('modules/similar', 'articles');
	get_template_part('modules/feed', 'socialmedia'); 
?>
<?php get_footer(); ?>