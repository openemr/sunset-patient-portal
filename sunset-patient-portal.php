<?php
/*
Plugin Name: Sunset Patient Portal
Plugin URI: http://www.sunsetsystems.com/
Description: Patient interface to a medical clinic EHR system.
Version: 0.1
Author: Rod Roark
Author URI: http://www.sunsetsystems.com/
License: GPL2+
*/

/*
Copyright 2014 Rod Roark (email: rod@sunsetsystems.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!class_exists('Sunset_Patient_Portal')) {
  class Sunset_Patient_Portal {

    const CLASS_NAME = 'Sunset_Patient_Portal';

    // Post type is max. 20 characters, may not contain capital letters or spaces.
    const POST_TYPE = 'sunset_portal';

    private static $_meta = array (
      'meta_a' => 'Meta A',
      'meta_b' => 'Meta B',
      'meta_c' => 'Meta C',
    );

    public static function initialize() {

      // Initialize Settings.
      //
      // add_action() hooks a function to a specific action.
      //
      // From PHP documentation of callable types: "A method of an instantiated object is passed
      // as an array containing an object at index 0 and the method name at index 1."
      // "Static class methods can also be passed without instantiating an object of that class by
      // passing the class name instead of an object at index 0. As of PHP 5.2.3, it is also
      // possible to pass 'ClassName::methodName'."
      //
      add_action('admin_init', array(self::CLASS_NAME, 'settings_admin_init'));
      add_action('admin_menu', array(self::CLASS_NAME, 'settings_add_menu'));

      // Register actions for post types.
      add_action('init'      , array(self::CLASS_NAME, 'post_type_init'));
      add_action('admin_init', array(self::CLASS_NAME, 'post_type_admin_init'));

      // From http://codex.wordpress.org/Function_Reference/register_activation_hook:
      // The register_activation_hook function registers a plugin function to be run when the plugin
      // is activated.
      //
      // From PHP documentation of callable types: "Static class methods can also be passed without
      // instantiating an object of that class by passing the class name instead of an object at
      // index 0. As of PHP 5.2.3, it is also possible to pass 'ClassName::methodName'."
      //
      register_activation_hook  (__FILE__, array(self::CLASS_NAME, 'activate'  ));
      register_deactivation_hook(__FILE__, array(self::CLASS_NAME, 'deactivate'));

      // Add a link to the settings page onto the plugin page
      //
      // From http://codex.wordpress.org/Plugin_API/Filter_Reference:
      // Administrative Filters
      //   plugin_action_links_(plugin file name) 
      //     applied to the list of links to display on the plugins page
      //     (beside the activate/deactivate links).
      //
      $plugin = plugin_basename(__FILE__); 
      add_filter("plugin_action_links_$plugin", array(self::CLASS_NAME, 'plugin_settings_link'));

    } // END function initialize()

    /**
     * Activate the plugin
     */
    public static function activate() {
      // Do nothing
    }

    /**
     * Deactivate the plugin
     */		
    public static function deactivate() {
      // Do nothing
    }

    //////////////////////////////////////////////////////////////////
    //  Settings Support
    //////////////////////////////////////////////////////////////////

    public static function plugin_settings_link($links) { 
      $settings_link = '<a href="options-general.php?page=sunsetpatientportal">Settings</a>'; 
      array_unshift($links, $settings_link); 
      return $links; 
    }

    /**
     * hook into WP's admin_init action hook
     */
    public static function settings_admin_init() {

      // Register your plugin's settings.
      //
      // This group name also appears in templates/settings.php and must be unique across WP.
      // The 2nd argument is the name of an option to sanitize and save. It is stored in the
      // wp_options table and the 64-character name must be unique across WP.
      // For more about settings see: http://codex.wordpress.org/Settings_API
      // For more about options see : http://codex.wordpress.org/Options_API
      //
      register_setting('sunsetpatientportal-group', 'sunsetpatientportal_setting_a');
      register_setting('sunsetpatientportal-group', 'sunsetpatientportal_setting_b');

      // Add your settings section.
      //
      // Settings Sections are the groups of settings you see on WordPress settings pages with a
      // shared heading. In your plugin you can add new sections to existing settings pages rather
      // than creating a whole new page. This makes your plugin simpler to maintain and creates
      // less new pages for users to learn. You just tell them to change your setting on the
      // relevant existing page. 
      //
      add_settings_section(
        'sunsetpatientportal-section',                           // String for use in the 'id' attribute of tags.
        'Sunset Patient Portal Settings',                        // Title of the section.
        array(self::CLASS_NAME,
          'settings_section_sunsetpatientportal'),               // Function that fills the section with the desired content.
        'sunsetpatientportal'                                    // Name of menu page on which to display this section; will
      );                                                         // be referenced by do_settings_section() in the settings page.

      // Register the settings fields to a settings page and section.
      // See: http://codex.wordpress.org/Function_Reference/add_settings_field
      //
      add_settings_field(
        'sunsetpatientportal-setting_a',                         // String for use in the 'id' attribute of tags.
        'Setting A',                                             // Title of the field.
        array(self::CLASS_NAME,
          'settings_field_input_text'),                          // Function that fills the field with the desired inputs.
        'sunsetpatientportal',                                   // The menu page on which to display this field.
        'sunsetpatientportal-section',                           // The section of the settings page in which to show the box.
        array('field' => 'sunsetpatientportal_setting_a')        // Additional arguments passed to the callback function.
      );
      add_settings_field(
        'sunsetpatientportal-setting_b', 
        'Setting B', 
        array(self::CLASS_NAME,
          'settings_field_input_text'), 
        'sunsetpatientportal', 
        'sunsetpatientportal-section',
        array('field' => 'sunsetpatientportal_setting_b')
      );

      // Possibly do additional admin_init tasks

    } // END public static function settings_admin_init

    // This function provides content for the settings section.
    //
    public static function settings_section_sunsetpatientportal() {
      // Think of this as help text for the section.
      echo 'These settings do things for the Sunset Patient Portal.';
    }

    /**
     * This function provides text inputs for settings fields
     */
    public static function settings_field_input_text($args) {
      // Get the field name from the $args array
      $field = $args['field'];
      // Get the value of this setting
      $value = get_option($field);
      // echo a proper input type="text"
      echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
    }

    /**
     * Add a sub menu page to the Settings menu.
     */
    public static function settings_add_menu() {
      // Add a page to manage this plugin's settings.
      // I guess this declares the page AND its menu item.
      add_options_page(
        'Sunset Patient Portal Settings',          // Text to display in the title tags of the page when the menu is selected.
        'Sunset Patient Portal',                   // The text to be used for the menu.
        'manage_options',                          // The capability required for this menu to be displayed to the user.
        'sunsetpatientportal',                     // The slug name to refer to this menu by (should be unique for this menu).
        array(self::CLASS_NAME,
          'plugin_settings_page')                  // The function to be called to output the content for this page.
      );
    }

    /**
     * Menu Callback declared via add_menu() to get plugin settings page content.
     */		
    public static function plugin_settings_page() {
      if(!current_user_can('manage_options')) {
        // Looks like this is a sanity check for security purposes.
        // The __() function provides translation.
        // Presumably wp_die() is like die() but works better in WordPress.
        wp_die(__('You do not have sufficient permissions to access this page.'));
      }
      // Render the settings template.  It's a <div> that contains a <form> and
      // invokes some WP functions to generate its variable content.
      // It does not define PHP functions; include_once does not apply.
      //
      include(dirname(__FILE__) . '/templates/settings.php');
    }

    //////////////////////////////////////////////////////////////////
    //  Post Type Support
    //////////////////////////////////////////////////////////////////

    /**
     * hook into WP's init action hook
     */
    public static function post_type_init() {
      // Initialize Post Type
      //
      // http://codex.wordpress.org/Function_Reference/register_post_type
      // Create or modify a post type. register_post_type should only be invoked through the
      // 'init' action.
      //
      register_post_type(self::POST_TYPE,
        array(
          'labels' => array(
            // General name for the post type, usually plural.
            'name' => __(sprintf('%ss', ucwords(str_replace("_", " ", self::POST_TYPE)))),
            // Name for one object of this post type.
            'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))
          ),
          // Whether type is to be used publicly either via the admin interface or by front-end users.
          'public' => true,
          // Enables post type archives. Will use $post_type as archive slug by default.
          'has_archive' => true,
          // A short descriptive summary of what the post type is.
          'description' => __("This is a sample post type meant only to illustrate a preferred structure of plugin development"),
          // An alias for calling add_post_type_support() directly. Default: title and editor.
          'supports' => array(
            'title', 'editor', 'excerpt', 
          ),
        )
      );
      add_action('save_post', array(self::CLASS_NAME, 'save_post'));
    }

    /**
     * Save the metaboxes for this custom post type
     */
    public static function save_post($post_id) {
      // verify if this is an auto save routine. 
      // If it is our form has not been submitted, so we dont want to do anything
      if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
      }
      if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id)) {
        foreach(self::$_meta as $field_name => $dummy) {
          // Update the post's meta field
          update_post_meta($post_id, $field_name, $_POST[$field_name]);
        }
      }
      else {
        return;
      }
    }

    /**
     * hook into WP's admin_init action hook
     */
    public static function post_type_admin_init() {
      // Add metaboxes
      add_action('add_meta_boxes', array(self::CLASS_NAME, 'add_meta_boxes'));
    }

    /**
     * hook into WP's add_meta_boxes action hook
     */
    public static function add_meta_boxes() {
      // Add this metabox to every selected post
      add_meta_box( 
        sprintf('wp_plugin_template_%s_section', self::POST_TYPE),
        sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
        array(self::CLASS_NAME, 'add_inner_meta_boxes'),
        self::POST_TYPE
      );
    }

    /**
     * called off of the add meta box
     */
    public static function add_inner_meta_boxes($post) {
      /***************************************************************
      // Render the job order metabox
      include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));
      ***************************************************************/
      require_once("sunset-patient-portal-html.php");
      echo Sunset_PP_HTML::generate_metabox($post->ID, self::$_meta);
    }

  } // END class Sunset_Patient_Portal
} // END if (!class_exists('Sunset_Patient_Portal'))

Sunset_Patient_Portal::initialize();

