<span>
	<h5>Map settings:</h5><br />
	<label for="mixare-name">Mapname:</label><br /><input type="text" id="mixare-name" /><br />
	<input type="radio" id="mixare-public" value="public" name="visible" checked="checked" /><label for="mixare-public">public</label><br />
	<input type="radio" id="mixare-private" value="private" name="visible" /><label for="mixare-private">private</label><br />
	<select id="mixare-category">
<?php 
	$sql = "SELECT * FROM " . $wpdb->prefix . "mixare_category";
	$query = $wpdb->get_results($sql, ARRAY_A);
	foreach($query as $c){
?>
		<option value="<?php echo $c['category_id']; ?>" id="mixare-category-<?php echo $c['category_id']; ?>"><?php echo $c['name']; ?></option>
<?php
	}
?>
	</select>
</span>
<span>
	<h5>Marker actions:</h5><br />
	<input type="radio" id="mixare-move" value="move" name="modify" checked="checked" /><label for="mixare-move">move Map</label><br />
	<input type="radio" id="mixare-insert" value="insert" name="modify" /><label for="mixare-insert">insert Mark</label><br />
	<input type="radio" id="mixare-delete" value="delete" name="modify" /><label for="mixare-delete">delete Mark</label><br />
	<input type="radio" id="mixare-modify" value="modify" name="modify" /><label for="mixare-modify">modify Mark</label><br />
</span>
<span>
	<input type="button" id="mixare-save" value="Save Map" /><br />
	<input type="button" id="mixare-delete" value="Delete Map" />
</span>
