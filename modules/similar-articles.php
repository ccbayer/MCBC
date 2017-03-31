<?php
$post_type = get_post_type();
$id = $post->ID;

// pages don't have terms, so grab the custom one
if($post_type === 'page'):
	$term = get_field('related_taxonomy');
	$term_list = get_term($term, 'target');
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
		// fall back: get similar articles in the same taxonomy.
		$myposts = getSimilarPosts('news', $id, $term_list->name, 3);
	endif;
	
	if($myposts):
?>
<section class="theme-grey">
	<div class="container similar-articles-wrapper">
		<div class="row">
			<h2 class="subheadline"><small>Similar</small> Articles</h2>				
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
						$see_more_link = get_term_link($term_list->slug, 'target');	
						$see_more_title = $term_list->name;
					} else {
						$see_more_link = get_post_type_archive_link('news');
						$see_more_title = $post_type;			
					}
				?>
				<a href="<?php echo $see_more_link; ?>" title="View more <?php echo $see_more_title; ?> Articles" class="button border-white color-white">See More</a>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>