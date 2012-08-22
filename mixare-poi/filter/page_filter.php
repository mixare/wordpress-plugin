<?php

function checkPageSpacehold($content){

	$t = "";
	if(isset($_SERVER['REDIRECT_URL']))
		$t = $_SERVER['REDIRECT_URL'];

	if($GLOBALS['post']->post_content == '[mixare-poi]' && get_option('mixare-poi-path') == "http://" . $_SERVER['HTTP_HOST'] . $t){
		$p = "";
		if(!isset($_GET['page'])){
			if(!is_user_logged_in()){
				//get the login template
				include_once('templates/login-form.tmpl.php');
			}
			else{
				//get the profile template
				include_once('wp-content/plugins/mixare-poi/maps/available.php');
			}
			$p = null;
		}
		else{
			$p = $_GET['page'];
		}
		
	//check all pages
		if($p == 'Profile'){
			include_once('templates/profile-form.tmpl.php');
		}
		else if($p == 'Register'){
			include_once('templates/register-form.tmpl.php');
		}
		else if($p == 'Password'){
			include_once('templates/password-form.tmpl.php');
		}
		else if($p == 'Maps'){
			include_once('wp-content/plugins/mixare-poi/maps/available.php');
		}
		/*else{
			echo 'Error 404';
		}*/
	}else if($GLOBALS['post']->post_content == '[mixare-poi]' && get_option('mixare-poi-map-path') == "http://" . $_SERVER['HTTP_HOST'] . $t){
		include_once('wp-content/plugins/mixare-poi/maps/output/all.php');
	}else{
		return $content;
	}
}

?>
