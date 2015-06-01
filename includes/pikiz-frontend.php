<?php

class wp_pikiz_frontend {

  public static $options = [];
  public static function init()
  {
    self::$options = get_option( 'pikiz_option_name' );

    if (isset(self::$options['allow_frontend']) && self::$options['allow_frontend']) {
      add_action('wp_head', array(__class__, 'include_pikiz_frontend_js_file'));
    }
  }

  public static function include_pikiz_frontend_js_file()
  {
    wp_register_script(
    'pikiz_frontend_js',
    PIKIZ_PLUGIN_URL . 'js/pikiz-frontend.js',
    array('jquery'),
    '1.0',
    true);

    wp_enqueue_script('pikiz_frontend_js');
    wp_localize_script( 'pikiz_frontend_js', 'WPPikiz', array(
      'options' => self::$options
    ));
  }
}
