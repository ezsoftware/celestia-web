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
    add_filter( 'wp_nav_menu_items', array($this, 'cw_nav_item_dynamics'), 10, 2);
  }

  public function cw_nav_item_dynamics($items, $args) {
    $user = wp_get_current_user();
    $unread_count = 0;
    foreach($user->data as $key => $value) {
      if($key === '_fep_user_message_count') {
        $unread_count += $value['unread'];
      } else if(!is_object($value) && !is_array($value)) {
        $items = str_replace('{' . $key . '}', $value, $items);
      }
    }
    if($user && $user->data && $user->data->display_name)
      $name = explode(' ', $user->data->display_name);
    else
      $name = array('Guest', '');
    $items = str_replace('{firstname}', $name[0], $items);
    $items = str_replace('{lastname}', $name[1], $items);
	  $items = str_replace('{avatar}', get_avatar($user->ID, 16), $items);
    $items = str_replace('{undread_messages}', $unread_count > 0 ? '<a href="/private-messages/" class="menu-unread-count">' . $unread_count . '</a>' : '', $items);
    return $items;
  }
}