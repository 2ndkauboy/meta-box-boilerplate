<?php
/**
 * Meta_Box_Interface
 *
 * @package IMBJobOffer
 */

namespace imb;

/**
 * Interface Meta_Box_Interface
 *
 * @package IMBJobOffer
 */
interface Meta_Box_Interface {

	/**
	 * Register the meta box
	 */
	public function register();

	/**
	 * Render the meta box
	 *
	 * @param \WP_Post $post The post object.
	 */
	public function render( $post );

	/**
	 * Save the meta box data
	 *
	 * @param int $post_id The post ID.
	 */
	public function save( $post_id );

	/**
	 * Check, if the save should be performed (the nonce is OK, the user has the correct rights and it's not an AJAX call)
	 */
	public function check();
}
