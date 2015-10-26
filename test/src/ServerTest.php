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
 * Simple test with SQLite in-memory database.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class ServerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @const string Server URL.
	 */
	const SERVER_URI = 'http://localhost:8000';

	/**
	 * @param integer $id
	 * @param string $method
	 * @param array $params (Optional.)
	 */
	private function createStreamContextConfig($id, $method, $params = array()) {
		return array(
			'http' => array(
				'header' => 'Content-type: application/json',
				'method' => 'POST',
				'content' => json_encode(array(
					'jsonrpc' => '2.0',
					'method' => $method,
					'params' => $params,
				)),
			),
		);
	}

	/**
	 * Simple bad request test.
	 * @covers odTimeTracker\JsonRpc\Server
	 */
	public function testFirstBadRequest() {
		$context = stream_context_create(array(
			'http' => array(
				'header' => "Content-type: application/json\r\n",
				'method' => 'POST',
			),
		));

		try {
			$result = file_get_contents(self::SERVER_URI, false, $context);
		} catch (\Exception $e) {
			$this->markTestSkipped(sprintf(
							'Unable to connect test server on address "%s"!', self::SERVER_URI
			));
		}

		$this->assertEquals(
				'{"jsonrpc":"2.0","error":{"code":32600,"message":"Request is not valid!"}}', $result
		);
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Controller::actionInfo
	 */
	public function testInfoRequest() {
		$contextCfg = $this->createStreamContextConfig(1, 'Info');
		$context = stream_context_create($contextCfg);

		try {
			$result = file_get_contents(self::SERVER_URI, false, $context);
		} catch (\Exception $e) {
			$this->markTestSkipped(sprintf(
							'Unable to connect test server on address "%s"!', self::SERVER_URI
			));
		}

		$this->assertEquals(
				'{"jsonrpc":"2.0","id":1,"result":{"message":"There is no running activity."}}', $result
		);
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Controller::actionStart
	 * /
	  public function testStartRequest()
	  {
	  $contextCfg = $this->createStreamContextConfig(2, 'Start', array(
	  'Name' => 'http-jsonrpc-php 0.1',
	  'Tags' => 'PHP,Projects',
	  'Project' => 'odTimeTracker',
	  'Description' => 'Starting activity via JsonRpc.'
	  ));
	  $context = stream_context_create($contextCfg);

	  try {
	  $result = file_get_contents(self::SERVER_URI, false, $context);
	  } catch (\Exception $e) {
	  $this->markTestSkipped(sprintf(
	  'Unable to connect test server on address "%s"!',
	  self::SERVER_URI
	  ));
	  }

	  //Possible results:
	  // - Activity was not started - another activity is running.
	  // - Activity was successfully started!

	  //Possible errors:
	  // - Activity was not started - wrong parameters given!
	  // - Starting activity failed!

	  // ...
	  } */
	/**
	 * @covers odTimeTracker\JsonRpc\Controller::actionStart
	 * /
	  public function testStopRequest()
	  {
	  //{ "jsonrpc":"2.0", "method":"Start""id":1 }
	  $contextCfg = $this->createStreamContextConfig(3, 'Stop');
	  $context = stream_context_create($contextCfg);

	  try {
	  $result = file_get_contents(self::SERVER_URI, false, $context);
	  } catch (\Exception $e) {
	  $this->markTestSkipped(sprintf(
	  'Unable to connect test server on address "%s"!',
	  self::SERVER_URI
	  ));
	  }

	  //Possible results:
	  // - Couldn't stop activity - no activity is running.
	  // - Activity was successfully stopped!

	  //Possible errors:
	  // - Stopping activity failed!

	  // ...
	  } */
}
