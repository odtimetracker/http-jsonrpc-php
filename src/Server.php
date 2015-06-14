<?php
/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc;

/**
 * Main class for our JSON-RPC server.
 *
 * Usage:<pre>// Initialize server
 * $server = new \odTimeTracker\JsonRpc\Server(array(
 * 	'db' => array(
 * 		'dsn' => 'sqlite::memory:',
 * 	),
 * ));
 * $server->handle();</pre>
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class Server
{
	/**
	 * Array with server configuration.
	 * @var array $config
	 */
	protected $config = array();

	/**
	 * Constructor.
	 * @param array $config
	 */
	public function __construct($config = array())
	{
		$this->config = $config;
	}

	/**
	 * Handle request.
	 */
	public function handle()
	{
		// Connect database
		$dbh = new \PDO($this->config['db']['dsn']);

		// Get request
		$request = new Request();

		// Initialize controller
		$controller = new Controller($request);

		// Dispatch controller's action
		$controller->dispatch();

		// Print response
		header('content-type: application/json');
		echo $controller->getResponse();
	}
}
