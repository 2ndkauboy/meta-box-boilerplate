<?php
/**
 * Request_Validator_Interface
 *
 * Validate a request
 *
 * @package IMBJobOffer
 */

namespace imb;

/**
 * Interface Request_Validator_Interface
 *
 * @package IMBJobOffer
 */
interface Request_Validator_Interface {

	/**
	 * Check if the request is valid
	 *
	 * @return bool
	 */
	public function is_valid();
}
