<?php 
	$cta = array(
		"text" => get_field('call_to_action_text'), 
		"desc" => get_field('cta_description'),
		"type" => get_field('destination_type'),
		"target" => '_self'
	);

	if($cta['type'] === 'internal') {
		$internal = get_field('cta_internal');
		$cta['href'] = get_permalink($internal[0]->ID);
	}else if($cta['type'] === 'archive' || $cta['type'] === 'eventcategory') {
		$archive = get_field('cta_archive_destination');
		$cta['href'] = get_term_link($archive, 'target');					
	}else if($cta['type'] === 'external') {
		$cta['href'] = get_field('cta_external_destination');
		$cta['target'] = get_field('new_window') ? '_blank' : '_self';
	}else if($cta['type'] === 'download') {
		$url = get_field('cta_download_destination');
		$cta['href'] = $url[0]->guid;
		$cta['target'] = '_blank';
	}	
	if($cta['text'] && $cta['href'] && $cta['type']):
?>


<div class="cta">
	<a href="<?php echo $cta['href'] ?>" target="<?php echo $cta['target']; ?>" class="button border-soot color-soot"><?php echo $cta['text']; ?></a>
<?php 
	if($cta['desc']):	
?>
	<div class="description color-soot"><?php echo $cta['desc']; ?></div>
<?php
	endif;	
?>
</div>

<?php 
	endif;
?>