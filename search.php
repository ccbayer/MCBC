<?php get_header(); ?>
<section class="theme-soot default-pad article-wrapper">
	<div class="container">
		<div class="row">
			<article class="single-page search-results-page">
				<div class="title">
					<h1><?php printf( __( '<small>Search Results for:</small> %s' ), '' . get_search_query() . '' ); ?></h1>
				</div>
				<div class="content page-content">
					<?php if ( have_posts() ) : ?>
					<div id="ajax-target" class="search">
					  <?php while (have_posts()) : the_post(); ?>
					  	<?php get_template_part('search', 'result'); ?>
					  <?php	endwhile; ?>
					<?php else: ?>
					  <h2>Nothing Found</h2>
					  <p>
					    Sorry, but nothing matched your search criteria. Please try again with some different keywords.
					  </p>
					<?php endif; ?>
					</div>
					<?php if ( $wp_query->max_num_pages > 1 ) : ?>
						<div class="cta">
							<?php echo get_next_posts_link( 'Load More') ?>
						</div>
					<?php endif; ?>
					<hr/>
					<h3>Search Again</h3>
					<?php get_search_form(); ?>
				</div>
			</article>
		</div>
	</div>
</section>

<?php get_footer(); ?>
