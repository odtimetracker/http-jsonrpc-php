<?php
/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @link https://github.com/odtimetracker/http-jsonrpc-php for the canonical source repository
 * @copyright Copyright (c) 2015 Ondřej Doněk.
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc\Storage;

use odTimeTracker\JsonRpc\Model\Activity;
use odTimeTracker\JsonRpc\Model\Project;

/**
 * Tests from SQLite based storage class.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class SqliteTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::getSchemaVersion
	 */
	public function testGetSchemaVersion()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);

		$this->assertEquals(0, $storage->getSchemaVersion());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::createSchema
	 */
	public function testCreateSchema()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);

		$this->assertNull($storage->createSchema());
		$this->assertEquals(1, $storage->getSchemaVersion());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::emptyStorage
	 */
	public function testEmptyStorage()
	{
		$this->markTestIncomplete('Finish `emptyStorage` test!');
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::getRunningActivity
	 */
	public function testGetRunningActivity()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);
		$storage->createSchema();

		$this->assertNull($storage->getRunningActivity());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::startActivity
	 */
	public function testStartActivity()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);
		$storage->createSchema();

		$activity = $storage->startActivity(
			1,
			'Test activity',
			'Some description...',
			'tag1,tag2,tag3'
		);
		$this->assertInstanceOf('\odTimeTracker\JsonRpc\Model\Activity', $activity);
		$this->assertGreaterThan(0, $activity->getActivityId());
		$this->assertEquals(1, $activity->getProjectId());
		$this->assertEquals('', $activity->getName());
		$this->assertEquals('', $activity->getDescription());
		$this->assertEquals('', $activity->getTags());
		$this->assertNotNull($activity->getStarted());
		$this->assertNull($activity->getStopped());

		$runningActivity = $storage->getRunningActivity();
		$this->assertInstanceOf('\odTimeTracker\JsonRpc\Model\Activity', $runningActivity);
		$this->assertEquals($runningActivity->getActivityId(), $activity->getActivityId());
		$this->assertEquals($runningActivity->getProjectId(), $activity->getProjectId());
		$this->assertEquals($runningActivity->getName(), $activity->getName());
		$this->assertEquals($runningActivity->getDescription(), $activity->getDescription());
		$this->assertEquals($runningActivity->getTags(), $activity->getTags());
		$this->assertEquals($runningActivity->getStarted(), $activity->getStarted());
		$this->assertEquals($runningActivity->getStopped(), $activity->getStopped());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::stopActivity
	 */
	public function testStopActivity()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);
		$storage->createSchema();

		$this->assertNull($storage->stopActivity());

		$activityOriginal = $storage->startActivity(
			1,
			'Test activity',
			'Some description...',
			'tag1,tag2,tag3'
		);
		$activityStopped = $storage->stopActivity();
		$this->assertInstanceOf('\odTimeTracker\JsonRpc\Model\Activity', $activityStopped);
		$this->assertEquals($activityStopped->getActivityId(), $activityOriginal->getActivityId());
		$this->assertEquals($activityStopped->getProjectId(), $activityOriginal->getProjectId());
		$this->assertEquals($activityStopped->getName(), $activityOriginal->getName());
		$this->assertEquals($activityStopped->getDescription(), $activityOriginal->getDescription());
		$this->assertEquals($activityStopped->getTags(), $activityOriginal->getTags());
		$this->assertEquals($activityStopped->getStarted(), $activityOriginal->getStarted());
		$this->assertNotEquals($activityStopped->getStopped(), $activityOriginal->getStopped());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::updateActivity
	 */
	public function testUpdateActivity()
	{
		$this->markTestIncomplete('Finish `updateActivity` test!');
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::insertProject
	 */
	public function testInsertProject()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);
		$storage->createSchema();

		$projectOriginal = new Project('Test project');
		$projectInserted = $storage->insertProject(new Project('Test project'));

		$this->assertInstanceOf('\odTimeTracker\JsonRpc\Model\Project', $projectInserted);
		$this->assertGreaterThan(0, $projectInserted->getProjectId());
		$this->assertEquals($projectInserted->getName(), $projectOriginal->getName());
		$this->assertEquals($projectInserted->getDescription(), $projectOriginal->getDescription());
		$this->assertNotEquals($projectInserted->getCreated(), $projectOriginal->getCreated());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::updateProject
	 */
	public function testUpdateProject()
	{
		$pdo = new \PDO('sqlite::memory:');
		$storage = new Sqlite($pdo);
		$storage->createSchema();

		$projectOriginal = new Project('Test project');
		$projectInserted = $storage->insertProject();

		$projectOriginal->setProjectId($projectInserted->getProjectId());
		$projectOriginal->setDescription('Some description...');

		$projectUpdated = $storage->updateProject($projectOriginal);

		$this->assertInstanceOf('\odTimeTracker\JsonRpc\Model\Project', $projectUpdated);
		$this->assertEquals($projectUpdated->getProjectId(), $projectInserted->getProjectId());
		$this->assertEquals($projectUpdated->getName(), $projectInserted->getName());
		$this->assertNotEquals($projectUpdated->getDescription(), $projectInserted->getDescription());
		$this->assertEquals($projectUpdated->getCreated(), $projectInserted->getCreated());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::selectActivity
	 */
	public function testSelectActivity()
	{
		$this->markTestIncomplete('Finish `selectActivity` test!');
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::selectProject
	 */
	public function testSelectProject()
	{
		$this->markTestIncomplete('Finish `selectProject` test!');
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::removeActivity
	 */
	public function testRemoveActivity()
	{
		$this->markTestIncomplete('Finish `removeActivity` test!');
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Storage\Sqlite::removeProject
	 */
	public function testRemoveProject()
	{
		$this->markTestIncomplete('Finish `removeProject` test!');
	}
}
