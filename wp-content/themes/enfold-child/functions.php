<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once "classes/index.php";

class CW_Functions {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Functions();
    }
    return self::$instance;
  }
  private function __construct() {
    CW_Classes::getInstance();
  }
}
CW_Functions::getInstance();