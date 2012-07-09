<?php
/**
 * Plugin Name: PHPCodez Text
 * Plugin URI: http://phpcodez.com/
 * Description: A widget that displays content on specified pages
 * Version: 0.1
 * Author: PHPCodez
 * Author URI: http://phpcodez.com/
 */


add_action( 'widgets_init', 'wpc_text_widgets' );


function wpc_text_widgets() {
	register_widget( 'wpcWidget' );
}


class wpcWidget extends WP_Widget {

	
	function wpcWidget() {
		$widget_ops = array( 'classname' => 'wpcClass', 'description' => __('A widget that displays content on specified pages.', 'wpcClass') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
		$this->WP_Widget( 'example-widget', __('PHPCodez Text', ''), $widget_ops, $control_ops );
	}
	
	function getCurrentPageURL() {
 		$pageURL = 'http';
	 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		   $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		return $pageURL;
	}

	
	

	function widget( $args, $instance ) {
		extract( $args );
		$title 		 = $instance['title'] ;
		$pageText	 = $instance['pageText'];
		$pageTitle 	 = $instance['pageTitle'];
		$exclude	 = $instance['exclude'];
		$surls=array_filter(explode("\n",$title));
		foreach($surls as $val){
			if(trim($val)==$this->getCurrentPageURL()){
				$printHere=1; break;
			}
		}
			
		if($exclude){
			if(!$printHere or empty($title)) {
				if($pageTitle)
					echo "<br /><h1>".$pageTitle."</h1><br />";
				echo nl2br($pageText);
			}
		}else{
			if($printHere or empty($title)) {
				if($pageTitle)
					echo "<br /><h1>".$pageTitle."</h1><br />";
				echo nl2br($pageText);
			}
		}		
		
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 		 =  strip_tags( $new_instance['title'] );
		$instance['pageText']	 =  $new_instance['pageText'] ;
		$instance['pageTitle']	 =  $new_instance['pageTitle'] ;
		$instance['exclude']	 =  $new_instance['exclude'] ;
	
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude From The Given Pages', 'wpclass'); ?></label>
			<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="1" <?php if($instance['exclude']) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Page URL(s) (Target by URL(s))', 'wpcclass'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" style="width:95%; height:50px; border:1px solid #ccc" ><?php echo $instance['title']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'pageTitle' ); ?>"><?php _e('Title:', 'wpcclass'); ?></label>
			<input id="<?php echo $this->get_field_id( 'pageTitle' ); ?>" name="<?php echo $this->get_field_name( 'pageTitle' ); ?>" value="<?php echo $instance['pageTitle']; ?>" style="width:95%; border:1px solid #ccc" />
		</p>

	
		<p>
			<label for="<?php echo $this->get_field_id( 'pageText' ); ?>"><?php _e('Text:', 'wpcclass'); ?></label>
<textarea id="<?php echo $this->get_field_id( 'pageText' ); ?>" name="<?php echo $this->get_field_name( 'pageText' ); ?>"  style="width:98%; height:200px;"><?php echo $instance['pageText']; ?></textarea>
			
		</p>

	

	<?php
	}
}

?>