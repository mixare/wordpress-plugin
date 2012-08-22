<p>
	<ul>
		<li><strong><?php echo _e('Navigation'); ?></strong></li>
		<li><a href="<?php echo get_option('mixare-poi-path'); ?>?page=Maps"><?php echo _e(get_option('mixare-poi-title')); ?></a></li>
		<li><strong><?php echo _e('Profile Controls'); ?></strong></li>
		<li><a href="<?php echo get_option('mixare-poi-path'); ?>?page=Profile"><?php echo _e('Profile Settings'); ?></a></li>
	<?php
		if(is_super_admin($current->ID)){
	?>
		<li>
			<a href="<?php echo get_option('siteurl');?>/wp-admin/"><?php _e('Admin Control Panel') ?></a>
		</li>
	<?php
		}
	?>
		<li><a href="<?php echo wp_logout_url(get_option('siteurl'));?>"><?php echo _e('Logout'); ?></a></li>
	</ul>
</p>
