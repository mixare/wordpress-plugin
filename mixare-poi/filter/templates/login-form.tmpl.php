
<form action="<?php echo get_option('siteurl') ?>/wp-login.php" method="post" class="page-form">
	<table border="0">
		<tr><td><?php echo _e('Username'); ?>:</td><td><input type="text" name="log" size="20" id="user_login" /></td></tr>
		<tr><td><?php echo _e('Password'); ?>:</td><td><input type="password" name="pwd" size="20" id="user_pass" /></td></tr>
		<tr><td></td><td><input type="checkbox" value="forever" id="rememberme"/> <?php echo _e('Stay signed in'); ?></td></tr>
		<tr><td>
			<input type="hidden" name="redirect_to" value="<?php echo get_Option('mixare-poi-path');?>" />
			<input type="submit" value="Log In" id="wp-submit" name="wp-submit" class="button-primary" />
		</td><td></td></tr>
		<tr><td><a href="<?php echo get_Option('user_page');?>&page=Register"><?php echo _e('Register'); ?></a><br /><a href="<?php echo get_Option('user_page');?>&page=Password"><?php _e('Forgot Password?'); ?></a></td><td></td></tr>
	</table>
</form>
