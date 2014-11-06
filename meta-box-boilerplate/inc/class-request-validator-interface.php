<?php
/**
 * Validate a request
 */

namespace meta_box_boilerplate;

interface Request_Validator_Interface {

	/**
	 * Check if the request is valid
	 *
	 * @return bool
	 */
	public function is_valid();
}