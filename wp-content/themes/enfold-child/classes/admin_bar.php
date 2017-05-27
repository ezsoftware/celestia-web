<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_Admin_Bar {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Admin_Bar();
    }
    return self::$instance;
  }
  private function __construct() {
	add_filter( 'show_admin_bar', array($this, 'hide_admin_bar') );
  }

  public function hide_admin_bar( $show ) {
    return ( 
      current_user_can('king') ||
      current_user_can('queen') ||
      current_user_can('kings_guard') ||
      current_user_can('administrator') 
    );
  }
}