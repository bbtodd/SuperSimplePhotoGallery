<?php
/*
Plugin Name: Super Simple Slideshow Plugin
Description: A straightforward gallery / slideshow plugin. Use shortcode: [ss_photo_gallery] and it builds a gallery using all images attached to post/page. Attributes: layout=1 (Photo Grid - default) layout=2 (Slideshow). If you use this shortcode more than once ona single page only the first slideshow will animate.
Version: 1.0
Author: Bill Todd
Author URI: https://billbobtodd.com/
Text Domain: slideshow plugin
*/

/* Live Site */

/* Start Adding Functions Below this Line */

add_action('wp_enqueue_scripts', 'mslb_public_scripts');

function mslb_public_scripts(){
  wp_register_script('ss_slideshow_js', plugins_url('/js/ss-slideshow.js',__FILE__ ), array('jquery'), '', true);
  wp_enqueue_script('ss_slideshow_js');
}

//If needed in future add a stylesheet
//wp_enqueue_style( 'slideshow', get_stylesheet_directory_uri().'/js/slideshow.css' ); 
function sup_slideshow_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'sup_slideshow_css', $plugin_url . 'css/sup_slideshow.css?x=x1xsx2' );
}
add_action( 'wp_enqueue_scripts', 'sup_slideshow_plugin_css' );




// Shortcode to output javascript photo gallery
// Use shortcode: [ss_photo_gallery]
function ss_gallery_code( $attributes ) {
	
	extract( shortcode_atts( array(
        'layout' => 1, //Default value is 1 - grid gallery 
    ), $attributes ) );
	

    //A simple slideshow
   //reference javascript cis-114 - slideshow 7-2 

	//Layout Option 1 // photo grid
	if($layout == 1) {

		$photo_gallery = '<div id="gallery-grid">';
	   
		$images =& get_children( array (
			'post_parent' => get_the_ID(),
			'post_type' => 'attachment',
			'post_mime_type' => 'image'
		));

		if ( empty($images) ) {
			// no attachments here
		} else {
			$counter = 0;
			foreach ( $images as $attachment_id => $attachment ) {
				$thumb_image = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
				$main_image = wp_get_attachment_image_url( $attachment_id, 'medium' );
				$attachment_title = get_the_title($attachment_id);

			   if ($counter == 0) { 
					$initial_image = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
				}
				$photo_gallery .= '<div  class="ss-gallery" style="padding:5px;"><a href="'.$main_image.'" title="'.$attachment_title.'" rel="attachment">';
				$photo_gallery .= '<img src="'.$thumb_image.'" alt=""></a></div>'. PHP_EOL;
			}
		}
		$photo_gallery .= '</div>';
	} //End if statement




	//Layout Option 2 // single photo slideshow
	if($layout == 2) {

	$photo_gallery .= '<ul id="image_list" style="display: none;">';
   
       $images =& get_children( array (
           'post_parent' => get_the_ID(),
           'post_type' => 'attachment',
           'post_mime_type' => 'image'
       ));

       if ( empty($images) ) {
           // no attachments here
       } else {
           $counter = 0;
           foreach ( $images as $attachment_id => $attachment ) {
               if ($counter == 0) { 
                   $first_image = wp_get_attachment_image_url( $attachment_id, 'medium' );
               }
               $photo_gallery .= '<li class="slide"><a href="';
               $photo_gallery .= wp_get_attachment_image_url( $attachment_id, 'medium' );
               $photo_gallery .= '"></a></li>' . PHP_EOL;
           }
       }
       
   
       $photo_gallery .= '</ul>';
	   	$photo_gallery .= $atts;

       $photo_gallery .= '<p><img src="'. $first_image .'" alt="Film Still" id="ssimage"></p>';       
	} //end if statement

   return $photo_gallery; 

}
add_shortcode( 'ss_photo_gallery', 'ss_gallery_code');





/* Stop Adding Functions Below this Line */
?>