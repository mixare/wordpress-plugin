<?php
function mixarePOIInstall(){
	global $wpdb;

	add_option('mixare-poi-title', '');
	add_option('mixare-poi-path', '');
	add_option('mixare-poi-login', '');
	add_option('mixare-poi-map-title', '');
	add_option('mixare-poi-map-path', '');
	
	$pre = $wpdb->prefix;
	$wpdb->query("CREATE TABLE " . $pre . "oldmails (user_id BIGINT( 20 ) NOT NULL ,mail TEXT NULL ,PRIMARY KEY ( user_id )) ENGINE = MyISAM");
	$wpdb->query("CREATE TABLE " . $pre . "mixare_poi (poi_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,lat FLOAT( 19, 15 ) NOT NULL ,lng FLOAT( 19, 15 ) NOT NULL ,elevation INT NOT NULL ,title VARCHAR( 100 ) NOT NULL ,distance INT NOT NULL ,has_detail_page BOOL NOT NULL ,webpage VARCHAR( 250 ) NOT NULL ,map_id BIGINT NOT NULL) ENGINE = MyISAM");
	$wpdb->query("CREATE TABLE " . $pre . "mixare_map (map_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,name VARCHAR( 100 ) NOT NULL ,state BOOL NOT NULL ,date DATE NOT NULL ,pass VARCHAR( 10 ) NOT NULL ,user_id BIGINT NOT NULL ,category_id BIGINT NOT NULL) ENGINE = MyISAM");
	$wpdb->query(" CREATE TABLE " . $pre . "mixare_category (category_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,name VARCHAR( 100 ) NOT NULL) ENGINE = MYISAM ");
	
}
?>
