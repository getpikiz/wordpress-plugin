<?php
/*
Plugin Name: Pikiz
Plugin URI: http://getpikiz.com
Description: Easily create and share viral images from anywhere with anyone on web
Version:     0.1
Author:      Pikiz
Author URI:  http://getpikiz.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages/
Text Domain: pikiz
*/

define( 'PIKIZ_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PIKIZ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PIKIZ_URL', 'https://app.getpikiz.com' );

require_once( PIKIZ_PLUGIN_DIR . 'includes/pikiz-media.php' );
require_once( PIKIZ_PLUGIN_DIR . 'includes/pikiz-options.php' );
require_once( PIKIZ_PLUGIN_DIR . 'includes/pikiz-frontend.php' );

function load_pikiz_textdomain() {
  load_plugin_textdomain( 'pikiz', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'load_pikiz_textdomain' );

if (is_admin()) {
  wp_pikiz_media::init();
  wp_pikiz_options::init();
} else {
  wp_pikiz_frontend::init();
}
