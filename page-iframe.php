<?php 
/* 
	Template Name: Iframe	
*/

?>
<?php get_header(); ?>
<?php
$hero_image = get_field('featured_hero_image');

if($hero_image):
?>
<div class="container-full-width b-lazy" data-src="<?php echo $hero_image['url']; ?>"></div>
<?php 
endif;	
?>
<section class="theme-soot iframe-wrapper">
	<div class="container">
		<div class="row">
			<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: auto; -webkit-overflow-scrolling:touch; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class="embed-container"><iframe SRC="https://connect.clickandpledge.com/w/Form/0d6998a5-dfbd-48b5-b63c-b7e670cd1b0e" frameborder="0" allowfullscreen></iframe></div>		
		</div>
	</div>
</section>
<?php get_footer(); ?>