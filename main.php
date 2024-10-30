<?php
/*
Plugin Name: Category List Portfolio Page
Version: 1.2.3
Plugin URI: http://belicza.com/wordpress/category-list-portfolio-page/
Description: A shortcode what list all Category of the Posts with title and thumbnail icons by a custom page or widget.
Author: david belicza
Author URI: http://belicza.com/
Text Domain: category-list-portfolio-page
*/

//global variables
$clpp_version = '1.2.3';
$clpp_name = 'category-list-portfolio-page';

//languages
add_action( 'admin_init' , 'clpp_reg' );
function clpp_reg(){
	global $clpp_name;
	load_plugin_textdomain($clpp_name, false, '/' . $clpp_name . '/languages/' );
}

function my_init_method() {
	global $clpp_name;
    wp_enqueue_script( 'jquery' );
	wp_enqueue_style($clpp_name . 'user_style', plugins_url( $clpp_name . '/style.css' , dirname(__FILE__) ), false, '1.0', 'all'); 
	wp_enqueue_script($clpp_name . 'animation_page', plugins_url( $clpp_name . '/scripts/animation.js' , dirname(__FILE__) ), false, '1.0', 'all');
}
add_action('init', 'my_init_method');

//all data for image icons
function clpp_get_options($settings){
	return get_option($settings);
}

$clpp_widget = clpp_get_options('clpp_widget_settings');
if ($clpp_widget['cols'] >= 2){
	wp_enqueue_script($clpp_name . 'animation_widget', plugins_url( $clpp_name . '/scripts/animation_widget.js' , dirname(__FILE__) ), false, '1.0', 'all');
}

$clpp_urls = clpp_get_options('clpp_settings_urls');
$clpp_sizes = clpp_get_options('clpp_settings_sizes');
$clpp_radio = clpp_get_options('clpp_settings_radio');

//if admin page requ admin.php
if (is_admin() == true){
	require_once( dirname(__FILE__).'/admin.php' );
}

//category page class
require_once( dirname(__FILE__).'/page.php' );
//cat widget class
require_once( dirname(__FILE__).'/page_child.php' );
require_once( dirname(__FILE__).'/widget.php' );
//more css options
require_once( dirname(__FILE__).'/extended_styles.php' );

$style = new clppExtendedStyles();

//shortcode for page
add_shortcode('clpp-belicza', 'clpp_shortcode');
function clpp_shortcode(){
	global $style;
	$clpp_page = new clppCategoryPage();
	print $clpp_page->clpp_the_page();
	$style->clpp_extended_style_page();
}

//create action for widget
function clpp_register_widget() {
	register_widget( 'clpp_widget' );
}

add_action( 'widgets_init', 'clpp_register_widget' );
?>