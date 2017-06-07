<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_Shortcodes {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_Shortcodes();
    }
    return self::$instance;
  }
  private function __construct() {
    add_shortcode("members_not_logged_in", array($this, 'members_not_logged_in_shortcode'));
  }

  public function members_not_logged_in_shortcode($content) {
    return is_feed() || is_user_logged_in() || is_null( $content ) ? '' : do_shortcode( $content );
  }
}