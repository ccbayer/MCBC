<?php get_header(); ?>
<?php
global $wp_query;
$term = $wp_query->get_queried_object();

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
/* <div class="container-full-width b-lazy" data-src="<?php echo $hero_image['url']; ?>"></div> */


?>
<section class="theme-soot archive-wrapper">
	<div class="container">
		<div class="row">
			<div class="headline">
				<h1>
					<small>
						<?php 
							if(get_field('project_archive_title_small', $term)) {
								the_field('project_archive_title_small', $term);
							} else if(is_tax()) {

								echo $term->name;
							}
						?>
					</small>
				  <?php if( get_field('project_archive_title_large', $term)): ?>
				  	<?php the_field('project_archive_title_large', $term); ?>
				  <?php else: ?>
				    Archive
				  <?php endif; ?>
				  </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">			
				<div class="description">
					<?php echo term_description( $term->term_id, 'project' ); ?>
				</div>
				<div class="cta">
					<?php if ( get_field('back_to_page_link', $term) && get_field('back_to_page_label',$term) ): ?>
						<a href="<?php the_field('back_to_page_link', $term); ?>" class="button border-white color-white"><?php the_field('back_to_page_label',$term); ?></a>
					<?php endif; ?>
				</div>
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