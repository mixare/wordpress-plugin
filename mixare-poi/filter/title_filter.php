<?php

function checkPageTitle($content){

	$t = "";
	if(isset($_SERVER['REDIRECT_URL']))
		$t = $_SERVER['REDIRECT_URL'];

	if(get_Option('mixare-poi-path') == "http://" . $_SERVER['HTTP_HOST'] . $t){
		if(!isset($_GET['page'])){
			if(!is_user_logged_in()){
				//get the login template
				$GLOBALS['post']->post_title = "Login";
			}
			else{
				//get the Maps Page
				$GLOBALS['post']->post_title = get_option('mixare-poi-title');
			}
			$p = null;
		}
		else{
			$p = $_GET['page'];
		}

		$own = null;
		if(isset($_GET['set']))
			$own = $_GET['set'];
	
	//check all pages
		if($p == 'Profile'){
			$GLOBALS['post']->post_title = "Profile";
		}
		else if($p == 'Register'){
			$GLOBALS['post']->post_title = "Register";
		}
		else if($p == 'Password'){
			$GLOBALS['post']->post_title = "Password Recovery";
		}
		else if($p == 'Maps'){
			$GLOBALS['post']->post_title = get_option('mixare-poi-title');
		}
	}

	$GLOBALS['post']->post_title .= "<br /><br />";
}

?>
