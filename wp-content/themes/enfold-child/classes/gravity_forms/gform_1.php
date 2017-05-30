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
    add_filter('gform_field_validation_1_4', array($this, 'form_1_4_validation'), 99, 4);
    add_filter('gform_validation_1', array($this, 'form_1_validation'), 99, 1);
  }

  public function form_1_4_validation($result, $value, $form, $field) {
    var_dump($result);
    if(!preg_match("[^A-Za-z0-9\s_\-\']", $value['4.3']) && !preg_match("[^A-Za-z0-9\s_\-\']", $value['4.6'])) {
      $result['is_valid'] = true;
      $result['message'] = null;
    } else {
      $result['is_valid'] = false;
      $result['message'] = "The character name can only contain alphanumeric characters (A-Z, 0-9), underscores, dashes, spaces and apostrophes";
    }
    return $result;
  }

  public function form_1_validation($validation_result) {
    $form = $validation_result['form'];

    if( preg_match("[^A-Za-z0-9\s_\-\']", rgpost('input_1_4_3')) || preg_match("[^A-Za-z0-9\s_\-\']", rgpost('input_1_4_6')) )  {
      $validation_result['is_valid'] = false;
      foreach( $form['fields'] as &$field) {
        if($field->id == '4') {
          $field->failed_validation = true;
          $field->validation_message = 'The character name can only contain alphanumeric characters (A-Z, 0-9), underscores, dashes, spaces and apostrophes';
          break;
        }
      }
    } else {
      foreach( $form['fields'] as &$field) {
        if($field->id == '4') {
          $field->failed_validation = false;
          $field->validation_message = null;
          break;
        }
      }
    }
    $validation_result['form'] = $form;
    return $validation_result;
  }
}