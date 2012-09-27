<?php

if (!class_exists("Load_Map_Scripts")) :

  class Load_Map_Scripts {

    static $add_script = false;

    function init() {
      if (isset($_GET['map']) && !empty($_GET['map'])) {
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
      if (!self::$add_script)
        return;

      wp_print_scripts('js');
      include_once('maps/inc/data.php');
      wp_print_scripts('map_poi');
    }

    function checkPageContent($content) {
      $t = "";
      if (isset($_SERVER['REDIRECT_URL']))
        $t = $_SERVER['REDIRECT_URL'];

      if (get_Option('mixare-poi-path') == "http://" . $_SERVER['HTTP_HOST'] . $t) {
        if (is_user_logged_in ()) {
          //do something other
        }
      } else {
        return $content;
      }
    }

  }

  endif;
?>