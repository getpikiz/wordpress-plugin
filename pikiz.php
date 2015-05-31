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

class wp_pikiz {
  public function __construct()
  {
    add_action('media_buttons', array(&$this, 'add_pikiz_button'));
    // add_action('add_meta_boxes', array(&$this, 'add_pikiz_meta_box'));
    add_action('wp_enqueue_media', array(&$this, 'include_pikiz_js_file'));
  }

  public function add_pikiz_button()
  {
    ?>
    <a href="#" id="pikiz-insert-media" class="button">
      <img src="<?php echo PIKIZ_PLUGIN_URL. 'images/icon.png' ?>"/>Caption an image</a>
    <?php
  }

  public function include_pikiz_js_file()
  {
    wp_enqueue_script(
      'pikiz_js',
      PIKIZ_PLUGIN_URL . 'js/main.js',
      array('jquery'),
      '1.0',
      true
    );

    wp_enqueue_style(
      'pikiz_css',
      PIKIZ_PLUGIN_URL . 'css/main.css'
    );
  }

  public function add_pikiz_meta_box()
  {
    add_meta_box(
      'pikiz_meta_box',
      __( 'Post thumbnail', 'pikix-post-thumbnail' ),
      array(&$this, 'pikiz_meta_callback'),
      'post'
    );
  }

  public function pikiz_meta_callback()
  {
    echo 'Pikiz meta box';
  }
}

if (is_admin()) {
  $wpp = new wp_pikiz();
}
