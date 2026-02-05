<?php
// 404 redirects
function sociality_404_redirect(){
	
	if( is_404() ){

		$redirected_url = '';

		//Get and clean url
		$requested_url = $_SERVER['REQUEST_URI'];
		$requested_url_clean = str_replace(get_site_url(),'',$requested_url); 
		$requested_url_clean = strtok($requested_url_clean, '?');
		$requested_url_clean = strtok($requested_url_clean, '&');
		$requested_url_clean = urldecode($requested_url_clean);
		$requested_url_array = explode('/',$requested_url_clean);
		
		$args = array(
			'post_type'=>'post',
			'fields'=> 'ids',
			'numberposts'  => 1,
			'meta_key'=>'legacy_url', //You can change this to the selected meta field
			'meta_value'=> $requested_url_clean,
			'meta_compare'=>'='
		);
		$redirect_posts = get_posts($args);
		if(!empty($redirect_posts)){
			$redirect_post_id = reset($redirect_posts);
			$redirected_url = get_the_permalink($redirect_post_id);
			return $redirected_url;
		}
	}
}
add_filter( 'pre_redirect_guess_404_permalink', 'sociality_404_redirect' );