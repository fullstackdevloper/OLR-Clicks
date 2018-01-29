<?php
/*

Plugin Name: OLR Clicks

Plugin URI: https://glocify.org/

Description: This plugin will provide the functionalty to track the clicks on the out going links in the website. This will provide admin section to view tracking and you can import tracking data into excel files as well. There will sorting and searching for track data as well in backend .

Version: 0.0.1

Author: Glocify

Author URI: https://glocify.org/

License: GPLv2 or later

Text Domain: glocify analytics

*/



/*

OLR Clicks is free software; you can redistribute it and/or

modify it under the terms of the GNU General Public License

as published by the Free Software Foundation; either version 2

of the License, or (at your option) any later version.



OLR Clicks is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.

*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('includes/simple_html_dom.php');

function ga_table_install(){

	global $wpdb;

	$ga_db_version = '1.0';

	$table_name = $wpdb->prefix . "ga_analytics";

	$charset_collate = $wpdb->get_charset_collate();



	$sql = "CREATE TABLE IF NOT EXISTS $table_name (

	  id mediumint(9) NOT NULL AUTO_INCREMENT,

	  page varchar(200) NOT NULL,

	  time_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,

	  outgoing_link_name text NOT NULL,

	  outgoing_link varchar(200) DEFAULT '' NOT NULL,

	  ip_address varchar(200) DEFAULT '' NOT NULL,

	  PRIMARY KEY  (id)

	) $charset_collate;";



	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	update_option('ga_db_version', $ga_db_version);

}



function ga_table_insert_data(){

	global $wpdb;

	$table_name = $wpdb->prefix . "ga_analytics";

	$ip = $_SERVER['REMOTE_ADDR'];

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

	 $ip = $_SERVER['HTTP_CLIENT_IP'];

	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

	 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

	}

	$setupFieldsfordata = array(

									'page' => 'http://localhost/wordpress/2017/10/17/hello-world/',

									'time_created' => current_time('mysql'),

									'outgoing_link' => 'http://google.com',

									'outgoing_link_name' => 'Google',

									'ip_address' => $ip

								);	

	$wpdb->insert($table_name,$setupFieldsfordata);

}



// on plugin activation this will trigger create table and insert sample data in table

register_activation_hook( __FILE__, 'ga_table_install' );

//register_activation_hook( __FILE__, 'ga_table_insert_data' );



add_action('admin_menu', 'my_menu_pages');



function my_menu_pages(){

    add_menu_page('OLR Clicks', 'OLR Clicks', 'manage_options', 'my-menu', 'ga_plugin_options' );

    add_submenu_page('my-menu', 'Outgoing links click', 'Outgoing links click', 'manage_options', 'my-menu' );

	add_submenu_page('my-menu', 'Pages links click', 'Pages links click', 'manage_options', 'page-links-click', 'ga_outgoing_click' );

	add_submenu_page(null, 'Pages Outgoing links click', 'Pages Outgoing links click', 'manage_options', 'page-outgoing-links-click', 'ga_pages_outgoing_click' );

  }



function ga_pages_outgoing_click(){

	if ( !current_user_can( 'manage_options' ) )  {

		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

	}

	require_once('includes/pageOutgoingLinksClicks.php');

}

function ga_outgoing_click(){

	if ( !current_user_can( 'manage_options' ) )  {

		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

	}

	require_once('includes/pagesLinksClicks.php');

}



function ga_plugin_options() {

	if ( !current_user_can( 'manage_options' ) )  {

		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

	}

	require_once('includes/outgoingLinksClicks.php');

}





add_action('wp_head', 'myplugin_ajaxurl');



function myplugin_ajaxurl() {

    echo '<script type="text/javascript">

           var ajaxurl = "' . admin_url('admin-ajax.php') . '";

         </script>';

}



function ga_load_scripts($hook) {

    // create my own version codes

    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/glocifyanalytics.js' ));

    wp_enqueue_script( 'glocifyanalytic_js', plugins_url( 'js/glocifyanalytics.js', __FILE__ ), array(), $my_js_ver );

}

add_action('wp_footer', 'ga_load_scripts');



function load_custom_wp_admin_style($hook) {

	wp_enqueue_style( 'jquery_ui_css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );

	wp_enqueue_style( 'custom_wp_admin_css', plugins_url('css/dataTables.css', __FILE__) );

	wp_enqueue_style( 'custom_wp_admin_css_style', plugins_url('css/olr_style.css', __FILE__) );

	wp_enqueue_style( 'custom_datetime_css_style', plugins_url('css/datetimepicker.css', __FILE__) );

	wp_enqueue_script( 'my_custom_script', plugins_url('js/dataTables.min.js', __FILE__) );

	wp_enqueue_script( 'jquery_ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js' );

	wp_enqueue_script( 'my_datetimepicker_script', plugins_url('js/datetimepicker.js', __FILE__) );

}



add_action( 'in_admin_footer', 'load_custom_wp_admin_style' );



function setDatatablescriptCode($hook){

   // create my own version codes

   $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/glocifyanalytics_admin.js' ));

   wp_enqueue_script( 'glocifyanalytic_admin_js', plugins_url( 'js/glocifyanalytics_admin.js', __FILE__ ), array(), $my_js_ver );

}

add_action( 'in_admin_footer', 'setDatatablescriptCode' );





add_action( 'wp_ajax_save_clicks_data', 'save_clicks_data' );

add_action( 'wp_ajax_nopriv_save_clicks_data', 'save_clicks_data' );



function save_clicks_data(){	

	global $wpdb;

	$table_name = $wpdb->prefix . "ga_analytics";

	$ip = $_SERVER['REMOTE_ADDR'];

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

	 $ip = $_SERVER['HTTP_CLIENT_IP'];

	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

	 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

	}

	$setupFieldsfordata = array(

									'page' => $_REQUEST['currentPage'],

									'time_created' => current_time('mysql'),

									'outgoing_link' => $_REQUEST['linkURL'],

									'outgoing_link_name' => $_REQUEST['linkName'],

									'ip_address' => $ip

								);		

		;	

	if($wpdb->insert($table_name,$setupFieldsfordata)){
		echo 'true';
	}else{
		echo 'false';
	} 

	wp_die();

}?>