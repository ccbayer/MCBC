<?php
$post_type = get_post_type();
$id = $post->ID;
$isProjectPage = false;
if(get_page_template_slug() == "page-projects.php"):
	$isProjectPage = true;
endif;

// pages don't have terms, so grab the custom one
if($post_type === 'page'):
	if($isProjectPage):
		// get the associated project
		$term = get_field('selected_project');
		$term_list = get_term($term, 'project');
	else:
		$term = get_field('related_taxonomy');
		$term_list = get_term($term, 'target');
	endif;
else:
	$term_list = wp_get_post_terms($post->ID, 'target', array("fields" => "all"));
	// if there are more than one, just pick first
	$term_list = $term_list[0]; 
endif;


$customType = false;
$myposts = get_field('similar_posts');
	if($myposts):
		$customType = true;
		if(sizeof($myposts) < 3):
			$num = 3 - sizeof($myposts);
			// build array of posts to exclude 
			$exclude = array($id);
			foreach($myposts as $post):
				array_push($exclude, $post['similar_post']->ID);
			endforeach;
			$exclude = implode(', ', $exclude);
			$myposts = array_merge($myposts, getSimilarPosts('news', $exclude, $term_list->name, $num));
		endif;
	else:
		$myposts = getSimilarPosts('news', $id, $term_list->name, 3, $term_list->taxonomy);
	endif;

	if($myposts):
?>
<section class="theme-grey">
	<div class="container similar-articles-wrapper">
		<div class="row">
			<h2 class="subheadline">
			<?php 
				$headline = get_field('similar_posts_headline', $id);
				if($headline):	
					echo $headline;
			?>
				<?php else: ?>
					<small>Similar</small> Articles
				<?php endif; ?>
			</h2>
		</div>
		<div class="row similar-articles">
<?php
		foreach ( $myposts as $post ) : 
			if($customType && is_array($post)):
				$post = $post['similar_post'];
			endif;			
			setup_postdata( $post ); 
?>
  			<article>
	  			<?php 
			  		$post_id = get_the_ID();
			  		$img = get_field('featured_hero_image', $post_id);
			  		if($img['url']):
			  	?>
			  		<a href="<?php the_permalink() ?>"><img src="<?php echo $img['sizes']['archive-thumb'] ?>" alt=""/></a>
			  	<?php
			  		else:
			  			$hero_image['url'] = get_template_directory_uri() ."/images/MCBC_Bike_Pattern-large.gif";
			  			$x = rand(0, 1600);
			  			$y = rand(0, 1144);
			  	?>
			  		<a href="<?php the_permalink() ?>"><div class="bike-pattern-placeholder b-lazy" data-x="<?php echo $x; ?>" data-y="<?php echo $y; ?>" data-src="<?php echo get_template_directory_uri(); ?>/images/MCBC_Bike_Pattern-large.gif"></div></a>
			  	<?php
			  		endif;
			  	?>
			  	
				<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
				<?php the_excerpt(); ?>
				<div class="post-meta">
					<time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>">
						<a href="<?php the_permalink() ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
					</time>
				</div>
			</article>
<?php 
		endforeach;
		wp_reset_postdata(); 
?>

		</div>
		<?php // should add checkbox for this ?>
		<div class="row">
			<div class="col-md-4 col-md-offset-4 text-center">
				<?php 
					if($term_list) {
						$see_more_link = get_term_link($term_list->slug, $term_list->taxonomy);	
						$see_more_title = $term_list->name;
					} else {
						$see_more_link = get_post_type_archive_link('news');
						$see_more_title = $post_type;			
					}
					$see_more_label = get_field('see_more_label') ? get_field('see_more_label') : "See More";
				?>
				<a href="<?php echo $see_more_link; ?>" title="View more <?php echo $see_more_title; ?> Articles" class="button border-white color-white"><?php echo $see_more_label; ?></a>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>