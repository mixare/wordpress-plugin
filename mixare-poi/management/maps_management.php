<h3>Map overview:</h3>
<?php
	$wpdb->show_errors();
	$table = $wpdb->prefix . "mixare_map";
	$poi = $wpdb->prefix . "mixare_poi";
	$pre = $wpdb->prefix;

	if(isset($_GET['d'])){
		$wpdb->query("DELETE FROM " . $poi . " WHERE map_id = " . $_GET['d']);
		$wpdb->query("DELETE FROM " . $table . " WHERE map_id = " . $_GET['d']);
	}

	$maps = $wpdb->get_results("SELECT ID, user_login, state, pass, m.name as mapname, m.map_id AS mapid, COUNT(p.poi_id) as poicount, webpage FROM " . $table . " m LEFT OUTER JOIN " . $poi . " p ON (m.map_id = p.map_id) JOIN " . $pre . "users u ON (m.user_id = u.ID) GROUP BY m.map_id", ARRAY_A);
?>
<table border="0" id="mail-grid" cellspacing="0">
	<tr>
		<td><strong>User</strong></td>
		<td><strong>Map name</strong></td>
		<td><strong>Visibility</strong></td>
		<td><strong>Marks</strong></td>
		<td><strong>Link</strong></td>
		<td class="lasttd"><strong>Actions</strong></td>
	</tr>
<?php
	foreach($maps as $map){
?>
	<tr>
		<td>
			<a href="user-edit.php?user_id=<?php echo $map['ID']; ?>"><?php echo $map['user_login']; ?></a>
		</td>
		<td>
			<?php echo $map['mapname']; ?>
		</td>
		<td>
			<?php echo $map['state']; ?>
		</td>
		<td>
			<?php echo $map['poicount']; ?>
		</td>
		<td>
			<?php echo get_Option('siteurl'); ?>/map.php?map=<?php echo $map['mapid'] ?><?php if(!$map['state']){echo "&k=" . $map['pass'];} ?>
		</td>
		<td class="lasttd">
			<a href="tools.php?page=mixare-poi-options&m=maps&d=<?php echo $map['mapid'] ?>">Delete</a>
		</td>
	</tr>
<?
	}
?>
</table>
