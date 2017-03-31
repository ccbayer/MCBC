<article>
	<?php 
		$post_id = get_the_ID();
		$img = get_field('featured_hero_image', $post_id);
	?>
	<?php
		if($img):
	?>
		<a href="<?php the_permalink() ?>"><img src="<?php echo $img['sizes']['archive-thumb'] ?>" alt=""/></a>
	<?php
		else:
		$x = rand(0, 1600);
		$y = rand(0, 1144);
	?>
	<a href="<?php the_permalink() ?>"><div class="bike-pattern-placeholder b-lazy" data-x="<?php echo $x; ?>" data-y="<?php echo $y; ?>" data-src="<?php echo get_template_directory_uri(); ?>/images/MCBC_Bike_Pattern-large.gif"></div></a>	
	<?php
		endif;	
	?>
	<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
	<div class="excerpt">
		<?php the_excerpt(); ?>
	</div>
	<div class="post-meta">
		<time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>">
			<?php the_time( get_option( 'date_format' ) ); ?>
		</time>
		<?php
			$term_list = wp_get_post_terms($post->ID, 'target', array("fields" => "all"));
			if($term_list && !is_tax()) {
			echo '<ul class="term-link">';
			foreach($term_list as $term) {
				$link = get_term_link($term->slug, 'target');
				echo '<li><a href="'.$link.'" title="View All Posts in '.$term->name.'">'.$term->name.'</a></li>';								
			}
			echo '</ul>';
			}
		?>
	</div>
</article>