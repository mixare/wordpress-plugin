<h3>Category management:</h3>
<?php
	$wpdb->show_errors();
	$table = $wpdb->prefix . "mixare_category";
	$pre = $wpdb->prefix;

	if(isset($_GET['n'])){
		$wpdb->query("INSERT INTO " . $table . " VALUES ('', '" . $_GET['n'] . "')");
	}else if(isset($_GET['u'])){
		$wpdb->query("UPDATE " . $table . " SET name = '" . $_GET['u'] . "' WHERE category_id = " . $_GET['id']);
	}

	$categories = $wpdb->get_results("SELECT * FROM " . $table, ARRAY_A);
?>
<table border="0" id="mail-grid" cellspacing="0">
	<tr>
		<td><strong>ID</strong></td>
		<td><strong>Name</strong></td>
		<td class="lasttd"><strong>Actions</strong></td>
	</tr>
<?php
	foreach($categories as $category){
?>
	<tr>
		<td>
			<?php echo $category['category_id'] ?>
		</td>
		<td>
			<?php echo $category['name'] ?>
		</td>
		<td class="lasttd">
			*
		</td>
	</tr>
<?
	}
?>
	<tr>
		<form action="tools.php" method="GET">
		<td>
			<input type="hidden" name="page" value="mixare-poi-options" />
			<input type="hidden" name="m" value="category" />
			<select name="id">
<?php
			foreach($categories as $id){
?>
				<option><?php echo $id['category_id']; ?></option>
<?php
			}
?>
			</select>
		</td>
		<td>
			<input type="text" name="u" value="" />
		</td>
		<td class="lasttd">
			<input type="submit" value="Update" />
		</td>
		</form>
	</tr>
	<tr>
		<form action="tools.php" method="GET">
		<td>
			<input type="hidden" name="page" value="mixare-poi-options" />
			<input type="hidden" name="m" value="category" />
			New
		</td>
		<td>
			<input type="text" name="n" value="" />
		</td>
		<td class="lasttd">
			<input type="submit" value="Create" />
		</td>
		</form>
	</tr>
</table>
<br />
*Categories can't be deleted, because of the fact, that one Map could already be in that exact category.
