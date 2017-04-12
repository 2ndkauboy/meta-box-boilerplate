<?php
/**
 * Nonce_Validator_Interface
 *
 * Provide nonces, and handle their validation.
 *
 * @package IMBJobOffer
 */

namespace imb;

/**
 * Interface Nonce_Validator_Interface
 *
 * @package IMBJobOffer
 */
interface Nonce_Validator_Interface {

	/**
	 * Get nonce field name
	 *
	 * @return string
	 */
	public function get_name();

	/**
	 * Get nonce action
	 *
	 * @return string
	 */
	public function get_action();

	/**
	 * Check if the nonce is valid
	 *
	 * @return bool
	 */
	public function is_valid();
}
