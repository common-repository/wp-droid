<?php 

add_action('admin_menu', 'wpdroid_admin_menu');

function wpdroid_admin_menu() {

 
   	if(function_exists('add_menu_page')) { //Adding Main Menu
      // page title (First Submenu title), 
      // menu title (Visible at first sight), 
      // capability, 
      // menu slug, 
      // callback function, 
      // icon url, 
      // position
      add_menu_page(wpdroid_PLUGIN_NAME, wpdroid_PLUGIN_NAME, 'manage_options', wpdroid_PLUGIN_SETTINGS_SLUG, 'wpdroid_plugin_customizer_settings_screen', 'dashicons-art', 82.4);     
    }

    if(function_exists('add_submenu_page')) { //Adding Menus under Main Menu 
      //Parent Menu Slug,
      //Page title,
      //menu title,
      //capability,
      //menu_slug,
      //callback function

      add_submenu_page( wpdroid_PLUGIN_SETTINGS_SLUG, 'API Keys - '.wpdroid_PLUGIN_NAME, "API Keys", 'manage_options', wpdroid_PLUGIN_SETTINGS_SLUG."-api-keys", 'wpdroid_plugin_api_settings_screen' );

        add_submenu_page( wpdroid_PLUGIN_SETTINGS_SLUG, 'Customizer - '.wpdroid_PLUGIN_NAME, "Customizer", 'manage_options', wpdroid_PLUGIN_SETTINGS_SLUG."-api-customizer", 'wpdroid_plugin_customizer_settings_screen' );

        add_submenu_page( wpdroid_PLUGIN_SETTINGS_SLUG, 'App CSS - '.wpdroid_PLUGIN_NAME, "App CSS", 'manage_options', wpdroid_PLUGIN_SETTINGS_SLUG."-app-css", 'wpdroid_plugin_app_css_screen' );

         add_submenu_page( wpdroid_PLUGIN_SETTINGS_SLUG, 'Push Notifications - '.wpdroid_PLUGIN_NAME, "Push Notifications", 'manage_options', wpdroid_PLUGIN_SETTINGS_SLUG."-push-notifications", 'wpdroid_plugin_push_notifications_settings_screen' );

      remove_submenu_page(wpdroid_PLUGIN_SETTINGS_SLUG,wpdroid_PLUGIN_SETTINGS_SLUG);


    }

  }

?>