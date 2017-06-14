<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_NavMenu {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_NavMenu();
    }
    return self::$instance;
  }
  private function __construct() {
    add_filter( 'wp_nav_menu_items', array($this, 'cw_nav_item_dynamics'));
  }

  public function cw_nav_item_dynamics($items, $args) {
    $user = wp_get_current_user();
    foreach($user as $key => $value) {
      $items = str_replace('{' . $key . '}', $value, $items);
    }
    return $items;
  }
}