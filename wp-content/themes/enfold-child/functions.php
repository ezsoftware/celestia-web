<?php
	add_action( 'wp_enqueue_scripts', 'enfold_enqueue_styles' );
	function enfold_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}

	//Make image urls embedded with media insert relative path
	function cel_switch_to_relative_url($html, $id, $caption, $title, $align, $url, $size, $alt)
	{
		$imageurl = wp_get_attachment_image_src($id, $size);
		$relativeurl = wp_make_link_relative($imageurl[0]);   
		$html = str_replace($imageurl[0],$relativeurl,$html);
		  
		return $html;
	}
	add_filter('image_send_to_editor','cel_switch_to_relative_url',10,8);

	/**
	 * Hide admin bar from certain user roles
	 */
	function cel_hide_admin_bar( $show ) {
		return ( 
			current_user_can('king') ||
			current_user_can('queen') ||
			current_user_can('kings_guard') ||
			current_user_can('administrator') 
		);
	}
	add_filter( 'show_admin_bar', 'cel_hide_admin_bar' );
	
	function cel_members_not_logged_in ($params, $content = null){
	  //check tha the user is logged in
	  if ( !is_user_logged_in() ){
	 
		//user is logged in so show the content
		return $content;
	 
	  }
	 
	  else{
	 
		//user is not logged in so hide the content
		return;
	 
	  }
	 
	}
	 
	//add a shortcode which calls the above function
	add_shortcode('members-not-logged_in', 'cel_members_not_logged_in' );