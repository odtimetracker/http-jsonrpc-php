<?php
/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc;

use odTimeTracker\JsonRpc\Response\Error as ResponseError;

/**
 * Class representing responses of our JSON-RPC server.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link http://www.jsonrpc.org/specification#response_object
 */
class Response
{
	/**
	 * String specifying the version of the JSON-RPC protocol. **MUST** be exactly `2.0`.
	 * @var string $jsonrpc
	 */
	protected $jsonrpc = '2.0';

	/**
	 * This member is **REQUIRED** on success. This member **MUST** be `NULL`
	 * if there was an error invoking the method. The value is determined
	 * by the invoked method.
	 * @var mixed $result
	 */
	protected $result = null;

	/**
	 * This member is **REQUIRED** on error. This member **MUST** be `NULL`
	 * if there was no error triggered during invocation.
	 * @var ResponseError|null $result
	 */
	protected $error = null;

	/**
	 * This member is **REQUIRED**. It **MUST** be the same as the value
	 * of the id member in the request.
	 *
	 * If there was an error in detecting the id in the request (e.g.
	 * _Parse error_/_Invalid Request_), it **MUST** be `NULL`.
	 * @var integer|null $id
	 */
	protected $identifier = null;

	/**
	 * Constructor.
	 */
	public function __construct($result = null, $error = null, $identifier = null)
	{
		$this->result = $result;
		$this->error = $error;
		$this->identifier = $identifier;
	}

	/**
	 * Retrieve result.
	 * @return mixed|null
	 */
	public function getResult()
	{
		return $this->error;
	}

	/**
	 * Set a result.
	 * @param mixed|null $result
	 * @return Response
	 */
	public function setResult($result)
	{
		$this->result = $result;
		return $this;
	}

	/**
	 * Retrieve an error (if occured).
	 * @return ResponseError|null
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Set an error.
	 * @param ResponseError|null $error
	 * @return Response
	 */
	public function setError($error)
	{
		$this->error = $error;
		return $this;
	}

	/**
	 * Retrieve an identifier established by the client.
	 * @return integer|null
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}

	/**
	 * Set an identifier established by the client.
	 * @param integer|null $id
	 * @return Response
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 * Return `TRUE` if error occured during invocation.
	 * @return boolean
	 */
	public function isError()
	{
		return ($this->error instanceof ResponseError);
	}

	/**
	 * Return response as JSON string.
	 * @return string
	 */
	public function __toString()
	{
		$json = array('jsonrpc' => $this->jsonrpc);

		if (!is_null($this->identifier)) {
			$json['id'] = $this->identifier;
		}

		if ($this->isError() === true) {
			$json['error'] = array('code' => $this->error->getCode());

			if (!empty($this->error->getMessage())) {
				$json['error']['message'] = $this->error->getMessage();
			}

			if (!empty($this->error->getData())) {
				$json['error']['data'] = $this->error->getData();
			}
		} else {
			$json['result'] = $this->result;
		}

		return json_encode($json);
	}
}
