<?php
    /**
    * Plugin Name:  Wp Custom Meta Box
    * Plugin URI: http://agileinfoways.com
    * Description: This plugin is used to create Meta Box and display it to frontend. 
    * Version: 1.0.0
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    * License: GPL2
    */
?>
<?php
    //This is table names which are used in Plugin
    global $wpdb;
    global $table_metabox_fields;
    global $table_metabox_metabox;
    global $table_metabox_fieldtype;
    global $table_postmeta;

    $table_metabox_fields    = $wpdb->prefix . "metabox_fields";
    $table_metabox_metabox   = $wpdb->prefix . "metabox_metabox";
    $table_metabox_fieldtype = $wpdb->prefix . "metabox_fieldtype";
    $table_postmeta          = $wpdb->prefix . "postmeta";
    //This are the common files which are included for Global Use
    include('common.php');
    include('function.php');

    //This are Hooks which are called when plugin is loaded
    add_action('admin_menu', 'wcmb_metabox_menu');
    register_activation_hook( __FILE__, 'wcmb_metabox_install' );
    register_deactivation_hook( __FILE__, 'wcmb_metabox_uninstall' );
?>