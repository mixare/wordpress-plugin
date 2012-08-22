<?php
	if(isset($_POST['title'])){
		update_option('mixare-poi-title', $_POST['title']);
		update_option('mixare-poi-path', $_POST['path']);
		update_option('mixare-poi-login', $_POST['login']);
		update_option('mixare-poi-map-title', $_POST['map-title']);
		update_option('mixare-poi-map-path', $_POST['map-path']);
?>

		<div class="message">Changes saved successfully.</div>

<?php

	}

	$login = get_option('mixare-poi-login');
?>

<h3>Mixare POI</h3>
<form action="#" method="post" class="management-form">
	<table border="0">
		<tr>
			<td></td><td><strong>Page where you want to see all your Maps</strong></td>
		</tr>
		<tr>
			<td><label for="title">Page Title:</label></td>
			<td><input type="text" name="map-title" id="map-title" value="<?php echo get_option('mixare-poi-map-title'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="path">Page path:</label></td>
			<td><input type="text" name="map-path" id="map-path" value="<?php echo get_option('mixare-poi-map-path') ?>" /></td>
		</tr>
		<tr>
			<td></td><td><strong>Page where you want to have the Google Map</strong></td>
		</tr>
		<tr>
			<td><label for="title">Page Title:</label></td>
			<td><input type="text" name="title" id="title" value="<?php echo get_option('mixare-poi-title'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="path">Page path:</label></td>
			<td><input type="text" name="path" id="path" value="<?php echo get_option('mixare-poi-path') ?>" /></td>
		</tr>
		<tr>
			<td></td><td><strong>Widget settings</strong></td>
		</tr>
		<tr>
			<td>Login to use:</td>
			<td>
				<input type="radio" name="login" value="no-login" id="no-login" <?php if($login == "no-login"){ echo "checked=\"checked\""; } ?>/><label for="no-login">no Login needed</label><br />
				<input type="radio" name="login" value="own-login" id="own-login" <?php if($login == "own-login"){ echo "checked=\"checked\""; } ?>/><label for="own-login">use a other Login Plugin</label><br />
				<input type="radio" name="login" value="mixare-login" id="mixare-login" <?php if($login == "mixare-login" || $login == ""){ echo "checked=\"checked\""; } ?>/><label for="mixare-login">use the Mixare Login Widget</label>
			</td>
		</tr>
		<tr>
			<td><input type="submit" value="Save changes" /></td>
			<td></td>
		</tr>
	</table>
</form>
