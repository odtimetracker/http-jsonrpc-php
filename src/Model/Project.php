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
 * Class implementing single project.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class Project
{
	/**
	 * Numeric identifier of the project.
	 * @var integer $projectId
	 */
	protected $projectId;

	/**
	 * Name of the project.
	 * @var string $name
	 */
	protected $name;

	/**
	 * Description of the project.
	 * @var string $description
	 */
	protected $description;

	/**
	 * Datetime of creation of the project (formatted by RFC3339).
	 * @var string $created
	 */
	protected $created;

	/**
	 * Constructor.
	 * @param integer $projectId (Optional.)
	 * @param string $name (Optional.)
	 * @param string $description (Optional.)
	 * @param string $created (Optional.)
	 */
	public function __construct(
		$projectId = null,
		$name = null,
		$description = null,
		$created = null
	) {
		$this->projectId = $projectId;
		$this->name = $name;
		$this->description = $description;
		$this->created = $created;
	}

	/**
	 * Retrieve identifier of the project.
	 * @return integer
	 */
	public function getProjectId()
	{
		return $this->projectId;
	}

	/**
	 * Set identifier of the project.
	 * @param integer $projectId
	 * @return Project
	 */
	public function setProjectId($projectId)
	{
		$this->projectId = $projectId;
		return $this;
	}

	/**
	 * Retrieve name of the project.
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set name of the project.
	 * @param string $name
	 * @return Project
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Retrieve description of the project.
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set description of the project.
	 * @param string $description
	 * @return Project
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * Retrieve datetime of creation of the project (formatted by RFC3339).
	 * @return string
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * Set datetime of creation of the project (formatted by RFC3339).
	 * @param string $created
	 * @return Project
	 */
	public function setCreated($created)
	{
		$this->created = $created;
		return $this;
	}
}
