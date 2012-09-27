<?php
	global $wpdb;
	$table = $wpdb->prefix;

	$categories = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "mixare_category", ARRAY_A);
	$current = wp_get_current_user();
	$f = "";
	
	$range = 10;
	$start = 1;
	if(isset($_GET['start']))
		$start = $_GET['start'];

	if(isset($_GET['f']) && isset($_GET['c'])){
		$f = $_GET['f'];
		$res = explode("|", $_GET['c']);
		$ser = explode(" ", $_GET['f']);
		$sql = "SELECT user_login, DATE_FORMAT(m.date, '%e.%c.%Y') as date, m.name, m.state,m.pass AS pass, m.map_id AS map, COUNT(p.poi_id) AS count, COUNT(m.map_id) AS maps FROM " . $table . "mixare_map m LEFT OUTER JOIN " . $table . "mixare_poi p ON (p.map_id = m.map_id) LEFT OUTER JOIN " . $table . "users u ON (m.user_id = u.ID) WHERE state = 1 AND m.name LIKE '";
		foreach($ser as $s){
			$sql .= "%" . $s . "%";
		}
		$sql .= "' AND m.category_id = " . $res[0] . " GROUP BY m.map_id ORDER BY count DESC";
		$search = $wpdb->get_results($sql, ARRAY_A);
	}else{
		$search = $wpdb->get_results("SELECT user_login, DATE_FORMAT(m.date, '%e.%c.%Y') as date, m.name, m.state,m.pass AS pass, m.map_id AS map, COUNT(p.poi_id) AS count, COUNT(m.map_id) AS maps FROM " . $table . "mixare_map m LEFT OUTER JOIN " . $table . "mixare_poi p ON (p.map_id = m.map_id) LEFT OUTER JOIN " . $table . "users u ON (m.user_id = u.ID) WHERE state = 1  GROUP BY m.map_id ORDER BY count DESC", ARRAY_A);
	}
?>

<div class="search-top">
	<form action="" method="get">
		<input type="text" name="f" id="search-text" value="<?php echo $f; ?>" />
		<select name="c">
<?php
			foreach($categories as $category){
?>
			<option value="<?php echo $category['category_id'] ?>|<?php echo $category['name'] ?>"><?php echo $category['name'] ?></option>
<?php
			}
?>
		</select>
		<input type="submit" value="Find" />
	</form>
<?php
	if(isset($_GET['f']) && isset($_GET['c'])){
?>
	<span><h6><?php echo count($search); ?></h6> result<?php if(count($search) != 1){echo "s"; } ?> for <h6>'<?php echo $f; ?>'</h6> in <h6><?php echo $res[1]; ?></h6> </span>
<?php
	}else{
?>
	<span>Showing <h6>all</h6> results (<?php echo count($search); ?> result<?php if(count($search) != 1){echo "s"; } ?>)</span>
<?php
	}
?>
</div>

<?php
	if(count($search) == 0){
		echo "<div class=\"search-frame\"><h3>We are sorry, there are no " . get_option('mixare-poi-map-title') . " to display, referring to your search query.</h3></div>";
	}
?>
<?php
	for($i = (10 * ($start - 1)); $i <= (10 * $start); $i++){
		if(isset($search[$i]['name'])){
?>
			<hr />
				<div class="mixare-maps">
					<table border="0">
						<tr>
							<td colspan="2"><h4><?php echo utf8_encode($search[$i]['name']) ?></h4><span>by <?php echo $search[$i]['user_login'] ?></span></td><td></td>
						</tr>
						<tr>
							<td class="mixare-td-left">Marks:</td><td><?php echo $search[$i]['count'] ?></td>
						</tr>
						<tr>
							<td class="mixare-td-left">Last Update:</td><td><?php echo $search[$i]['date']; ?></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="mixare-textfield-link" value="<?php echo get_Option('siteurl'); ?>/map.php?map=<?php echo $search[$i]['map']; ?>" class="mixare-textfield" /></td><td></td>
						</tr>
					</table>
				</div>
<?php
		}
	}
?>
<hr />
<div class="search-frame">
<?php
for($i = 1; $i < (count($search) / $range); $i++){
	if($start == $i){
?>
	<?php echo $i; ?>
<?php
	}else{
?>
	<a href="<?php echo get_option('mixare-poi-map-path'); ?>?<?php if(isset($_GET['f'])){echo $_GET['f'];} ?>&start=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php
	}
}
?>
</div>