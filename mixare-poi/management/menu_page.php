<?php

	$m = null;
	if(isset($_GET['m']))
		$m = $_GET['m'];

	if($m == "email")
		include_once('email_management.php');
	else if($m == "maps")
		include_once('maps_management.php');
	else if($m == "category")
		include_once('category_management.php');
	else
		include_once('plugin_management.php');

?>

<div class="bottom-menue">
	<a href="tools.php?page=mixare-poi-options">Plugin Management</a> - <a href="tools.php?page=mixare-poi-options&m=category">Category management</a> - <a href="tools.php?page=mixare-poi-options&m=maps">Map overview</a> - <a href="tools.php?page=mixare-poi-options&m=email">Email changes</a>
</div>
