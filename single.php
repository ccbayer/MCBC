<?php get_header(); ?>
<?php
$post_type = get_post_type();
$id = $post->ID;
$term_list = wp_get_post_terms($post->ID, 'target', array("fields" => "all"));
$project = wp_get_post_terms($post->ID, 'project', array("fields" => "all"));
if($project) {
	$projectInfo = array(
		'archiveLink' => '<a href="'.get_term_link($project[0]->term_id).'">'.$project[0]->name.'</a>', 
		'projectPageLink' => getProjectPage($project[0]->term_id),
		'projectName' => $project[0]->name
		);
} else {
	$projectInfo = false;
}
// headline 
if(get_field('subheading')) {
	$subheading = get_field('subheading');
}
else if($term_list && sizeof($term_list) > 2) {
	$subheading = $term_list[0]->name;
} 
else if ( $post_type )
{
    $post_type_data = get_post_type_object( $post_type );
    $post_type_slug = $post_type_data->rewrite['slug'];
	$subheading = $post_type_slug;
	if(has_category()) {
		$cats = get_categories();
		foreach($cats as $cat) {
			$subheading .= $cat->name;
		}	
	}
}

$hero_image = get_field('featured_hero_image');
if(!$hero_image['url']):
	$hero_image['url'] = get_template_directory_uri() ."/images/MCBC_Bike_Pattern-large.gif";
endif;
?>
<div class="container-full-width b-lazy" data-src="<?php echo $hero_image['url']; ?>"></div>
<section class="theme-white default-pad article-wrapper">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<article>
				<div class="title">
					<h1>
						<small>
							<?php echo $subheading; ?>
						</small>
						<?php the_title(); ?>
					</h1>
					<div class="post-meta">
						<time datetime="<?php the_time('m-d-Y'); ?> <?php the_time('H:i'); ?>"> Posted on 
							<?php the_date(); ?>
						</time>
						<?php 
							if($project){
								echo '<p><a href="'.$projectInfo['projectPageLink'].'">More about ' . $projectInfo['projectName'] . '</p>';
							}
						?>

					</div>
				</div>
				<div class="content">
					<?php the_content(); ?>
				</div>
				<div class="post-meta-footer">
					<time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>"> Posted on 
						<?php echo get_the_date('F j, Y'); ?>
					</time>
					<div class="tags">
						 <?php the_tags(); ?>
						 <?php 
							if(has_term('', 'project', $post->ID )){
						?>
							<p>Project: <?php echo $projectInfo['archiveLink']; ?></p>
						<?		
							}
						?>
					</div>
				</div>
				<?php get_template_part('modules/events', 'list'); ?>
			</article>
			<?php endwhile; wp_reset_query(); ?>
		</div>
	</div>
</section>

<?php 
	get_template_part('modules/similar', 'articles');	
	get_template_part('modules/feed', 'socialmedia');
?>
<?php get_footer(); ?>