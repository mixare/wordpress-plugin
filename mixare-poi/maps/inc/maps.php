<?php
	
	global $wpdb;
	$table = $wpdb->prefix;
	$current = wp_get_current_user();
	
	$row = $wpdb->get_results("SELECT m.name, m.state,m.pass AS pass, m.map_id AS map, COUNT(p.poi_id) AS count FROM " . $table . "mixare_map m LEFT OUTER JOIN " . $table . "mixare_poi p ON (p.map_id = m.map_id) WHERE m.user_id = " . $current->ID . " GROUP BY m.map_id", ARRAY_A);
	$count = 0;
	
	foreach($row as $a){
?>
		<div class="mixare-maps" <?php if($count % 2 == 0){echo "style=\"background:#dfdfdf;\"";} ?>>
			<table border="0">
				<tr>
					<td colspan="2"><h4><?php echo utf8_encode($a['name']) ?></h4><span><a href="<?php echo get_Option('mixare-poi-path'); ?>?page=Maps&map=<?php echo $a['map'] ?>">View</a></span></td><td></td>
				</tr>
				<tr>
					<td class="mixare-td-left">Marks:</td><td><?php echo $a['count'] ?></td>
				</tr>
				<tr>
					<td class="mixare-td-left">Visibility:</td><td><?php if($a['state']){echo "public";}else{echo "private";} ?></td>
				</tr>
				<tr>
					<td colspan="2"><input type="text" name="mixare-textfield-link" value="<?php echo get_Option('siteurl'); ?>/map.php?map=<?php echo $a['map']; ?><?php if(!$a['state']){echo "&k=" . $a['pass'];} ?>" class="mixare-textfield" /></td><td></td>
				</tr>
			</table>
		</div>
<?php
		$count++;
	}

?>
	
	<div class="mixare-maps">
		<table border="0">
			<tr>
				<td colspan="2"><?php echo $count; ?> Maps found. <a href="<?php echo get_Option('mixare-poi-path'); ?>?page=Maps&map=new">Create new Map</a></td><td></td>
			</tr>
		</table>
	</div>

