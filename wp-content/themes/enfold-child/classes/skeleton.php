<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_Skeleton {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Skeleton();
    }
    return self::$instance;
  }
  private function __construct() {
    
  }
}