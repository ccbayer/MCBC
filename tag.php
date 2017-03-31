<?php get_header(); ?>
<section class="theme-soot archive-wrapper">
	<div class="container">
		<div class="row">
			<div class="headline">
				<h1>Tag: <?php single_tag_title(); ?></h1>
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