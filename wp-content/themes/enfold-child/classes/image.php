<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_Image {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Image();
    }
    return self::$instance;
  }
  private function __construct() {
	  add_filter('image_send_to_editor',array($this, 'switch_to_relative_url'),10,8);
  }	
  
  //Make image urls embedded with media insert relative path
	public function switch_to_relative_url($html, $id, $caption, $title, $align, $url, $size, $alt)
	{
		$imageurl = wp_get_attachment_image_src($id, $size);
		$relativeurl = wp_make_link_relative($imageurl[0]);   
		$html = str_replace($imageurl[0],$relativeurl,$html);
		  
		return $html;
	}
}