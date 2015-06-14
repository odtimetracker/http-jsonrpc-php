<?php
/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc\Response;

/**
 * Class for describing errors.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link http://www.jsonrpc.org/specification#error_object
 */
class Error
{
	/**
	 * Invalid JSON was received by the server.
	 * @type integer
	 */
	const PARSE_ERROR = 32700;

	/**
	 * The JSON sent is not a valid Request object.
	 * @type integer
	 */
	const INVALID_REQUEST = 32600;

	/**
	 * The method does not exist or is not available.
	 * @type integer
	 */
	const METHOD_NOT_FOUND = 32601;

	/**
	 * Invalid method parameter(s).
	 * @type integer
	 */
	const INVALID_PARAMS = 32602;

	/**
	 * Internal error.
	 * @type integer
	 */
	const INTERNAL_ERROR = 32603;

	/**
	 * Reserved for implementation-defined server-errors.
	 * @type Integer
	 */
	const SERVER_ERROR = 32000;

	/**
	 * Number that indicates the error type that occurred.
	 * @var integer $code
	 */
	protected $code;

	/**
	 * String providing a short description of the error.
	 * @var string $message
	 */
	protected $message;

	/**
	 * Primitive or structured value that contains additional information
	 * about the error.
	 * @var mixed $data
	 */
	protected $data;

	/**
	 * Constructor.
	 * @param integer $code (Optional.)
	 * @param string $message (Optional.)
	 * @param mixed $data (Optional.)
	 */
	public function __construct($code = null, $message = null, $data = null)
	{
		$this->code = $code;
		$this->message = $message;
		$this->data = $data;
	}

	/**
	 * Retrieve error's code.
	 * @return integer
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set error's code.
	 * @param integer $code
	 * @return Error
	 */
	public function setCode($code)
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * Retrieve error's message.
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Set error's message.
	 * @param string $message
	 * @return Error
	 */
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}

	/**
	 * Retrieve error's additional data.
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set error's additional data.
	 * @param mixed $data
	 * @return Error
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}
}
