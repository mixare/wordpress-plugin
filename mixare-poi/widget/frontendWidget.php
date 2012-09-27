<?php 
$current = wp_get_current_user();
extract($args);

$title = $instance['title'];
$titlea = $instance['titlea'];

if(is_user_logged_in())
	$head = apply_filters('widget_title', sprintf($titlea, $current->user_login));
else
	$head = apply_filters('widget_title', $title);
	echo $before_widget;
	if($title){ 
		echo $before_title . $head .  $after_title; 
	}

	if(is_user_logged_in())
		include_once('menu.php');
	else
		include_once('login-form.php');

	echo $after_widget; 
?>