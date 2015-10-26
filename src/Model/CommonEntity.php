<?php

/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @link https://github.com/odtimetracker/http-jsonrpc-php for the canonical source repository
 * @copyright Copyright (c) 2015 Ondřej Doněk.
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc\Model;

/**
 * Parent abstract class for common entity classes.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
abstract class CommonEntity {

	/**
	 * Exchange values of the object with given array.
	 * @param array $data
	 * @return Activity
	 */
	public function exchangeArray($data = array()) {
		foreach ($data as $key => $val) {
			$lkey = lcfirst($key);

			if (property_exists($this, $lkey)) {
				$this->{$lkey} = $val;
			}
		}
	}

	/**
	 * Return activity as an array.
	 * @return array
	 */
	abstract public function toArray();
}
