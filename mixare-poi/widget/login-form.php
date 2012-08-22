<p>
	<form action="<?php echo get_option('siteurl') ?>/wp-login.php" method="post" name="loginform" class="sidebar-form">
		<p><?php echo _e('Username'); ?></p><p><input type="text" name="log" size="20" id="user_login" /></p>
		<p><?php echo _e('Password'); ?></p><p><input type="password" name="pwd" size="20" id="user_pass" /></p>
		<p><input type="checkbox" value="forever" id="rememberme"/> <?php echo _e('Stay signed in'); ?></p>
		<p>
			<input type="hidden" name="redirect_to" value="<?php echo get_option('mixare-poi-path'); ?>" />
			<input type="submit" value="Log In" id="wp-submit" name="wp-submit" class="button-primary" />
		</p>
		<p><a href="<?php echo get_Option('user_page');?>&page=Register"><?php echo _e('Register'); ?></a></p><p><a href="<?php echo get_Option('user_page');?>&page=Password"><?php _e('Forgot Password?'); ?></a></p>
	</form>
</p>
