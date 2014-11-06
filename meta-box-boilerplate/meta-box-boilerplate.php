<?php

/*
 * Plugin Name: Meta Box Boilerplate
 * Plugin URI: https://github.com/2ndkauboy/meta-box-boilerplate/meta-box-boilerplate
 * Description: A boilerplate to easily define and add new meta boxes
 * Version: 0.1
 * Author: Bernhard Kau
 * Author URI: http://kau-boys.de
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */

namespace meta_box_boilerplate;

add_action(
	'plugins_loaded',
	array( Meta_Box_Boilerplate::get_instance(), 'plugin_setup' )
);

class Meta_Box_Boilerplate {

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
		// register autoloader
		spl_autoload_register( array( $this, 'autoload' ) );
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
		// trim leading namespace backslash
		$class = ltrim( $class, '\\' );

		// check if class is in same namespace, if not return
		if ( strpos( $class, __NAMESPACE__ ) !== 0 ) {
			return;
		}

		// remove namespace from class name
		$class = str_replace( __NAMESPACE__ . '\\', '', $class );

		// make the class name lowercase and replace underscores with dashes
		$class = strtolower( str_replace( '_', '-', $class ) );

		// build path to class file
		$path = __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class-' . $class . '.php';

		// include file if it exists
		if ( file_exists( $path ) ) {
			include( $path );
		}
	}

} // end class