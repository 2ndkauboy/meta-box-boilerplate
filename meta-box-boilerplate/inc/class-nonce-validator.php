<?php
/**
 * Implementation to validate a nonce
 */

namespace meta_box_boilerplate;

class Nonce_Validator implements Nonce_Validator_Interface {

	/**
	 * The nonce name.
	 *
	 * @param string
	 */
	private $name;

	/**
	 * The nonce action.
	 *
	 * @param string
	 */
	private $action;

	/**
	 * Constructor.
	 *
	 * @param string $key Key for the nonce
	 */
	public function __construct( $key ) {

		$this->name   = $key . '_name';
		$this->action = $key . '_action';
	}

	/**
	 * Get nonce name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Get nonce action
	 *
	 * @return string
	 */
	public function get_action() {
		return $this->action;
	}

	/**
	 * Validate the nonce
	 *
	 * @return bool
	 */
	public function is_valid() {
		return isset( $_REQUEST[ $this->name ] ) && wp_verify_nonce( $_REQUEST[ $this->name ], $this->action );
	}
}
