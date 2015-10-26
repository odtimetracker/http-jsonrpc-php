<?php

/**
 * Simple JSON-RPC server for odTimeTracker front-end applications.
 *
 * @link https://github.com/odtimetracker/http-jsonrpc-php for the canonical source repository
 * @copyright Copyright (c) 2015 Ondřej Doněk.
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace odTimeTracker\JsonRpc\Model;

/**
 * Simple test for Project class.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class ProjectTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Project $emptyProject
	 */
	protected $emptyProject;

	/**
	 * @var Project $sampleProject
	 */
	protected $sampleProject;

	/**
	 * Set-up test objects.
	 */
	public function setUp() {
		$this->emptyProject = new Project();
		$this->sampleProject = new Project(
				1, 'Test project', 'Some description...', '2015-06-14T20:39:00+0200'
		);
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::getProjectId
	 */
	public function testGetProjectId() {
		$this->assertNull($this->emptyProject->getProjectId());
		$this->assertEquals(1, $this->sampleProject->getProjectId());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::setProjectId
	 */
	public function testSetProjectId() {
		$this->assertEquals(10, $this->emptyProject->setProjectId(10)->getProjectId());
		$this->assertNull($this->emptyProject->setProjectId(null)->getProjectId());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::getName
	 */
	public function testGetName() {
		$this->assertNull($this->emptyProject->getName());
		$this->assertEquals('Test project', $this->sampleProject->getName());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::setName
	 */
	public function testSetName() {
		$this->assertEquals('Test name', $this->emptyProject->setName('Test name')->getName());
		$this->assertNull($this->emptyProject->setName(null)->getName());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::getDescription
	 */
	public function testGetDescription() {
		$this->assertNull($this->emptyProject->getDescription());
		$this->assertEquals('Some description...', $this->sampleProject->getDescription());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::setDescription
	 */
	public function testSetDescription() {
		$this->assertEquals('Test description', $this->emptyProject->setDescription('Test description')->getDescription());
		$this->assertNull($this->emptyProject->setDescription(null)->getDescription());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::getCreated
	 */
	public function testGetCreated() {
		$this->assertNull($this->emptyProject->getCreated());
		$this->assertEquals('2015-06-14T20:39:00+0200', $this->sampleProject->getCreated());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::setCreated
	 */
	public function testSetCreated() {
		$this->assertEquals('2015-06-15T06:20:00+0200', $this->emptyProject->setCreated('2015-06-15T06:20:00+0200')->getCreated());
		$this->assertNull($this->emptyProject->setCreated(null)->getCreated());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::exchangeArray
	 */
	public function testExchangeArray() {
		$this->markTestIncomplete('Finish "exchangeArray" test!');
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::toArray
	 */
	public function testToArray() {
		$this->markTestIncomplete('Finish "toArray" test!');
	}

}
