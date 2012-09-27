<?php
/*
Plugin Name: Mixare POI
Plugin URI:  http://www.mixare.org/wordpress-plugin/
Description: Wordpress plugin to easily create mixare data sources. Mixare is an open source augmented reality browser for android and iOs. Both the plugin and mixare are licensed under the GPLv3.
Author: Patrick Gruber - Mixare Team
Version: 0.0.1-snapshot
Author URI: http://www.mixare.org/
*/

//add definition of constant
define('MIXAREPOI_VERSION', '0.0.1-SNAPSHOT');
define('MIXAREPOI_DIR', plugin_dir_path(__FILE__));
define('MIXAREPOI_URL', plugin_dir_url(__FILE__));
define('MIXAREPOI__FILE__', ABSPATH . PLUGINDIR . '/mixare-poi/mixare-poi.php');

//installing the necessary options -> install/installer.php
require_once(MIXAREPOI_DIR.'/install/installer.php');


add_action('admin_menu', 'mixareManagementMenu');
add_action('admin_head', 'printManagementCSS');
add_action('wp_head', 'printPageCSS');
add_action('widgets_init', create_function('', 'return register_widget("MixarePOI");'));
add_action('get_header', 'checkPageTitle');

add_filter('the_content', 'checkPageSpacehold');

LoadMapScripts::init();


//register the Management Menu for the Management Menu 
function mixareManagementMenu() {
	add_management_page('Mixare POI Options', 'Mixare POI', 'manage_options', 'mixare-poi-options', 'displayMixareManagement');
}

//displaying the management Page in the Admin Control Panel -> management/menu_page.php
function displayMixareManagement() {
	global $wpdb;
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap">';
	include_once('management/menu_page.php');
	echo '</div>';
}

//print admin css file -> styles/management.css
function printManagementCSS(){
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . plugins_url('styles/management.css', __FILE__) . "\" />";
}

//print page css file -> styles/mixare-pages.css
function printPageCSS(){
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . plugins_url('styles/mixare-pages.css', __FILE__) . "\" />";
}

//creating the Widget for the Sidebar -> widget/widget.php		
include_once('widget/widget.php');

//checking page for filter hook -> filter/page_filter.php
include_once('filter/page_filter.php');

//checking page for title hook -> filter/title_filter.php
include_once('filter/title_filter.php');

//loading scripts -> maps/load-map-scripts.php
class LoadMapScripts {
	static $add_script = false;
 
	function init() {
		if(isset($_GET['map']) && !empty($_GET['map'])){
			//if(is_user_logged_in()){
				add_action('init', array(__CLASS__, 'registerScript'));
				add_action('wp_footer', array(__CLASS__, 'printScript'));
			//}
		}
		add_filter('the_content', array(__CLASS__, 'checkPageContent'));
	}
	function registerScript() {
		wp_register_script('js', 'http://maps.google.com/maps/api/js?sensor=true', '1.0', true);
		wp_register_script('map_poi', plugins_url('maps/scripts/map_poi.js', __FILE__), array('jquery'), '1.0', true);

		self::$add_script = true;
	}
	function printScript() {
		if ( ! self::$add_script )
			return;

		wp_print_scripts('js');
		include_once('maps/inc/data.php');
		wp_print_scripts('map_poi');
	}
	function checkPageContent($content){
		$t = "";
		if(isset($_SERVER['REDIRECT_URL']))
			$t = $_SERVER['REDIRECT_URL'];

		if(get_Option('mixare-poi-path') == "http://" . $_SERVER['HTTP_HOST'] . $t){
			if(is_user_logged_in()){
				//do something other	
			}
		}
		else{
			return $content;
		}
	}
}
?>