<?php
/**
 * Plugin Name: Breaking News
 * Description: Breaking News Plugin
 * Version:     1.0
 * Text Domain: breakingnews
*/

defined( 'ABSPATH' ) or die ( 'Not Allowed');

/**
 * Plugin constants
*/
define( 'BREAKINGNEWS_URL', plugin_dir_url(__FILE__) );
define( 'BREAKINGNEWS_PATH', plugin_dir_path(__FILE__) );

/**
 * Load main class
 */
if( file_exists( BREAKINGNEWS_PATH. 'inc/BreakingNewsMain.php') ) {
    require_once BREAKINGNEWS_PATH. 'inc/BreakingNewsMain.php';
}