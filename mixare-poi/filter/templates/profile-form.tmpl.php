<?php
$current = wp_get_current_user();
$userid = $current->ID;
$menu = get_Option('page_menu');
global $wpdb;
if($menu == "checked")
	include_once("menu.inc.php");

$wpdb->show_errors();
if(is_user_logged_in()){

	if($_POST['update'] == "true"){

		$m = true;
		$t = "";
		$table = $wpdb->prefix . "usermeta";
		$wpdb->update($table, array('meta_value' => $_POST['first_name']), array('user_id' => $userid, 'meta_key' => 'first_name'));
		$wpdb->update($table, array('meta_value' => $_POST['last_name']), array('user_id' => $userid, 'meta_key' => 'last_name'));

		$table = $wpdb->prefix . "users";
		$oldmails = $wpdb->prefix . "oldmails";

		if(check_email_address($_POST['email'])){
			$query = $wpdb->get_row("SELECT * FROM " . $oldmails . " m JOIN " . $table . " u ON (m.user_id = u.ID) WHERE u.ID = " . $userid, ARRAY_A);
			if($query['user_email'] != $_POST['email']){
				if($query['mail'] == ""){
					$not = $wpdb->get_row("SELECT * FROM " . $table . " WHERE ID = " . $userid, ARRAY_A);
					$wpdb->query("INSERT INTO " . $oldmails . " VALUES (" . $userid . ", '" . getMails($not['mail'], $not['user_email']) . "')");
				}else{
					$wpdb->update($oldmails, array('mail' => getMails($query['mail'], $query['user_email'])), array('user_id' => $userid));
				}
				$wpdb->update($table, array('user_email' => $_POST['email']), array('ID' => $userid));
			}
		}else{
			$t = "Error -> E-Mail Adress not valid.";
			$m = false;
		}

		if($_POST['pass1'] == $_POST['pass2'] && trim($_POST['pass1']) != ""){
			$pass = wp_hash_password($_POST['pass1']);
			$wpdb->update($table, array('user_pass' => $pass), array('ID' => $userid));
		}
		else if($_POST['pass1'] != $_POST['pass2']){
			$m = false;
			$t = "Error -> Password mismatch.";
		}
		
		
		if($m){
			$t = "Profile Updated.";
		}
?>
			<div class="profile-message"><?php echo $t; ?> Redirecting...</div>
			<meta http-equiv="refresh" content="0; URL=<?php echo get_Option('user_page'); ?>&page=Profile">
<?php
	}else{
?>


<form action="<?php echo get_Option('user_page'); ?>&page=Profile" method="post" class="page-form">
	<table border="0">
		<input type="hidden" name="update" value="true" redonly="readonly"/>
		<tr>
			<td>Username:</td><td><input type="text" value="<?php echo $current->user_login; ?>" name="user_login" disabled="disabled" title="The Username can't be changed" /></td>
		</tr>
		<tr>
			<td>First Name:</td><td><input type="text" name="first_name" value="<?php echo $current->user_firstname; ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td>Last Name:</td><td><input type="text" name="last_name" value="<?php echo $current->user_lastname; ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td>E-Mail:</td><td><input type="text" name="email" value="<?php echo $current->user_email; ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td style="vertical-align:top;">New Password:</td><td><input type="password" name="pass1" value="" autocomplete="off" /><br /><input type="password" name="pass2" value="" autocomplete="off" /></td>
		</tr>
		<tr><td><input type="submit" value="Update Profile" name="submit" /></td><td></td></tr>
	</table>
</form>
<br /><br />
<strong>Username:</strong>
<p>The Username can't be changed, because it is the identifier for your Account.</p>
<strong>E-Mail hints:</strong>
<p>The E-Mail has to be a valid one. It is possible to use a E-Mail like "a%aBC!!@example.com". Also TLD's like ".bz.it" are supported.</p>
<strong>Password hints:</strong>
<p>You are not allowed to use Blankspaces as Password. The Password should contain between 8 and 20 signs. It sould also contain at least one CAPS and at least one NUMBER. After following this steps you should be safe.</p>

<?php
	}
}else{
?>
	<p>You have no permission to view this Page. Redirecting...</p>
	<meta http-equiv="refresh" content="0; URL=<?php echo get_Option('mixare-poi-path'); ?>">
<?php
}

function getMails($mails, $mail){
	if($mails != ""){
		$unser = unserialize($mails);
		$unser[] = $mail;
	}
	else{
		$unser = Array();
		$unser[0] = $mail;
	}

	
	return serialize($unser);
}

function check_email_address($email) {
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    return false;
  }
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false;
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

?>
