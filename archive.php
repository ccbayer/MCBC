<?php get_header(); ?>
<?php

$post_type = get_post_type();
$args = array(
	'orderby' => 'rand',
	'post_type' => $post_type
);

$post_for_image = get_posts($args);
$hero_image = get_field('featured_hero_image', $post_for_image[0]->ID);
if(!$hero_image['url']):
	$hero_image['url'] = get_template_directory_uri() ."/images/MCBC_Bike_Pattern-large.gif";
endif;

if(is_tax()):
	global $wp_query;
	$term = $wp_query->get_queried_object();
else: 
	$term = false;
endif;
/* <div class="container-full-width b-lazy" data-src="<?php echo $hero_image['url']; ?>"></div> */
?>
<section class="theme-soot archive-wrapper">
	<div class="container">
		<div class="row">
			<div class="headline">
				<h1>
				<?php 
					if(is_tax() && $term) {
						echo '<small>';
						if(get_field('title_small', $term)) {
							echo get_field('title_small', $term);		    			
		    			} else {
			    			echo $term->name;
		    			}
		    			echo '</small>';
					}
					if(is_tax() && $term && get_field('title_large', $term)) {
						echo get_field('title_large', $term);
					} else {

				?>
				  <?php if( is_author() ): ?>
				    Author: <?php echo $author_name ?>
				  <?php elseif( is_category() ): ?>
				    Category: <?php single_cat_title(); ?>
				  <?php elseif( is_tag() ): ?>
				    Tag: <?php single_tag_title(); ?>
				  <?php elseif( is_year() ): ?>
				    Archive for <?php the_time('Y'); ?>
				  <?php elseif( is_month() ): ?>
				    Archive for <?php the_time('F Y'); ?>
				  <?php elseif (is_post_type_archive() ): ?>
					  <?php post_type_archive_title(); ?>
				  <?php else: ?>
				    Archive
				  <?php endif; ?>
				  </h1>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="equalize equalizeMin" data-equalize-min="768" id="ajax-target">
			<?php if ( have_posts() ): ?>
			  <?php while ( have_posts() ) : the_post(); ?>
	  			<?php get_template_part('post', 'details'); ?>
			  <?php 
				  endwhile; 
				  wp_reset_query(); 
			  ?>
			  </div>
			<?php else: ?>
			  <h2>No posts found</h2>
			<?php endif; ?>
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
				<div class="cta">
					<?php echo get_next_posts_link( 'Load More') ?>
				</div>		
			<?php endif; ?>

		</div>
	</div>
</section>
<?php get_template_part('modules/feed', 'socialmedia'); ?>
<?php get_footer(); ?>