<?php
/**
 * A very simple implementation to provide a request validation.
 */

namespace meta_box_boilerplate;

class Request_Validator implements Request_Validator_Interface {

	/**
	 * The necessary capability.
	 *
	 * @param string
	 */
	private $cap;

	/**
	 * Constructor.
	 *
	 * @param string $cap The capability needed to do this request
	 */
	public function __construct( $cap = 'edit_posts' ) {

		$this->cap = $cap;
	}

	/**
	 * Verify request.
	 *
	 * @return bool
	 */
	public function is_valid() {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		// Check the user's permissions.
		if ( ! empty( $this->cap ) && ! current_user_can( $this->cap ) ) {
			return false;
		}

		// everything OK, the request can be saved
		return true;
	}
}