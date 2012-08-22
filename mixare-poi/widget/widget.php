<?php

class MixarePOI extends WP_Widget{

	public static $instance = null;

	//Functions
	function MixarePOI(){
		parent::WP_Widget(false, $name = "Mixare POI");
	}
	function form($instance){
		$title = esc_attr($instance['title']);
		$titlea = esc_attr($instance['titlea']);
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title before Login:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('titlea'); ?>"><?php _e('Title after Login: (%s for the User)*'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('titlea'); ?>" name="<?php echo $this->get_field_name('titlea'); ?>" type="text" value="<?php echo $titlea; ?>" />
		</p>
		<p>
			* The actually logged in user will be displayed, if you insert the placeholder "%s".
		</p>
<?php
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['titlea'] = strip_tags($new_instance['titlea']);
		return $instance;
	}
	function widget($args, $instance){
		include_once('frontendWidget.php');
	}

}

?>
