<?php

/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @link https://github.com/odtimetracker/http-jsonrpc-php for the canonical source repository
 * @copyright Copyright (c) 2015 Ondřej Doněk.
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */
// Include all required sources

require_once dirname(__DIR__) . '/vendor/autoload.php';


// Initialize configuration (taken from `odtimetracker-php-gtk`).

defined('CONFIG_FILE_NAME') || define('CONFIG_FILE_NAME', 'config.ini');
defined('CONFIG_SEC_NAME') || define('CONFIG_SEC_NAME', 'odtimetracker-php-jsonrpc');

/**
 * @var string $configdir
 */
$configdir = dirname(__DIR__) . '/config';
if (!file_exists($configdir)) {
	if (!mkdir('path/to/directory', 0777, true)) {
		die('Exiting - can not create configuration directory!' . PHP_EOL);
	}
} else if (!is_dir($configdir)) {
	die('Exiting - configuration directory is not a directory!' . PHP_EOL);
}

/**
 * @var string $configfile
 */
$configfile = $configdir . '/config.ini';
if (!file_exists($configfile)) {
	// Create `.odTimeTracker/conf.ini` file with default database connection
	$res = file_put_contents(
			$configfile, '; odTimeTracker Configuration File' . PHP_EOL .
			PHP_EOL .
			'[' . CONFIG_SEC_NAME . ']' . PHP_EOL .
			'db.dsn="sqlite:' . $configdir . '/db.sqlite"' . PHP_EOL .
			'db.username=""' . PHP_EOL .
			'db.password=""' . PHP_EOL .
			PHP_EOL
	);

	if ($res === false) {
		die('Exiting - creating of configuration file failed!' . PHP_EOL);
	}
} else if (!is_file($configfile) || !is_readable($configfile)) {
	die('Exiting - configuration file is not readable!' . PHP_EOL);
}

/**
 * @var array $configarr
 */
$configarr = parse_ini_file($configfile, true);
if (!array_key_exists(CONFIG_SEC_NAME, $configarr)) {
	die('Exiting - configuration file is not valid!' . PHP_EOL);
}

/**
 * @var array $config
 */
$config = $configarr[CONFIG_SEC_NAME];


// Start the JSON-RPC server

/**
 * @var \odTimeTracker\JsonRpc\Server $server
 */
$server = new \odTimeTracker\JsonRpc\Server($config);
$server->handle();
