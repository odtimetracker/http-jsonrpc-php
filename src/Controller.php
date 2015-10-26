<?php

/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @link https://github.com/odtimetracker/http-jsonrpc-php for the canonical source repository
 * @copyright Copyright (c) 2015 Ondřej Doněk.
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc;

use odTimeTracker\JsonRpc\Response\Error as ResponseError;
use odTimeTracker\JsonRpc\Storage\StorageInterface;
use odTimeTracker\JsonRpc\Model\Activity;

/**
 * Controller class for our JSON-RPC server.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class Controller {

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
	 * Holds connection to the used storage.
	 * @var StorageInterface $storage
	 */
	protected $storage;

	/**
	 * Constructor.
	 * @param Request $request
	 */
	public function __construct(Request $request, StorageInterface $storage) {
		$this->request = $request;
		$this->response = new Response();
		$this->storage = $storage;

		$this->response->setIdentifier($this->request->getIdentifier());
	}

	/**
	 * Retrieve used request.
	 * @return Request
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Retrieve server response.
	 * @return Response
	 */
	public function getResponse() {
		return $this->response;
	}

	/**
	 * Dispatch action.
	 */
	public function dispatch() {
		if (!$this->request->isValid()) {
			$error = new ResponseError();
			$error->setCode(ResponseError::INVALID_REQUEST);
			$error->setMessage($this->request->getError());
			$this->response->setError($error);
			return;
		}

		try {
			$actionName = 'action' . $this->request->getMethod();
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
	public function actionInfo() {
		$runningActivity = $this->storage->getRunningActivity();

		if (!($runningActivity instanceof Activity)) {
			$this->response->setResult(array(
				'message' => 'There is no running activity.',
			));
			return;
		}

		$this->response->setResult(array(
			'message' => 'There is a running activity.',
			'activity' => $runningActivity->toArray(),
		));
	}

	/**
	 * Invoke "status" action.
	 *
	 * Note: This action is just an alias for **Info** action.
	 */
	public function actionStatus() {
		$this->actionInfo();
	}

	/**
	 * Invoke "start" action.
	 */
	public function actionStart() {
		$params = $this->request->getParams();
		$pid = (array_key_exists('ProjectId', $params)) ? (int) $params['ProjectId'] : 0;
		$name = (array_key_exists('Name', $params)) ? $params['Name'] : '';
		$desc = (array_key_exists('Description', $params)) ? $params['Description'] : null;
		$tags = (array_key_exists('Tags', $params)) ? $params['Tags'] : null;

		if (empty($name) || $pid == 0) {
			$error = new ResponseError();
			$error->setCode(ResponseError::INVALID_PARAMS);
			$error->setMessage('Activity was not started - wrong parameters given!');
			$this->response->setError($error);
			return;
		}

		$activity = $this->storage->startActivity($pid, $name, $desc, $tags);

		if ($activity === false) {
			$error = new ResponseError();
			$error->setCode(ResponseError::SERVER_ERROR);
			$error->setMessage('Starting activity failed!');
			$this->response->setError($error);
			return;
		} elseif (is_null($activity)) {
			$this->response->setResult(array(
				'message' => 'Activity was not started - another activity is running.'
			));
			return;
		}

		$this->response->setResult(array(
			'message' => 'Activity was successfully started!',
			'activity' => $activity->toArray(),
		));
	}

	/**
	 * Invoke "stop" action.
	 */
	public function actionStop() {
		$activity = $this->storage->stopActivity();

		if ($activity === false) {
			$error = new ResponseError();
			$error->setCode(ResponseError::SERVER_ERROR);
			$error->setMessage('Stopping activity failed!');
			$this->response->setError($error);
			return;
		} elseif (is_null($activity)) {
			$this->response->setResult(array(
				'message' => 'Couldn\'t stop activity - no activity is running.'
			));
			return;
		}

		$this->response->setResult(array(
			'message' => 'Activity was successfully stopped!',
			'activity' => $activity->toArray(),
		));
	}

	/**
	 * Invoke "selectProject" action.
	 * @return void
	 */
	public function actionProjectSelect() {
		$filter = $this->getRequest()->getParams();
		$project = $this->storage->selectProject($filter);

		$this->response->setResult(array(
			'project' => $project
		));
	}

}
