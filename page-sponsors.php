<?php 
/* 
	Template Name: Page Sponsors	
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
<section class="theme-soot default-pad article-wrapper">
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
					<?php
						$sponsors = get_field('sponsorship_level');
										
						if($sponsors):
							foreach($sponsors as $sponsor):
					?>
								<div class="col-md-8 col-md-offset-2 text-center sponsor-info">
									<h3><?php echo $sponsor['sponsorship_level_title']; ?></h3>
									<h4><?php echo $sponsor['sponsorship_level_description']; ?></h4>
								</div>
								<div class="sponsor-grid equalize">
							<?php
								foreach($sponsor['sponsorship_level_sponsors'] as $this_sponsor):
								$url = $this_sponsor['url'];
								if($url):
									$name = '<a href="'.$url.'" target="_blank">'.$this_sponsor['name'].'</a>';
								else:
									$name = $this_sponsor['name'];
								endif;
							?>
									<div class="column col-md-4 col-sm-2 text-center">
										<div class="sp-image">
											<?php 
												if($url):
													echo '<a href="'.$url.'" target="_blank">';
												endif;	
											?>
											<img src="<?php echo $this_sponsor['logo']['url']?>" class="mcbc-sponsor-logo"/><br/>
											<?php	
											if($url):
												echo '</a>';
											endif;
										?>
										</div>
										<h4><?php echo $name; ?></h4>
										<strong><?php echo $this_sponsor['sponsorship_amount']; ?></strong>
										<?php	
											if($url):
												echo '</a>';
											endif;
										?>
										<?php
											$profile = $this_sponsor['sponsor_profile_link'];
											if($profile) {
										?>
											<p><a href="<?php echo $profile; ?>"><?php the_field('sponsor_profile_label');?></a></p>
										<?php
											}
										?>
									</div>
							<?php
								endforeach;	
							?>
								</div>
					<?php
						endforeach;
						endif;
					?>
				</div>
				<?php get_template_part('modules/page', 'cta'); ?>
			</article>
			<?php endwhile; wp_reset_query(); ?>
		</div>
	</div>
</section>
<?php get_template_part('modules/feed', 'socialmedia'); ?>
<?php get_footer(); ?>