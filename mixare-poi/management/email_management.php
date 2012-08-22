<h3>E-Mail changes</h3>
<?php
	$wpdb->show_errors();
	$table = $wpdb->prefix . "oldmails";
	$users = $wpdb->prefix . "users";
	$users = $wpdb->get_results("SELECT * FROM " . $table . " m JOIN " . $users . " u ON (m.user_id = u.ID) ORDER BY u.ID ASC", ARRAY_A);
?>
<table border="0" id="mail-grid" cellspacing="0">
	<tr>
		<td><strong>User</strong></td>
		<td><strong>E-Mail change history</strong></td>
		<td class="lasttd"><strong>Current E-Mail</strong></td>
	</tr>
<?php
	foreach($users as $user){
		$mails = implode(", ", unserialize($user['mail']));
?>
	<tr>
		<td>
			<a href="<?php echo get_admin_url(); ?>/user-edit.php?user_id=<?php echo $user['ID']; ?>"><?php echo $user['user_login']; ?></a>
		</td>
		<td>
			<?php echo $mails; ?>
		</td>
		<td class="lasttd">
			<?php echo $user['user_email'] ?>
		</td>
	</tr>
<?
	}
?>
</table>
