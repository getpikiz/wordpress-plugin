<?php

class wp_pikiz_media {

  public static function init()
  {
    add_action('media_buttons', array(__class__, 'add_pikiz_button'));
    // add_action('add_meta_boxes', array(__class__, 'add_pikiz_meta_box'));
    add_action('wp_enqueue_media', array(__class__, 'include_pikiz_js_file'));
  }

  public static function add_pikiz_button()
  {
    ?>
    <a href="#" id="pikiz-insert-media" class="button">
      <img src="<?php echo PIKIZ_PLUGIN_URL. 'images/icon.png' ?>"/><?php echo __( 'Caption an image', 'pikiz' ); ?></a>
    <?php
  }

  public static function include_pikiz_js_file()
  {
    wp_enqueue_script(
      'pikiz_js',
      PIKIZ_PLUGIN_URL . 'js/pikiz-media.js',
      array('jquery'),
      '1.0',
      true
    );

    wp_enqueue_style(
      'pikiz_css',
      PIKIZ_PLUGIN_URL . 'css/main.css'
    );
  }

  public static function add_pikiz_meta_box()
  {
    add_meta_box(
      'pikiz_meta_box',
      __( 'Post thumbnail', 'pikix-post-thumbnail' ),
      array(__class__, 'pikiz_meta_callback'),
      'post'
    );
  }

  public static function pikiz_meta_callback()
  {
    echo 'Pikiz meta box';
  }
}
