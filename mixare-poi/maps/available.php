<?php
	if(is_user_logged_in()){
		global $wpdb;
		$table = $wpdb->prefix;

		if(!isset($_GET['map']) && empty($_GET['map'])){
			include_once("inc/maps.php");	
		}
		else if($_GET['map'] == "new" || $_GET['map'] > 0){
?>
			<a href="<?php echo get_Option('mixare-poi-path'); ?>">Back</a><br />
			<div id="mixare-poi-map"></div>
			<div class="mixare-control"><?php include_once('inc/control.php'); ?></div>
			<br /><div id="map-message"></div>
<?php
		}
		else{
?>
			<p>You have no permission to view this Page. Redirecting...</p>
			<meta http-equiv="refresh" content="0; URL=<?php echo get_Option('mixare-poi-path'); ?>">
<?php
		}
	}
?>
