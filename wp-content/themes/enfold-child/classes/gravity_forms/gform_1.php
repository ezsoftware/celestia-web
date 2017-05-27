<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_GForm_1 {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_GForm_1();
    }
    return self::$instance;
  }
  private function __construct() {
    add_filter('gform_field_validation_1_4', array($this, 'form_1_4_validation'), 10, 4);
  }

  public function form_1_4_validation($result, $value, $form, $field) {
    if(!preg_match("[^A-Za-z0-9\s_\-\']", $value)) {
      $result['is_valid'] = true;
    } else {
      $result['is_valid'] = false;
      $result['message'] = "The character name can only contain alphanumeric characters (A-Z, 0-9), underscores, dashes, spaces and apostrophes";
    }
    return $result;
  }
}