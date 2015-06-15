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
 * Simple test for Activity class.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class ActivityTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Activity $emptyActivity
	 */
	protected $emptyActivity;

	/**
	 * @var Activity $sampleActivity
	 */
	protected $sampleActivity;

	/**
	 * Set-up test objects.
	 */
	public function setUp()
	{
		$this->emptyActivity = new Activity();
		$this->sampleActivity = new Activity(
			1,
			1,
			'Test activity',
			'Some description.',
			'tag1,tag2,tag3',
			'2015-06-15T06:23:00+0200',
			'2015-06-15T06:53:00+0200'
		);
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getActivityId
	 */
	public function testGetActivityId()
	{
		$this->assertNull($this->emptyActivity->getActivityId());
		$this->assertEquals(1, $this->sampleActivity->getActivityId());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::setActivityId
	 */
	public function testSetActivityId()
	{
		$this->assertEquals(10, $this->emptyActivity->setActivityId(10)->getActivityId());
		$this->assertNull($this->emptyActivity->setActivityId(null)->getActivityId());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getProjectId
	 */
	public function testGetProjectId()
	{
		$this->assertNull($this->emptyActivity->getProjectId());
		$this->assertEquals(1, $this->sampleActivity->getProjectId());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Project::setProjectId
	 */
	public function testSetProjectId()
	{
		$this->assertEquals(10, $this->emptyActivity->setProjectId(10)->getProjectId());
		$this->assertNull($this->emptyActivity->setProjectId(null)->getProjectId());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getName
	 */
	public function testGetName()
	{
		$this->assertNull($this->emptyActivity->getName());
		$this->assertEquals('Test activity', $this->sampleActivity->getName());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::setName
	 */
	public function testSetName()
	{
		$this->assertEquals('Activity name', $this->emptyActivity->setName('Activity name')->getName());
		$this->assertNull($this->emptyActivity->setName(null)->getName());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getDescription
	 */
	public function testGetDescription()
	{
		$this->assertNull($this->emptyActivity->getDescription());
		$this->assertEquals('Some description.', $this->sampleActivity->getDescription());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::setDescription
	 */
	public function testSetDescription()
	{
		$this->assertEquals('Activity description', $this->emptyActivity->setDescription('Activity description')->getDescription());
		$this->assertNull($this->emptyActivity->setDescription(null)->getDescription());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getTags
	 */
	public function testGetTags()
	{
		$this->assertNull($this->emptyActivity->getTags());
		$this->assertEquals('tag1,tag2,tag3', $this->sampleActivity->getTags());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::setTags
	 */
	public function testSetTags()
	{
		$this->assertEquals('tag1,tag2', $this->emptyActivity->setTags('tag1,tag2')->getTags());
		$this->assertNull($this->emptyActivity->setTags(null)->getTags());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getStarted
	 */
	public function testGetStarted()
	{
		$this->assertNull($this->emptyActivity->getStarted());
		$this->assertEquals('2015-06-15T06:23:00+0200', $this->sampleActivity->getStarted());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::setStarted
	 */
	public function testSetStarted()
	{
		$this->assertEquals('2015-06-15T06:35:00+0200', $this->emptyActivity->setStarted('2015-06-15T06:35:00+0200')->getStarted());
		$this->assertNull($this->emptyActivity->setStarted(null)->getStarted());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::getStopped
	 */
	public function testGetStopped()
	{
		$this->assertNull($this->emptyActivity->getStopped());
		$this->assertEquals('2015-06-15T06:53:00+0200', $this->sampleActivity->getStopped());
	}

	/**
	 * @covers odTimeTracker\JsonRpc\Model\Activity::setStopped
	 */
	public function testSetStopped()
	{
		$this->assertEquals('2015-06-15T06:37:00+0200', $this->emptyActivity->setStopped('2015-06-15T06:37:00+0200')->getStopped());
		$this->assertNull($this->emptyActivity->setStopped(null)->getStopped());
	}
}
