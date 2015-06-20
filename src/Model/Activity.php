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
 * Class implementing single activity.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class Activity extends CommonEntity
{
	/**
	 * Numeric identifier of the activity.
	 * @var integer $activityId
	 */
	protected $activityId;

	/**
	 * Numeric identifier of the attached project.
	 * @var integer $projectId
	 */
	protected $projectId;

	/**
	 * Name of the activity.
	 * @var string $name
	 */
	protected $name;

	/**
	 * Description of the activity.
	 * @var string $description
	 */
	protected $description;

	/**
	 * Comma-separated tags attached to the activity.
	 * @var string $tags
	 */
	protected $tags;

	/**
	 * Datetime when was activity started (formatted by RFC3339).
	 * @var string $started
	 */
	protected $started;

	/**
	 * Datetime when was activity stopped (formatted by RFC3339).
	 * @var string $stopped
	 */
	protected $stopped;

	/**
	 * Constructor.
	 * @param integer $activityId (Optional.)
	 * @param integer $projectId (Optional.)
	 * @param string $name (Optional.)
	 * @param string $tags (Optional.)
	 * @param string $description (Optional.)
	 * @param string $started (Optional.)
	 * @param string $stopped (Optional.)
	 */
	public function __construct(
		$activityId = null,
		$projectId = null,
		$name = null,
		$description = null,
		$tags = null,
		$started = null,
		$stopped = null
	) {
		$this->activityId = $activityId;
		$this->projectId = $projectId;
		$this->name = $name;
		$this->description = $description;
		$this->tags = $tags;
		$this->started =  $started;
		$this->stopped =  $stopped;
	}

	/**
	 * Return activity as an array.
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'ActivityId'  => $this->activityId,
			'ProjectId'   => $this->projectId,
			'Name'        => $this->name,
			'Description' => $this->description,
			'Tags'        => $this->tags,
			'Started'     => $this->started,
			'Stopped'     => $this->stopped,
		);
	}

	/**
	 * Return activity's duration in miliseconds.
	 * @return integer
	 */
	public function getDuration()
	{
		return 0;
	}

	/**
	 * Return activity's duration as a formatted string.
	 * @return string
	 */
	public function getDurationFormatted()
	{
		return '0 s';
	}

	/**
	 * Retrieve identifier of the activity.
	 * @return integer
	 */
	public function getActivityId()
	{
		return $this->activityId;
	}

	/**
	 * Set identifier of the activity.
	 * @param integer $activityId
	 * @return Activity
	 */
	public function setActivityId($activityId)
	{
		$this->activityId = $activityId;
		return $this;
	}

	/**
	 * Retrieve identifier of the attached project.
	 * @return integer
	 */
	public function getProjectId()
	{
		return $this->projectId;
	}

	/**
	 * Set identifier of the attached project.
	 * @param integer $projectId
	 * @return Activity
	 */
	public function setProjectId($projectId)
	{
		$this->projectId = $projectId;
		return $this;
	}

	/**
	 * Retrieve name of the activity.
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set name of the activity.
	 * @param string $name
	 * @return Activity
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Retrieve description of the activity.
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set description of the activity.
	 * @param string $description
	 * @return Activity
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * Retrieve comma-separated tags attached to the activity.
	 * @return string
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Set comma-separated tags attached to the activity.
	 * @param string $tags
	 * @return Activity
	 */
	public function setTags($tags)
	{
		$this->tags = $tags;
		return $this;
	}

	/**
	 * Retrieve datetime when was activity started (formatted by RFC3339).
	 * @return string
	 */
	public function getStarted()
	{
		return $this->started;
	}

	/**
	 * Set datetime when was activity started (formatted by RFC3339).
	 * @param string $started
	 * @return Activity
	 */
	public function setStarted($started)
	{
		$this->started = $started;
		return $this;
	}

	/**
	 * Retrieve datetime when was activity stopped (formatted by RFC3339).
	 * @return string
	 */
	public function getStopped()
	{
		return $this->stopped;
	}

	/**
	 * Set datetime when was activity stopped (formatted by RFC3339).
	 * @param string $stopped
	 * @return Activity
	 */
	public function setStopped($stopped)
	{
		$this->stopped = $stopped;
		return $this;
	}
}
