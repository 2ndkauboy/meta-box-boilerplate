<?php
/**
 * Nonce_Validator
 *
 * @package IMBJobOffer
 */

namespace imb;

/**
 * Class Nonce_Validator
 *
 * Implementation to validate a nonce
 *
 * @package IMBJobOffer
 */
class Nonce_Validator implements Nonce_Validator_Interface {

	/**
	 * The nonce name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The nonce action.
	 *
	 * @var string
	 */
	private $action;

	/**
	 * Constructor.
	 *
	 * @param string $key Key for the nonce.
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
		return isset( $_REQUEST[ $this->name ] ) && wp_verify_nonce( sanitize_key( $_REQUEST[ $this->name ] ), $this->action ); // WPCS: input var OK.
	}
}
