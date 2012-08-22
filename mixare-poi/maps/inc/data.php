<script type="text/javascript">

function getData(){
<?php

$current = wp_get_current_user();

if($_GET['map'] != "new"){	
	global $wpdb;
	$wpdb->show_errors();
	$table = $wpdb->prefix;

	$row = $wpdb->get_results("SELECT elevation, lat, lng, title, webpage, p.poi_id AS point, m.user_id AS users, name, state, category_id FROM " . $table . "mixare_map m LEFT OUTER JOIN " . $table . "mixare_poi p ON (m.map_id = p.map_id) WHERE m.map_id = " . $_GET['map'], ARRAY_A);
	$count = 0;

	if($current->ID == $row[0]['users'] && !empty($row[0]['lat'])){
?>
			actionFile = '<?php echo bloginfo("wpurl"); ?>/wp-content/plugins/mixare-poi/maps/action.php';
			mapID = <?php echo $_GET['map']; ?>;
			userid = <?php echo $current->ID; ?>;
			jQuery('#mixare-name').val('<?php echo $row[0]['name']; ?>');
			jQuery('#mixare-category-<?php echo $row[0]['category_id'] ?>').attr('selected', 'selected');
		<?php
			if($row[0]['state']){
		?>
					jQuery('#mixare-public').attr('checked', 'checked');
		<?php
			}else{
		?>
					jQuery('#mixare-private').attr('checked', 'checked');
		<?php
			}
		foreach($row as $a){
?>
			markerArr[0][<?php echo $count ?>] = new google.maps.LatLng(<?php echo $a['lat'] ?>, <?php echo $a['lng'] ?>);
			markerArr[1][<?php echo $count ?>] = new google.maps.Marker({
				position: markerArr[0][<?php echo $count ?>],
				title: '<?php echo $a['title'] ?>'
			});
			markerArr[2][<?php echo $count ?>] = "<?php echo $a['webpage'] ?>";
			markerArr[3][<?php echo $count ?>] = <?php echo $a['point'] ?>;
			markerArr[4][<?php echo $count ?>] = <?php echo $a['elevation'] ?>;
<?php
			$count++;
		}
	}else if($current->ID == $row[0]['users'] || !empty($row[0]['lat'])){
?>
			actionFile = '<?php echo bloginfo("wpurl"); ?>/wp-content/plugins/mixare-poi/maps/action.php';
			mapID = <?php echo $_GET['map']; ?>;
			userid = <?php echo $current->ID; ?>;
			jQuery('#mixare-name').val('<?php echo $row[0]['name']; ?>');
			<?php
				if($row[0]['state']){
			?>
						jQuery('#mixare-public').attr('checked', 'checked');
			<?php
				}else{
			?>
						jQuery('#mixare-private').attr('checked', 'checked');
<?php
				}
	}else if($current->ID != $row[0]['users']){
?>
	jQuery('#mixare-poi-map').css('display', 'none');
	jQuery('.mixare-control').css('display', 'none');
	jQuery('#map-message').append('You are not allowed to view this Map.');
<?php
	}
}else{
?>
	actionFile = '<?php echo bloginfo("wpurl"); ?>/wp-content/plugins/mixare-poi/maps/action.php';
	userid = <?php echo $current->ID; ?>;
<?php
}
?>
}
</script>
