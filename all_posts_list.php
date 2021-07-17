<?php
/**
  *  Plugin Name: All Posts List Widget
  *  Plugin URI:
  *  Description : Custom Widget for All Posts
  *  Version: 1.0.1.1
  *  Author: Kostas Dakanalis
  *  Author URI: 
  *  Text Domain: all-posts-list-widget
  *  Domain Path /languages
  * @package    All_Posts_List_Widget
  * @author     Kostas Dakanalis
  * @copyright  Copyright (c) Jul 17 2021
  * @license    https://www.gnu.org/licenses/gpl-3.0.en.html
*/

defined( 'ABSPATH' ) or die( );

class APLW_Widget{
    public function __construct() {
        // Set the constants needed by the plugin.
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		// Internationalize the text strings used. - TODO
		//add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		// Load the functions files.
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );

		// Register widget.
        add_action( 'widgets_init', array( &$this, 'register_widget' ) );
        
        // Load the admin style.
        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_style' ) );
        
        // Load the admin style for elementor
        add_action('elementor/editor/before_enqueue_scripts', function() {
            $this->admin_style();
        });       
    }

    public function constants() {

		// Set constant path to the plugin directory.
		define( 'APLW_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		// Set the constant path to the plugin directory URI.
		define( 'APLW_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// Set the constant path to the includes directory.
		define( 'APLW_INCLUDES', APLW_DIR . trailingslashit( 'includes' ) );

		// Set the constant path to the widget directory.
		define( 'APLW_CLASS', APLW_DIR . trailingslashit( 'widget' ) );

		// Set the constant path to the assets directory.
        define( 'APLW_ASSETS', APLW_URI . trailingslashit( 'assets' ) );
        
        // Set the constant text domain.
        define( 'APLW_TEXT_DOMAIN', 'all-posts-list-widget' );

    }
    
    public function i18n() {
        //Internationalization of the widget - TODO
		//load_plugin_textdomain( 'all-posts-list-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }
    
    public function includes() {
		//require_once( APLW_INCLUDES . 'resizer.php' ); - TODO
		//require_once( APLW_INCLUDES . 'functions.php' ); - TODO
		//require_once( APLW_INCLUDES . 'shortcode.php' ); - TODO
		//require_once( APLW_INCLUDES . 'helpers.php' ); - TODO
    }
    
    public function admin_style() {
        // Loads the widget style.
        wp_enqueue_style( 'aplw-admin-style', trailingslashit( APLW_ASSETS ).'css/admin.css', null, null );
    }
    
    public function register_widget() {
        wp_enqueue_style( 'aplw-style', trailingslashit( APLW_ASSETS ).'css/style.css', null, null );
		require_once( APLW_CLASS . 'widget.php' );
		register_widget( 'All_Posts_List_Widget' );
	}
}

new APLW_Widget;
