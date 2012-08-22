
<form action="<?php echo get_option('siteurl') ?>/wp-login.php?action=lostpassword" method="post" class="page-form">
	<table border="0">
		<tr><td><?php echo _e('Username or E-mail') ?>:</td><td><input type="text" name="user_login" id="user_login" class="input" size="20" /></td></tr>
		<tr><td></td><td><input type="hidden" name="redirect_to" value="<?php echo get_Option('mixare-poi-path');?>" /><?php echo _e('You will get a new Passwort, sent to your E-Mail Address.'); ?></td></tr>
		<tr><td><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Recovery" tabindex="100" /></td><td></td></tr>
	</table>
</form>

