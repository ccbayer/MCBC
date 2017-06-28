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
	}else if($cta['type'] === 'target' || $cta['type'] === 'eventcategory') {
		$target = get_field('cta_target_destination');
		$cta['href'] = get_term_link($target, 'target');
	} else if ($cta['type'] === 'project') {
		$project = get_field('cta_project_destination');
		$cta['href'] = get_term_link($project, 'project');		
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
	<a href="<?php echo $cta['href'] ?>" target="<?php echo $cta['target']; ?>" class="button border-white color-white"><?php echo $cta['text']; ?></a>
<?php 
	if($cta['desc']):	
?>
	<div class="description"><?php echo $cta['desc']; ?></div>
<?php
	endif;	
?>
</div>

<?php 
	endif;
?>