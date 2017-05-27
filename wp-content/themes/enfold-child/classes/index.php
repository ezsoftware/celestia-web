<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once "admin_bar.php";
require_once "scripts.php";
require_once "image.php";

class CW_Classes {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Classes();
    }
    return self::$instance;
  }
  private function __construct() {
    CW_Scripts::getInstance();
    CW_Admin_Bar::getInstance();
    CW_Image::getInstance();
  }
}