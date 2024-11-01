<?php
/*
Plugin Name: Ultimate Table of Contents
Plugin URI: http://toc.neverstopmedia.com/
Description: Get the heading from single post.
Version: 1.0.1
Author: NSM
Author URI: http://neverstopmedia.com/
Text Domain: ultimate_toc
Domain Path: /lang
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once( plugin_basename( 'class-toc.php' ) );

function ultimate_toc_textdomain() {
    load_plugin_textdomain( 'ultimate_toc', false, trailingslashit( ULTIMATE_TOC_PATH ) . '/languages/' );
}
add_action( 'plugins_loaded', 'ultimate_toc_textdomain' );