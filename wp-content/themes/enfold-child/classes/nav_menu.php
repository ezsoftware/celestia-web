<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(file_exists(ABSPATH . '/wp-content/plugins/front-end-pm/includes/class-fep-message.php')) {
  require_once ABSPATH . '/wp-content/plugins/front-end-pm/includes/class-fep-message.php';
}

class CW_NavMenu {  
  static $instance = null;
  static $fep_message = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_NavMenu();
    }
    return self::$instance;
  }
  private function __construct() {
    add_filter( 'wp_nav_menu_items', array($this, 'cw_nav_item_dynamics'), 10, 2);
    if(class_exists('Fep_Message')) {
      self::$fep_message = Fep_Message::init();
    }
  }

  public function cw_nav_item_dynamics($items, $args) {
    $user = wp_get_current_user();
    $unread_count = 0;
    if(self::$fep_message !== null) {
      $unread_counts = self::$fep_message->user_message_count('all', false, $user->ID);
      $unread_count = $unread_counts['unread'];
    }
    foreach($user->data as $key => $value) {
      if(!is_object($value) && !is_array($value)) {
        $items = str_replace('{' . $key . '}', $value, $items);
      }
    }
    if(isset($user) && isset($user->data) && isset($user->data->display_name)) {
      $name = explode(' ', $user->data->display_name);
    } else {
      $name = array('Guest', '');
      $items = str_replace('{display_name}', 'Guest', $items);
    }
    $items = str_replace('{firstname}', $name[0], $items);
    $items = str_replace('{lastname}', $name[1], $items);
	  $items = str_replace('{avatar}', get_avatar($user->ID, 16), $items);
    $items = str_replace('{unread_messages}', ($unread_count > 0 ? ('<span data-href="/private-messages/" class="menu-unread-count">' . $unread_count . '</span>') : ''), $items);
    return $items;
  }
}