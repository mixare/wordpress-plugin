
<form action="<?php echo get_option('siteurl') ?>/wp-login.php?action=register" method="post" class="page-form">
	<table border="0">
		<tr><td><?php echo _e('Username'); ?>:</td><td><input type="text" name="user_login" id="user_login" size="20" /></td></tr>
		<tr><td><?php echo _e('E-Mail'); ?>:</td><td><input type="text" name="user_email" id="user_email" size="20" /></td></tr>
		<tr><td></td><td><?php echo _e('The Password will be sent to your E-Mail Address.'); ?></td></tr>
		<tr><td>
			<input type="hidden" name="redirect_to" value="<?php echo get_Option('mixare-poi-path');?>" />
			<input type="submit" value="<?php echo _e('Register'); ?>" id="wp-submit" name="wp-submit" /></td><td>
		</td></tr>
	</table>
</form>
