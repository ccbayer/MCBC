<?php
	$subscribe = true;	
?>
<footer class="theme-black">
	<div class="container">
		<div class="row">
			<div class="text-center">
				<img src="<?php bloginfo('template_url'); ?>/images/mcbc-logo-footer.png" alt="" class="footer-logo"/>
			</div>
		</div>
		<div class="thirds equalize" data-equalize-min="768">
			<div class="third">
				<div class="content-block">
					<i class="icon icon-phone"></i>
					<h4 class="text-celeste">Call</h4>
					<a href="tel:+<?php the_field('phone_number', 'options');?>" title="Call MCBC"><?php the_field('phone_number', 'options'); ?></a>
				</div>
				<div class="content-block">
					<i class="icon icon-email"></i>
					<h4 class="text-celeste">Email</h4>
					<a href="mailto:<?php the_field('email_address', 'options');?>"><?php the_field('email_address', 'options');?></a>
				</div>
				<div class="content-block hide-more-than-tablet">
					<i class="icon icon-mail"></i>
					<h4 class="text-celeste">Mailing Address</h4>
					<address>
						<?php the_field('mailing_address', 'options');?>
					</address>
				</div>
				<div class="content-block hide-more-than-tablet">
					<i class="icon icon-home"></i>
					<h4 class="text-celeste">Physical Address</h4>
					<address>
						<?php the_field('physical_address', 'options');?>
					</address>
				</div>
			</div>
			<?php if(get_field('footer_button_list', 'options')): ?>
			<div class="third">
				<ul class="button-list">
					<?php 
						$btns = get_field('footer_button_list', 'options');
						foreach ($btns as $btn):
							if($btn['footer_button_destination'] !== 'custom'):
								if($btn['footer_button_destination'] === 'external'):
									$target = "_blank";
									$href = $btn['footer_button_destination_external'];
								elseif($btn['footer_button_destination'] === 'internal'):
									$target = "_self";
									$href = $btn['footer_button_destination_internal'];									
								endif;
								$class = '';
								$etc = '';
							elseif($btn['footer_button_destination'] === 'custom'):
								if($btn['footer_button_destination_custom'] === 'subscribe'):
									$target = '_self';
									$href = 'javascript:void();';
									$class = $btn['footer_button_destination_custom'];
									$etc = 'data-toggle="modal" data-target="#'.$class.'"';
								endif;
																
							endif;
					?>
						<li><a href="<?php echo $href; ?>" class="button border-celeste color-celeste theme-black" target="<?php echo $target; ?>" <?php echo $etc; ?>><?php echo $btn['footer_button_label']; ?></a></li>
					<?php
						endforeach;
					?>	
				</ul>
			</div>
			<?php endif; ?>
			<div class="third hide-less-than-tablet">
				<div class="content-block">
					<i class="icon icon-mail"></i>
					<h4 class="text-celeste">Mailing Address</h4>
					<address>
						<?php the_field('mailing_address', 'options');?>
					</address>
				</div>
				<div class="content-block">
					<i class="icon icon-home"></i>
					<h4 class="text-celeste">Physical Address</h4>
					<address>
						<?php the_field('physical_address', 'options');?>
					</address>
				</div>
			</div>
		</div>
		<?php get_template_part('modules/links', 'socialmedia-footer'); ?>
		<?php 
			$links = get_field('footer_link_list', 'options');
			$chunks = array_chunk($links, 3);
			
			
			if($links):
		?>
			<div class="thirds equalize">
		<?php		
			foreach($chunks as $chunk):
				echo '<div class="third"><ul class="footer-link-list">';
				foreach($chunk as $chunklet):
					$destination = $chunklet['footer_link_destination_internal'];
					if($chunklet['footer_link_destination'] === 'external'):
						$destination = $chunklet['footer_link_destination_external'];						
					endif;
					echo '<li><a href="'.$destination.'" title="'.$chunklet['footer_link_label'].'">'.$chunklet['footer_link_label'].'</a></li>';
				endforeach;
				echo '</div>';		
			endforeach;
		?>
			</div>
		<?php 
			endif;
		?>
		
		<div class="footer-message">
			&copy; <?php echo date('Y'); ?> <?php the_field('copyright', 'options'); ?>
			<p>
			<?php echo the_field('footer_msg', 'options'); ?>
			</p>
		</div>
		
	</div>
</footer>
</div>

<div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
	    <?php get_search_form(); ?>
      </div>
    </div>
  </div>
</div> 

<?php if($subscribe) { ?>
<div class="modal fade" id="subscribe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <a href="#" role="button" type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-cross"></span></a>
        <h3 class="modal-title color-celeste" id="myModalLabel">Subscribe Now</h3>
        <hr/>
      </div>
      <div class="modal-body">
	      <p>Subscribe to updates to find out when our latest events are, and more.</p>
	      <div id="output"></div>
        <?php 
		$args = array(
			'prepend' => '', 
			'showname' => true,
			'nametxt' => 'Name:', 
			'nameholder' => 'Name...', 
			'emailtxt' => 'Email:',
			'emailholder' => 'Email Address...', 
			'showsubmit' => true, 
			'submittxt' => 'Submit', 
			'jsthanks' => false,
			'thankyou' => 'Thank you for subscribing to our mailing list'
			);
			echo smlsubform($args);
	    ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php the_field('google_analytics_snippet', 'options'); ?>
<?php wp_footer(); ?>
</body>
</html>