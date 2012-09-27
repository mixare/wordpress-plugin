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



//add Actions
add_action('admin_menu', 'mixareManagementMenu');
add_action('admin_head', 'printManagementCSS');
add_action('wp_head', 'printPageCSS');
add_action('widgets_init', create_function('', 'return register_widget("MixarePOI");'));
add_action('get_header', 'checkPageTitle');

// add filter
add_filter('the_content', 'checkPageSpacehold');


//loading scripts maps
require_once(MIXAREPOI_DIR.'/calss-load-map-scripts.php');
Load_Map_Scripts::init();



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

?>