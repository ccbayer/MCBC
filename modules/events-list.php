<?php 
	if(get_field('show_events')):

	echo '<div id="tribe-events-content-wrapper">';
		$eventstitle = get_field('events_title');
	endif;
	
	if(!empty($GLOBALS['events'])):
		if($eventstitle):
			echo '<h2 class="text-center tribe-events-page-title">'.$eventstitle.'</h2>';
		endif;	
		echo '<div id="tribe-events-content" class="tribe-events-list"><div class="tribe-events-content-wrapper row"><div class="tribe-events-loop">';
		foreach($GLOBALS['events'] as $e):
			global $post;
			$post = $e;
			setup_postdata( $post );
?>
	<div class="col-md-12 single-event">
		<?php tribe_get_template_part( 'list/single', 'event' ) ?>
	</div>
	<hr/>
<?php
		endforeach;
		wp_reset_postdata();
		echo '</div></div></div></div>';
	endif;
?>