<?php
	$slides = get_field('hero_image_gallery');
	if($slides) {
		$length = sizeof($slides);
		$time = get_field('slideshow_timing') ? (get_field('slideshow_timing') * 1000) : 10000;
?>
<section class="slider-full-width" data-length="<?php echo $length; ?>">
    <div id="hero-carousel">
	  <div class="carousel-inner slick-wrapper" data-time="<?php echo $time; ?>" data-pause-on-hover="<?php the_field('pause_on_hover'); ?>" data-autoplay="<?php the_field('autoplay'); ?>" role="listbox">
	  	<?php 
			for($i = 0; $i < $length; $i++) {	
				if($i === 0) {
					$currentclass = "active";
				} else {
					$currentclass = '';
				}
				$type = $slides[$i]['slide_type'];				
				$tablet = $slides[$i]['gallery_image_tablet']['url'] ? 'data-src-med="' . $slides[$i]['gallery_image_tablet']['url'].'"' : false;
				$mobile = $slides[$i]['gallery_image_mobile']['url'] ? 'data-src-small="' . $slides[$i]['gallery_image_mobile']['url'].'"' : false;
				if($slides[$i]['slide_type'] === "full") {
					$currentclass = $currentclass . ' display-content';
				}
				// slide link
				$link = $slides[$i]['link_destination'];
			    	if($link === 'internal'): 
			    		$href = $slides[$i]['call_to_action_destination_internal'];
			    		$target = "_self";
			    	else:
			    		$href = $slides[$i]['call_to_action_destination_external'];
			    		$target = "_blank";			    		
			    	endif;
			
		    	echo '<div class="item ' .$currentclass. ' b-lazy" data-src="'.$slides[$i]['gallery_image']['url'].'" '.$tablet.' '.$mobile.' alt="">';		    			
		    		if($slides[$i]['slide_type'] === "full") {
			    		echo '
						<img src="'.get_bloginfo('template_url').'/images/celeste-triangle.svg" class="slider-backdrop"/>
			    		<div class="slider-content container-xl">
			    			<div class="slider-heading"><h1>'.$slides[$i]['headline'].'</h1></div>
			    			<div class="slider-body-container">
			    				<div class="slider-body">'.$slides[$i]['body'].'</div>
			    					<div class="cta">
			    						<a href="'.$href.'" target="'.$target.'" class="button border-black color-black">'.$slides[$i]['call_to_action_label'].'</a>
									</div>
								</div>			    		
			    		</div>';
		    		} else if ($slides[$i]['slide_type'] === "linked_image") {
			    		echo '<a href="'.$href.'" target="'.$target.'" class="linked-image"></a>';
		    		} else if ($slides[$i]['slide_type'] === "cta") {
			    		echo '<div class="slide-cta-wrapper"><a href="'.$href.'" target="'.$target.'" class="slide-cta button border-'.$slides[$i]['cta_theme'].' color-'.$slides[$i]['cta_theme'].'">'.$slides[$i]['call_to_action_label'].'</a></div>';
		    		}
		    	echo '</div>';
			} 
		?>
	  </div>
	</div>
</section>
<?php 
	}	
?>