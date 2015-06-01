<?php

class wp_pikiz_options {

  public static $options = [];

  public static function init()
  {
    add_action( 'admin_menu', array( __class__, 'add_pikiz_option_page' ) );
    add_action( 'admin_init', array( __class__, 'page_init' ) );
    add_action('admin_enqueue_scripts', array(__class__, 'add_options_scripts'));
  }

  public static function page_init()
  {
    register_setting(
      'pikiz_option_group', // Option group
      'pikiz_option_name', // Option name
      array( __class__ , 'sanitize' ) // Sanitize
    );

    add_settings_section(
     'pikiz_section_id', // ID
     '', // Title
     '', // Callback
     'pikiz-setting-admin' // Page
    );

   add_settings_field(
     'api_key', // ID
     __('Api key', 'pikiz'), // Title
     array(__class__, 'api_key_callback'), // Callback
     'pikiz-setting-admin', // Page
     'pikiz_section_id' // Section
   );

   add_settings_field(
     'allow_frontend',
     __('Allow Pikiz on frontend', 'pikiz'),
     array( __class__, 'allow_frontend_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );

   add_settings_field(
     'style',
     __('Button style', 'pikiz'),
     array( __class__, 'style_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );

   add_settings_field(
     'size',
     __('Button size', 'pikiz'),
     array( __class__, 'size_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );

   add_settings_field(
     'language',
     __('Button Language', 'pikiz'),
     array( __class__, 'language_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );

    add_settings_field(
      'auto',
      __('Auto', 'pikiz'),
      array( __class__, 'auto_callback' ),
      'pikiz-setting-admin',
      'pikiz_section_id'
    );

   add_settings_field(
     'type',
     __('Content type', 'pikiz'),
     array( __class__, 'type_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );

   add_settings_field(
     'position',
     __('Button position', 'pikiz'),
     array( __class__, 'position_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );

   add_settings_field(
     'hover',
     __('Display image button on hover', 'pikiz'),
     array( __class__, 'hover_callback' ),
     'pikiz-setting-admin',
     'pikiz_section_id'
   );
  }

  public static function add_pikiz_option_page()
  {
    // This page will be under "Settings"
    add_options_page(
      __('Pikiz settings', 'pikiz'),
      __('Pikiz settings', 'pikiz'),
      'manage_options',
      'pikiz-setting-admin',
      array( __class__, 'create_admin_page' )
    );
  }

  public static function create_admin_page()
  {
    // Set class property
    self::$options = get_option( 'pikiz_option_name' );
    // die(var_dump(self::$options));
    ?>
    <div class="wrap">
      <h2>Pikiz Settings</h2>
      <form method="post" action="options.php">
        <table id="pikiz_option_table" data-form-table>
          <tbody>
            <tr>
              <td>
                <?php
                  // This prints out all hidden setting fields
                  settings_fields( 'pikiz_option_group' );
                  do_settings_sections( 'pikiz-setting-admin' );
                  submit_button();
                ?>
              </td>
              <td>
                <h3 class="h4"><b><?php echo __('Buttons overview', 'pikiz') ?></b></h3>
                <div class="embed-overview">
                  <div data-caption-img-btn>
                    <h4 class="h5"><?php echo __('Caption image button', 'pikiz') ?></h4>
                    <iframe data-pikiz-img-btn-overview></iframe>
                  </div>

                  <div data-quote-text-btn style="display: block;">
                    <h4 class="h5"><?php echo __('Quote text button', 'pikiz') ?></h4>
                    <iframe data-pikiz-text-btn-overview></iframe>
                  </div>
                </div>
                <div>
                  <div data-auto-fieldset>
                    <h3 class="h4"><?php echo __('Embed code', 'pikiz') ?></h3>
                    <table>
                      <tbody>
                        <tr>
                          <td><label for="url"><?php echo __('Url of the image :', 'pikiz') ?></label></td>
                          <td><input type="url" id="url"  data-button-url class="disable_allow"></td>
                        </tr>
                        <tr>
                          <td><label for="target"><?php echo __('Target (use CSS selector to target the image) :', 'pikiz') ?></label></td>
                          <td><input type="text" id="target" data-button-target class="disable_allow"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <code data-button-code></code>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <?php
  }

  public static function api_key_callback()
  {
    ?>
      <input type="text" id="api_key" name="pikiz_option_name[api_key]" value="<?php
      echo isset( self::$options['api_key'] ) ? esc_attr( self::$options['api_key']) : ''
      ?>"/>
      <p class="description" id="api_key-description"><?php echo __('Enter your', 'pikiz') ?>
        <a href="https://app.getpikiz.com" target="_blank"><?php echo __('API Key', 'pikiz') ?></a>
      </p>
    <?php
  }

  public static function allow_frontend_callback()
  {
    ?>
    <input type="checkbox" id="allow_frontend" name="pikiz_option_name[allow_frontend]" data-allow-fontend
    <?php if(isset( self::$options['allow_frontend'] ) && self::$options['allow_frontend'] ) { ?>
    checked="checked"
    <?php } ?>
    />
    <?php
  }

  public static function style_callback()
  {
    ?>
    <fieldset class="disable_allow"><legend class="screen-reader-text"><span><?php echo __('Button style', 'pikiz') ?></span></legend>
      <label title="Orange"><input type="radio" name="pikiz_option_name[style]" value="orange"
        <?php if(isset( self::$options['style'] ) && self::$options['style'] === 'orange') { ?>
        checked="checked"
        <?php } ?>
        data-button-orange /> <?php echo __('Orange', 'pikiz') ?>
      </label><br>
      <label title="White"><input type="radio" name="pikiz_option_name[style]" value="white"
        <?php if(isset( self::$options['style'] ) && self::$options['style'] === 'white' ) { ?>
        checked="checked"
        <?php } ?>
        data-button-white /> <?php echo __('White', 'pikiz') ?>
      </label><br>
    </fieldset>
    <?php
  }

  public static function size_callback()
  {
    ?>
    <fieldset class="disable_allow"><legend class="screen-reader-text"><span>Button size</span></legend>
      <label title="Orange"><input type="radio" name="pikiz_option_name[size]" value="default"
        <?php if( !isset( self::$options['size']) ||
         (isset( self::$options['size'] ) && self::$options['size'] === 'default') ) { ?>
        checked="checked"
        <?php } ?>
        data-button-default /> <?php echo __('Default', 'pikiz') ?>
      </label><br>
      <label title="White"><input type="radio" name="pikiz_option_name[size]" value="large"
        <?php if(isset( self::$options['size'] ) && self::$options['size'] === 'large' ) { ?>
        checked="checked"
        <?php } ?>
        data-button-large /> <?php echo __('Large', 'pikiz') ?>
      </label><br>
    </fieldset>
    <?php
  }

  public static function language_callback()
  {
    ?>
    <select name="pikiz_option_name[language]" id="allow_frontend" data-button-language class="disable_allow">
      <option value="en"
    <?php if(isset( self::$options['language'] ) && self::$options['language'] === 'en' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('English', 'pikiz') ?></option>
      <option value="it"
    <?php if(isset( self::$options['language'] ) && self::$options['language'] === 'it' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('Italian', 'pikiz') ?></option>
    </select>
    <?php
  }

  public static function auto_callback()
  {
    ?>
    <input type="checkbox" name="pikiz_option_name[auto]" class="disable_allow"
    <?php if(!isset(self::$options['auto']) ||
    (isset(self::$options['auto']) && self::$options['auto'])) { ?>
    checked="checked"
    <?php } ?>
    data-button-auto />
    <p data-auto-info class="description">
      <?php echo __('Uncheck Auto if you want to add Pikiz button only on specific images of your website.', 'pikiz') ?>
    </p>
    <?php
  }

  public static function type_callback()
  {
    ?>
    <select name="pikiz_option_name[type]" id="type" data-pikiz-type class="disable_allow disable_auto">
      <option value="both"
    <?php if(isset( self::$options['type'] ) && self::$options['type'] === 'both' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('Image and Text', 'pikiz') ?></option>
      <option value="image"
    <?php if(isset( self::$options['type'] ) && self::$options['type'] === 'image' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('Image', 'pikiz') ?></option>
      <option value="text"
    <?php if(isset( self::$options['type'] ) && self::$options['type'] === 'text' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('Text', 'pikiz') ?></option>
    </select>
    <?php
  }

  public static function position_callback()
  {
    ?>
    <select name="pikiz_option_name[position]" id="position" class="disable_content_type_text disable_allow disable_auto">
      <option value="topLeft"
    <?php if(isset( self::$options['position'] ) && self::$options['position'] === 'topLeft' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('top-left corner', 'pikiz') ?></option>
      <option value="topRight"
    <?php if(isset( self::$options['position'] ) && self::$options['position'] === 'topRight' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('top-right corner', 'pikiz') ?></option>
      <option value="bottomRight"
    <?php if(isset( self::$options['position'] ) && self::$options['position'] === 'bottomRight' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('bottom-right corner', 'pikiz') ?></option>
      <option value="bottomLeft"
    <?php if(isset( self::$options['position'] ) && self::$options['position'] === 'bottomLeft' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('bottom-left corner', 'pikiz') ?></option>
      <option value="center"
    <?php if(isset( self::$options['position'] ) && self::$options['position'] === 'center' ) { ?>
      selected="selected"
    <?php } ?>
      ><?php echo __('center', 'pikiz') ?></option>
    </select>
    <?php
  }

  public static function hover_callback()
  {
    ?>
    <input type="checkbox" id="hover" name="pikiz_option_name[hover]" class="disable_content_type_text disable_allow disable_auto"
    <?php if(isset( self::$options['hover'] ) && self::$options['hover'] ) { ?>
    checked="checked"
    <?php } ?>
    data-button-hover />
    <?php
  }

  public static function sanitize( $input )
  {
    $new_input = array();
    $fields = array('api_key', 'allow_frontend', 'style', 'size', 'language', 'type', 'position', 'hover');
    $booleanFields = array('allow_frontend', 'auto', 'hover');

    foreach($fields as $field) {
      if(isset($input[$field])) {
        $new_input[$field] = $input[$field];

        if (in_array($field, $booleanFields) && $new_input[$field]) {
          $new_input[$field] = true;
        }
      }
    }

    return $new_input;
  }

  public static function add_options_scripts()
  {
    wp_register_script(
    'pikiz_options_js',
    PIKIZ_PLUGIN_URL . 'js/pikiz-options.js',
    array('jquery'),
    '1.0',
    true);

    wp_enqueue_script('pikiz_options_js');
    wp_localize_script( 'pikiz_options_js', 'WPPikiz', array(
      'strings' => array(
        'uncheck_auto' => __('Uncheck Auto if you want to add Pikiz button only on specific images of your website.' , 'pikiz'),
        'check_auto' => __('Check Auto if you want Pikiz buttons to be added automatically on all images and text of your website' , 'pikiz')
      )
    ));
    wp_enqueue_style(
      'pikiz_options_css',
      PIKIZ_PLUGIN_URL . 'css/main.css'
    );
  }
}
