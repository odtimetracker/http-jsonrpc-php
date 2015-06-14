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
class ServerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Simple bad request test.
	 * @covers odTimeTracker\JsonRpc\Server
	 */
	public function testBadRequest1()
	{
		$url = 'http://localhost:8000';
		//$data = array('key1' => 'value1', 'key2' => 'value2');
		$context  = stream_context_create(array(
			'http' => array(
				'header'  => "Content-type: application/json\r\n",
				'method'  => 'POST',
		//		'content' => http_build_query($data),
			),
		));
		$result = file_get_contents($url, false, $context);

		$this->assertEquals(
			'{"jsonrpc":"2.0","error":{"code":32600,"message":"Request is not valid!"}}',
			$result
		);
	}

	/**
	 * Test marking GET request as bad request.
	 * @covers odTimeTracker\JsonRpc\Controller::actionInfo
	 */
	public function testBadRequest2()
	{
		$context  = stream_context_create(array(
			'http' => array(
				'header' => "Content-type: application/json\r\n",
				'method' => 'GET',
				'content' => json_encode(array(
					'jsonrpc' => '2.0',
					'method' => 'Info',
					'id' => 1
				)),
			),
		));
		$result = file_get_contents('http://localhost:8000', false, $context);
		$this->assertEquals(
			'{"jsonrpc":"2.0","id":1,"result":{"message":"There is no running activity."}}',
			$result
		);
	}
}
