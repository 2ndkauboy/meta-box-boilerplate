<?php

/*
 * Plugin Name: Example plugin for Meta Box Boilerplate
 * Plugin URI: https://github.com/2ndkauboy/meta-box-boilerplate/examples
 * Description: This is just an example on how to use the Meta Box Boilerplate
 * Version: 0.1
 * Author: Bernhard Kau
 * Author URI: http://kau-boys.de
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */

add_action(
	'plugins_loaded',
	array( Example_Plugin::get_instance(), 'plugin_setup' )
);

class Example_Plugin {

	/**
	 * Plugin instance.
	 *
	 * @see   get_instance()
	 * @type  object
	 */
	protected static $instance = null;

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 */
	public static function get_instance() {

		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook  plugins_loaded
	 * @return   void
	 */
	public function plugin_setup() {
		// load the translation for this plugin
		$this->load_language( 'example-plugin' );

		// register autoloader
		spl_autoload_register( array( $this, 'autoload' ) );

		// init the meta boxes
		add_action( 'init', array( $this, 'init_meta_boxes' ) );
	}

	/**
	 * Constructor.
	 * Intentionally left empty and public.
	 *
	 * @see    plugin_setup()
	 */
	public function __construct() {
	}

	/**
	 * The autoloader for this plugin
	 *
	 * @param string $class The class name to autoload
	 *
	 * @return void
	 */
	public function autoload( $class ) {

		// check if class is in same namespace, if not return
		if ( strpos( $class, 'meta_box_boilerplate' ) !== 0 ) {
			return;
		}

		// remove namespace from class name
		$class = str_replace( 'meta_box_boilerplate' . '\\', '', $class );

		// make the class name lowercase and replace underscores with dashes
		$class = strtolower( str_replace( '_', '-', $class ) );

		// build path to class file
		$path = __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class-' . $class . '.php';

		// include file if it exists
		if ( file_exists( $path ) ) {
			include( $path );
		}
	}

	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 *
	 * @param   string $domain
	 *
	 * @return  void
	 */
	public function load_language( $domain ) {

		load_plugin_textdomain(
			$domain,
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Callback function to register the meta boxes.
	 * Init boxes in the order of their default appearance.
	 *
	 * @return  void
	 */
	public function init_meta_boxes() {

		// add date meta box
		new meta_box_boilerplate\Date_Meta_Box();
	}

} // end class