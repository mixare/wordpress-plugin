<?php

	$state = "before";
	include("../../../../wp-config.php");
	$wpdb = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASSWORD);
	$wpdb->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

	if($_POST['action'] == "save"){
		if($_POST['save'] == "map"){
			//claiming DATA			
			$mapID = $_POST['id'];
			$mapName = $_POST['name'];
			$mapState = $_POST['state'];
			$mapDate = date('Y-m-d');
			$userID = $_POST['userid'];
			$categoryID = $_POST['category'];

			//start saving process
			$sql = "UPDATE " . $table_prefix . "mixare_map SET name = ?, state = ?, date = ?, category_id = ? WHERE user_id = ? AND map_id = ?";
			$query = $wpdb->prepare($sql);
			$check = $query->execute(array(trim(strip_tags(utf8_encode($mapName))), $mapState, $mapDate, $categoryID, $userID, $mapID));

			if($check)
				echo "map";
		}else if($_POST['save'] == "new"){
			$mapID = $_POST['id'];
			$mapName = $_POST['name'];
			$mapState = $_POST['state'];
			$mapDate = date('Y-m-d');
			$userID = $_POST['userid'];
			$pass = generatePass(10);
			$categoryID = $_POST['category'];

			//start saving process
			$sql = "INSERT INTO " . $table_prefix . "mixare_map (name, state, date, pass, user_id, category_id) VALUES (?, ?, ?, ?, ?, ?)";
			$query = $wpdb->prepare($sql);
			$check = $query->execute(array(trim(strip_tags(utf8_encode($mapName))), $mapState, $mapDate, $pass, $userID, $categoryID));
			
			if($check){
				$row = $wpdb->prepare("SELECT * FROM " . $table_prefix . "mixare_map WHERE name = ? AND user_id = ?");
				$row->execute(array($mapName, $userID));
				$id = $row->fetch();
				echo $id['map_id'];
			}
		}else if($_POST['save'] == "marker"){
			if($_POST['del'] == "false"){
				$poiID = $_POST['poiid'];
				$elevation = $_POST['elevation'];
				$title = $_POST['title'];
				$distance = $_POST['distance'];
				$webpage = $_POST['webpage'];
				$mapID = $_POST['mapid'];
				$has_detail_page = 0;

				//extracting latlng->string
				$latlng = str_replace("(", "", $_POST['latlng']);
				$latlng = str_replace(")", "", $latlng);
				$pos = explode(",", $latlng);
				$lat = trim($pos[0]);
				$lng = trim($pos[1]);
				
				if($webpage != "")
					$has_detail_page = 1;

				if($_POST['poiid'] == "null"){
					$sql = "INSERT INTO " . $table_prefix . "mixare_poi (lat, lng, elevation, title, distance, has_detail_page, webpage, map_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
					$update = $wpdb->prepare($sql);
					$check = $update->execute(array($lat, $lng, $elevation, strip_tags($title), $distance, $has_detail_page, strip_tags($webpage), $mapID));

					if($check){
						$row = $wpdb->prepare("SELECT poi_id FROM " . $table_prefix . "mixare_poi WHERE name = '?' AND lat = ? AND lng = ?");
						$row->execute(array(strip_tags($title), $lat, $lng));
						$id = $row->fetch();
						echo $id['poi_id'];
					}
				}else if(is_int(intval($_POST['poiid']))){
					$sql = "UPDATE " . $table_prefix . "mixare_poi SET lat = ?, lng = ?, elevation = ?, title = ?, distance = ?, has_detail_page = ?, webpage = ? WHERE poi_id = ?";
					$update = $wpdb->prepare($sql);
					$check = $update->execute(array($lat, $lng, $elevation, strip_tags($title), $distance, $has_detail_page, strip_tags($webpage), $poiID));
		
					if($check)
						echo "Saved successfully.";
					else
						echo "Something strange happened.";
				}
			}else{
				if($_POST['poiid'] != "null"){
					$latlng = str_replace("(", "", $_POST['latlng']);
					$latlng = str_replace(")", "", $latlng);
					$pos = explode(",", $latlng);
					$lat = trim($pos[0]);
					$lng = trim($pos[1]);

					$poiID = $_POST['poiid'];
					$sql = "DELETE FROM " . $table_prefix . "mixare_poi WHERE poi_id = ?";
					$conn = $wpdb->prepare($sql);
					$check = $conn->execute(array($poiID));
	
					if($check)
						echo "Saved successfully.";
					else
						echo "Something strange happened.";
				}
			}
		}
	}

function generatePass($laenge=8,$strpool="abcdefghijklmnopqrstuvwxyz123456789"){ 
    $str = '';
    for($i = 0; $i < $laenge; $i++){
		$str .= substr($strpool,(rand()%(strlen ($strpool))), 1);    
	}
    return $str;
}
?>
