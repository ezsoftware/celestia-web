<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_Scripts {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Scripts();
    }
    return self::$instance;
  }

  private function __construct() {
	  add_action( 'wp_enqueue_scripts', array($this, 'enfold_enqueue_styles') );
  }	
  
  public function enfold_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}
}