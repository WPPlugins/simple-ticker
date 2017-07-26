<?php
/*
Plugin Name: Simple Ticker
Version: 1.03
Description: Displays the ticker.
Author: Katsushi Kawamori
Author URI: http://riverforest-wp.info/
Text Domain: simple-ticker
Domain Path: /languages
*/

/*  Copyright (c) 2016- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

	load_plugin_textdomain('simple-ticker');
//	load_plugin_textdomain('simple-ticker', false, basename( dirname( __FILE__ ) ) . '/languages' );

	define("SIMPLETICKER_PLUGIN_BASE_FILE", plugin_basename(__FILE__));
	define("SIMPLETICKER_PLUGIN_BASE_DIR", dirname(__FILE__));
	define("SIMPLETICKER_PLUGIN_URL", plugins_url($path='simple-ticker',$scheme=null));

	require_once( SIMPLETICKER_PLUGIN_BASE_DIR . '/req/SimpleTickerRegist.php' );
	$simpletickerregist = new SimpleTickerRegist();
	add_action('admin_init', array($simpletickerregist, 'register_settings'));
	unset($simpletickerregist);

	require_once( SIMPLETICKER_PLUGIN_BASE_DIR . '/req/SimpleTickerAdmin.php' );
	$simpletickeradmin = new SimpleTickerAdmin();
	add_action( 'admin_menu', array($simpletickeradmin, 'plugin_menu'));
	add_action( 'admin_enqueue_scripts', array($simpletickeradmin, 'load_custom_wp_admin_style') );
	add_filter( 'plugin_action_links', array($simpletickeradmin, 'settings_link'), 10, 2 );
	unset($simpletickeradmin);

	require_once( SIMPLETICKER_PLUGIN_BASE_DIR.'/req/SimpleTickerWidgetItem.php' );
	add_action('widgets_init', create_function('', 'return register_widget("SimpleTickerWidgetItem");'));

	include_once( SIMPLETICKER_PLUGIN_BASE_DIR . '/inc/SimpleTicker.php' );
	$simpleticker = new SimpleTicker();
	add_shortcode( 'simpleticker', array($simpleticker, 'simpleticker_func'));
	unset($simpleticker);

?>