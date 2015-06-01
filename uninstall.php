<?php

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  exit;
}

if ( get_option( 'pikiz_option_name' ) != false )
  delete_option('pikiz_option_name');
