<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_FepFilters {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_FepFilters();
    }
    return self::$instance;
  }
  private function __construct() {
    add_filter('fep_filter_before_email_send', array($this, 'cw_fep_filter_before_email_send'), 99, 3);
  }
  public function cw_fep_filter_before_email_send($mail, $post, $to) {
    $mail['message'] = str_replace("/private-messages", get_site_url() . '/private-messages', $mail['message']);
    return $mail;
  }
}