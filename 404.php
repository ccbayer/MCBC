<?php get_header(); ?>
<section class="theme-white default-pad article-wrapper">
	<div class="container">
		<div class="row">'
			<article class="single-page">
				<div class="title">
					<h1>Page Not Found</h1>
				</div>
				<div class="content page-content">
				<?php 
					$content = get_field('page_not_found', 'options');	
					if($content):
						echo $content;
					else:
				?>
				<p>
				  <strong>Did you type the URL?</strong><br />
				  You may have typed the address (URL) incorrectly. Check it to make sure you've got the exact right spelling, capitalization, etc.
				</p>
				<p>
				  <strong>Did you follow a link from somewhere else at this site?</strong><br />
				  If you reached this page from another part of this site.
				</p>
				<p>
				  <strong>Did you follow a link from another site?</strong><br />
				  Links from other sites can sometimes be outdated or misspelled.
				</p>
				<?php endif; ?>
			</div>
		</article>
	</div>
</section>
<?php get_footer(); ?>
<?php get_footer(); ?>