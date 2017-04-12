<?php
/**
 * Meta Box Boilerplate
 *
 * @package     MetaBoxBoilerplate
 * @author      Bernhard Kau
 * @license     GPLv3
 *
 * @wordpress-plugin
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

// Activation and deactivation hooks.
register_activation_hook( __FILE__, array( Meta_Box_Boilerplate::get_instance(), 'activate' ) );
register_deactivation_hook( __FILE__, array( Meta_Box_Boilerplate::get_instance(), 'deactivate' ) );
// Plugin initialization.
add_action( 'plugins_loaded', array( Meta_Box_Boilerplate::get_instance(), 'plugin_setup' ) );

/**
 * Class Meta_Box_Boilerplate
 *
 * @package meta_box_boilerplate
 */
class Meta_Box_Boilerplate {

	/**
	 * Plugin instance.
	 *
	 * @see  get_instance()
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Access this plugin’s working instance.
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
	 * @wp-hook plugins_loaded
	 * @return  void
	 */
	public function plugin_setup() {
		// Register autoloader.
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
	 * The autoloader for this plugin.
	 *
	 * @param string $class The class name to autoload.
	 *
	 * @return void
	 */
	public function autoload( $class ) {
		// Trim leading namespace backslash.
		$class = ltrim( $class, '\\' );

		// Check if class is in same namespace, if not return.
		if ( strpos( $class, __NAMESPACE__ ) !== 0 ) {
			return;
		}

		// Remove namespace from class name.
		$class = str_replace( __NAMESPACE__ . '\\', '', $class );

		// Make the class name lowercase and replace underscores with dashes.
		$class = strtolower( str_replace( '_', '-', $class ) );

		// Build path to class file.
		$path = __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class-' . $class . '.php';

		// Include file if it exists.
		if ( file_exists( $path ) ) {
			include( $path );
		}
	}

	/**
	 * Callback function for the plugin activation.
	 */
	public static function activate() {
		flush_rewrite_rules();
	}


	/**
	 * Callback function for the plugin deactivation.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

} // End class.
