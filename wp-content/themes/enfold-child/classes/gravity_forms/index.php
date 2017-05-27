<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once "gform_1.php";

class CW_GForm_Index {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_GForm_Index();
    }
    return self::$instance;
  }
  private function __construct() {
    CW_GForm_1::GetInstance();
  }
}