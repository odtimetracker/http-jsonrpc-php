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
 * Controller class for our JSON-RPC server.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class Controller
{
	/**
	 * Holds used request.
	 * @var Request $request
	 */
	protected $request;

	/**
	 * Holds server response.
	 * @var Response $response
	 */
	protected $response;

	/**
	 * Constructor.
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->response = new Response();

		$this->response->setIdentifier($this->request->getIdentifier());
	}

	/**
	 * Retrieve used request.
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Retrieve server response.
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * Dispatch action.
	 */
	public function dispatch()
	{
		if (!$this->request->isValid()) {
			$error = new ResponseError();
			$error->setCode(ResponseError::INVALID_REQUEST);
			$error->setMessage('Request is not valid!');

			$this->response->setError($error);

			return;
		}

		try {
			$actionName = 'action' . $this->request->getMethod() ;
			$this->{$actionName}();
		} catch (\Exception $e) {
			$error = new ResponseError();
			$error->setCode(ResponseError::SERVER_ERROR);
			$error->setMessage(sprintf('Error: "%s"', $e->getMessage()));
		}
	}

	/**
	 * Invoke "info" action.
	 */
	public function actionInfo()
	{
		$this->response->setResult(array(
			'message' => 'There is no running activity.',
		));
	}

	/**
	 * Invoke "status" action.
	 *
	 * Note: This action is just an alias for **Info** action.
	 */
	public function actionStatus()
	{
		$this->actionInfo();
	}
}
