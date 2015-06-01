<?php
/*
Plugin Name: Pikiz
Plugin URI:
Description: Easily create and share viral images from anywhere with anyone on web
Version:     0.1
Author:      TEKXL
Author URI:  http://tekxl.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset
*/

define( 'PIKIZ_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PIKIZ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( PIKIZ_PLUGIN_DIR . 'includes/pikiz-media.php' );
require_once( PIKIZ_PLUGIN_DIR . 'includes/pikiz-options.php' );
require_once( PIKIZ_PLUGIN_DIR . 'includes/pikiz-frontend.php' );

register_activation_hook( __FILE__, array( 'Akismet', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Akismet', 'plugin_deactivation' ) );

if (is_admin()) {
  wp_pikiz_media::init();
  wp_pikiz_options::init();
} else {
  wp_pikiz_frontend::init();
}
