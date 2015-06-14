<?php
/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @link https://github.com/odtimetracker/http-jsonrpc-php for the canonical source repository
 * @copyright Copyright (c) 2015 Ondřej Doněk.
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc;

/**
 * Class representing requests to our JSON-RPC server.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link http://www.jsonrpc.org/specification#request_object
 */
class Request
{
	/**
	 * String specifying the version of the JSON-RPC protocol. **MUST** be exactly `2.0`.
	 * @var string $jsonrpc
	 */
	protected $jsonrpc = '2.0';

	/**
	 * String containing the name of the method to be invoked.
	 * @var string $method
	 */
	protected $method;

	/**
	 * Holds the parameter values to be used during the invocation of the method.
	 * @var array $params
	 */
	protected $params;

	/**
	 * An identifier established by the client. We works just with numeric identifiers.
	 * @var integer $identifier
	 */
	protected $identifier;

	/**
	 * Holds `FALSE` if the request was wrong.
	 * @var boolean $isValid
	 */
	protected $isValid = false;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$request = json_decode(file_get_contents('php://input'), true);

		if (!is_array($request)) {
			return;
		}

		$this->jsonrpc = array_key_exists('jsonrpc', $request) ? $request['jsonrpc'] : '2.0';
		$this->method = array_key_exists('method', $request) ? $request['method'] : null;
		$this->params = array_key_exists('params', $request) ? $request['params'] : null;
		$this->identifier = array_key_exists('id', $request) ? $request['id'] : null;

		$this->isValid = $this->validate();
	}

	/**
	 * Validate request.
	 * @return boolean
	 */
	protected function validate()
	{
		if ($this->jsonrpc != '2.0') {
			return false;
		}

		if (!in_array($this->method, $this->getAvailableMethods())) {
			return false;
		}

		return true;
	}

	/**
	 * Return list of available method names.
	 * @return array
	 */
	public function getAvailableMethods()
	{
		return [
			'Info',
			'Start',
			'Stop',
			'Status',
			'ActivityInsert',
			'ActivityRemove',
			'ActivitySelect',
			'ActivityUpdate',
			'ProjectInsert',
			'ProjectRemove',
			'ProjectSelect',
			'ProjectUpdate',
		];
	}

	/**
	 * Return `TRUE` if request is valid.
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->isValid;
	}

	/**
	 * Retrieve used version of the JSON-RPC protocol.
	 * @return string
	 */
	public function getJsonrpc()
	{
		return $this->jsonrpc;
	}

	/**
	 * Retrieve the name of the method to be invoked.
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Retrieve the parameter values to be used during the invocation of the method.
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * Retrieve request identifier.
	 * @return integer|null
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}
}
