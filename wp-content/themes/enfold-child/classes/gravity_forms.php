<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CW_GravityForms {  
  static $instance = null;
  public static function getInstance() {
    if(self::$instance === null) {
      self::$instance = new CW_GravityForms();
    }
    return self::$instance;
  }
  private function __construct() {
    add_filter( 'gform_field_content', array($this, 'filter_gf_select_optgroup'), 10, 2 );
    
    add_action( 'gform_enqueue_scripts', array($this, 'add_gform_scripts'), 10, 2);
  }

  public function filter_gf_select_optgroup( $input, $field ) {
    /** https://gist.github.com/codearachnid/a06e13be7f01b81b838c
    * Filter Gravity Forms select field display to wrap optgroups where defined
    * USE:
    * set the value of the select option to `optgroup` within the form editor. The 
    * filter will then automagically wrap the options following until the start of 
    * the next option group
    */
    if ( $field->type == 'select' ) {
      $opt_placeholder_regex = strpos($input,'gf_placeholder') === false ? '' : "<\s*?option.*?class='gf_placeholder'>[^<>]+<\/option\b[^>]*>";
      $opt_regex = "/<\s*?select\b[^>]*>" . $opt_placeholder_regex . "(.*?)<\/select\b[^>]*>/i";
      $opt_group_regex = "/<\s*?option\s*?value='optgroup\b[^>]*>([^<>]+)<\/option\b[^>]*>/i";

      preg_match($opt_regex, $input, $opt_values);
      if(count($opt_values) > 1) {
        $split_options = preg_split($opt_group_regex, $opt_values[1]);
        $optgroup_found = count($split_options) > 1;

        // sometimes first item in the split is blank
        if( strlen($split_options[0]) < 1 ){
          unset($split_options[0]);
          $split_options = array_values( $split_options );
        }

        if( $optgroup_found ){
          $fixed_options = '';
          preg_match_all($opt_group_regex, $opt_values[1], $opt_group_match);
          if( count($opt_group_match) > 1 ){
            foreach( $split_options as $index => $option ){
              $fixed_options .= "<optgroup label='" . $opt_group_match[1][$index] . "'>" . $option . '</optgroup>';
            }
          }
          $input = str_replace($opt_values[1], $fixed_options, $input);
        }
      }
    }

    return $input;
  }

  public function add_gform_scripts( $form, $is_ajax=true ) {
    wp_enqueue_script('lodash', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js', array(), '4.17.4', false);

    $formId = $form['id'];
    $formPath = get_stylesheet_directory() . '/js/gravity_forms/gform_' . $formId . '.js';
    $formUri = dirname(get_stylesheet_uri()) . '/js/gravity_forms/gform_' . $formId . '.js';
    if(file_exists($formPath)) {
      wp_enqueue_script('gform-' . $formId, $formUri, array(), 1, true);
    }

    $formPath = get_stylesheet_directory() . '/css/gravity_forms/gform_' . $formId . '.css';
    $formUri = dirname(get_stylesheet_uri()) . '/css/gravity_forms/gform_' . $formId . '.css';
    if(file_exists($formPath)) {
      wp_enqueue_style('gform-' . $formId, $formUri);
    }
  }
}