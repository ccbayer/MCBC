<?php

require_once('../../../../wp-load.php');

if ($_REQUEST['sml_subscribe']) {
	$name = $_REQUEST['sml_name'];
	$email = $_REQUEST['sml_email'];

	if (is_email($email)) {

		$exists = mysql_query("SELECT COUNT(*) as Total FROM ".$wpdb->prefix."sml where sml_email like '".$wpdb->escape($email)."'");
		
		$data = mysql_fetch_assoc($exists);
				
		if ($data['Total'] < 1) {
			$wpdb->query("insert into ".$wpdb->prefix."sml (sml_name, sml_email) values ('".$wpdb->escape($name)."', '".$wpdb->escape($email)."')");
			echo '0';
		} else {
			echo '1';
		}
		
	} else {
		echo '-1';
	}
}
?>