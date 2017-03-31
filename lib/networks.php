<?php 
	// instagram
	$instagram_client_id = 'd6c0375e73144c84a1f578ae94051614';
	$instagram_client_secret = '5abef8a5e838430693f4091dffad3797';
	$instagram_endpoint = '/lib/endpoints/instagram.txt';
	$code = '';
	
	$myfile = fopen($instagram_endpoint, "r") or die("Unable to open file!");
	$code = fread($myfile,filesize($instagram_endpoint);
	fclose($myfile);
	
	echo $code;
	
?>