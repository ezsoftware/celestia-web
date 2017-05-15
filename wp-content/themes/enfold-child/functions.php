<?php
	add_action( 'wp_enqueue_scripts', 'enfold_enqueue_styles' );
	function enfold_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}

	//Make image urls embedded with media insert relative path
	function switch_to_relative_url($html, $id, $caption, $title, $align, $url, $size, $alt)
	{
		$imageurl = wp_get_attachment_image_src($id, $size);
		$relativeurl = wp_make_link_relative($imageurl[0]);   
		$html = str_replace($imageurl[0],$relativeurl,$html);
		  
		return $html;
	}
	add_filter('image_send_to_editor','switch_to_relative_url',10,8);

	/**
	 * Hide admin bar from certain user roles
	 */
	function hide_admin_bar( $show ) {
		return ( 
			current_user_can('king') ||
			current_user_can('queen') ||
			current_user_can('kings_guard') ||
			current_user_can('administrator') 
		);
	}
	add_filter( 'show_admin_bar', 'hide_admin_bar' );