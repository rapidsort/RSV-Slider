<?php 
/*
Plugin Name: RSV Slider
Plugin URI: http://www.rapidsort.in
Description: Plugin for displaying Images as slider
Author: Rapid Sort
Version: 1.0
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
function rsv_enqueued_assets() {
	wp_enqueue_style( 'owl-style', plugin_dir_url( __FILE__ ) . 'owl.carousel.css');
	wp_enqueue_style( 'owl-theme-style', plugin_dir_url( __FILE__ ) . 'owl.theme.css');
	wp_enqueue_script( 'owl-script', plugin_dir_url( __FILE__ ) . 'owl.carousel.min.js', array(), '1.0', true );
	
}
add_action( 'wp_enqueue_scripts', 'rsv_enqueued_assets',40 );
	
// [rsv_slider foo="foo-value"]
function rsv_func( $atts ) {
    $a = shortcode_atts( array(
        'id' => 'someID',
        'images' => 'No Images',
		'autoplay' => 'true',
    ), $atts );
	
	$images="{$a['images']}";
	$images=explode(",",$images);

$output="<div id='{$a['id']}' class='owl-carousel owl-theme'>";   
        foreach($images as $image){
			$output.="<div class='item'><img src='".$image."' alt='".get_bloginfo('name')."' title='".get_bloginfo('name')."' /></div>";
		}
 $output.="</div>";
	
	
	$output.="<script type='text/javascript'>
    jQuery(document).ready(function() {     
      jQuery('#{$a['id']}').owlCarousel({     
          navigation : true, // Show next and prev buttons
	navigationText: [
      '<i class=".'icon-chevron-left icon-white'."><</i>',
      '<i class=".'icon-chevron-right icon-white'.">></i>'
      ],
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem:true,
		  autoPlay: {$a['autoplay']},
           items : 1, 
           itemsDesktop : false,
           itemsDesktopSmall : false,
           itemsTablet: false,
           itemsMobile : false     
      });   	  
    });
 </script>";
 
 $output.="<style type='text/css'>#{$a['id']} .item img{
        display: block;
        width: 100%;
        height: auto;
    }
	.item > img {
    height: auto;
    width: 100%;
}
.owl-theme .owl-controls .owl-buttons div {
  position: absolute;
}
 
.owl-theme .owl-controls .owl-buttons .owl-prev{
  left: 0;
  top: 50%; 
}
 
.owl-theme .owl-controls .owl-buttons .owl-next{
  right: 0;
  top: 50%;
}
	</style>";

return $output;
    //return "foo = {$a['foo']}, bar = {$a['bar']}";
}
add_shortcode( 'rsv_slider', 'rsv_func' );





add_action( 'admin_menu', 'rsv_plugin_menu' );

function rsv_plugin_menu() {
	add_options_page( 'RSV Slider Options', 'RSV Slider', 'manage_options', 'my-unique-identifier', 'rsv_plugin_options' );
}

function rsv_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	?>
    <h2>RSV Slider Options</h2>
    <p>Plugin for displaying Images as slider</p>
    <div class="updated"><p><strong>Use This Short Code:</strong> [rsv_slider id="Your_ID" images="image1,image2,image3"]</p>
</div>
<h3>Other Properties</h3>
<ul>
  <li>
    <strong>autoPlay:</strong> true, false, 5000
    </li>
    </ul>
    <?php
	
	echo '</div>';
}
?>