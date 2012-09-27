<?php
/**
 * Mixarepoi_Lifecycle_Handler is used to manage the fase of activation, deactivation and uninstall process.
 * Scope of function is private, and this  class must be deny for all other process.
 *
 * @author Alessandro Staniscia
 * @version 0.1
 */
if (!class_exists("Mixarepoi_Lifecycle_Handler")) :

  class Mixarepoi_Lifecycle_Handler {
    const DEBUG_MODE=true;

    static function active_cb() {
      //do Activation
      new Mixarepoi_Lifecycle_Handler("active");
    }

    static function deactive_cb() {
      //do deactivation
      new Mixarepoi_Lifecycle_Handler("deactive");
    }

    static function unistall_cb() {
      if (Mixarepoi_Lifecycle_Handler::DEBUG_MODE || MIXAREPOI__FILE__ == WP_UNINSTALL_PLUGIN) {
        new Mixarepoi_Lifecycle_Handler("uninstall");
      }
    }

    static function DDLs($databasePre="") {
      $dbSchema = array(
          $databasePre . "oldmails" => "CREATE TABLE `" . $databasePre . "oldmails` (user_id BIGINT( 20 ) NOT NULL ,mail TEXT NULL ,PRIMARY KEY ( user_id )) ENGINE = MyISAM",
          $databasePre . "mixare_poi" => "CREATE TABLE `" . $databasePre . "mixare_poi` (poi_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,lat FLOAT( 19, 15 ) NOT NULL ,lng FLOAT( 19, 15 ) NOT NULL ,elevation INT NOT NULL ,title VARCHAR( 100 ) NOT NULL ,distance INT NOT NULL ,has_detail_page BOOL NOT NULL ,webpage VARCHAR( 250 ) NOT NULL ,map_id BIGINT NOT NULL) ENGINE = MyISAM",
          $databasePre . "mixare_map" => "CREATE TABLE `" . $databasePre . "mixare_map` (map_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,name VARCHAR( 100 ) NOT NULL ,state BOOL NOT NULL ,date DATE NOT NULL ,pass VARCHAR( 10 ) NOT NULL ,user_id BIGINT NOT NULL ,category_id BIGINT NOT NULL) ENGINE = MyISAM",
          $databasePre . "mixare_category" => "CREATE TABLE `" . $databasePre . "mixare_category` (category_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,name VARCHAR( 100 ) NOT NULL) ENGINE = MYISAM "
      );
      return $dbSchema;
    }

    private function __construct($fase="") {
      if (!$fase)
        wp_die('Busted! You should not call this class directly', 'Doing it wrong!');

      switch ($fase) {
        case 'active' :
          $this->_create_update_db_tables();
          $this->_add_options();
          break;
        case 'deactive' :
          //do deactivation operation!
          if (!Mixarepoi_Lifecycle_Handler::DEBUG_MODE) {
            break;
          }
        case 'uninstall' :
          $this->_drop_db_tables();
          $this->_remove_options();
          break;
        default:
          wp_die("allowed only activate deactivate uninstall");
      }
    }

    private function _create_update_db_tables() {
      global $wpdb;
      $dbSchema = self::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name || $this->doUpdate) {
          //table no exist or version is no good
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($ddl);
        }
      }
    }

    private function _drop_db_tables() {
      global $wpdb;
      $dbSchema = self::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        $wpdb->query("DROP TABLE {$table_name}");
      }
    }

    private function _add_options() {
      add_option('mixare-poi-title', '');
      add_option('mixare-poi-path', '');
      add_option('mixare-poi-login', '');
      add_option('mixare-poi-map-title', '');
      add_option('mixare-poi-map-path', '');
    }

    private function _remove_options() {
      delete_option('mixare-poi-title');
      delete_option('mixare-poi-path');
      delete_option('mixare-poi-login');
      delete_option('mixare-poi-map-title');
      delete_option('mixare-poi-map-path');
    }

  }

  endif;
?>