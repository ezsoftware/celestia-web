<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once "admin_bar.php";
require_once "scripts.php";
require_once "image.php";
require_once "gravity_forms.php";
require_once "gravity_forms/index.php";
require_once "avatar.php";

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
    CW_GravityForms::getInstance();
    CW_GForm_Index::getInstance();
    CW_Avatar::getInstance();
  }
}