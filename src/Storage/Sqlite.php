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
 * SQLite storage.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
class Sqlite implements StorageInterface
{
	/**
	 * @const string Default date time format (RFC3339).
	 */
	const RFC3339 = 'Y-m-d\TH:i:sO';

	/**
	 * Holds instance of `PDO` object.
	 * @var \PDO $pdo
	 */
	protected $pdo;

	/**
	 * Constructor.
	 * @var \PDO $pdo
	 */
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Get schema version.
	 * @return integer
	 */
	public function getSchemaVersion()
	{
		$stmt = $this->pdo->query('PRAGMA user_version;');

		return (int) $stmt->fetchColumn();
	}

	/**
	 * Create storage schema.
	 */
	public function createSchema()
	{
		$sql = <<<EOT
CREATE TABLE Projects (
	ProjectId INTEGER PRIMARY KEY,
	Name TEXT,
	Description TEXT,
	Created TEXT NOT NULL
);
CREATE TABLE Activities (
	ActivityId INTEGER PRIMARY KEY,
	ProjectId INTEGER NOT NULL,
	Name TEXT,
	Description TEXT,
	Tags TEXT,
	Started TEXT NOT NULL,
	Stopped TEXT NOT NULL DEFAULT '',
	FOREIGN KEY(ProjectId) REFERENCES Projects(ProjectId)
);
PRAGMA user_version = 1;
EOT;
		$this->pdo->exec($sql);
	}

	/**
	 * Clear all data from the storage.
	 */
	public function emptyStorage()
	{
		$sql = <<<EOT
DELETE FROM Activities;
DELETE FROM Projects;
VACUUM;
EOT;
		$this->pdo->exec($sql);
	}

	/**
	 * Retrieve currently running activity.
	 * @return Activity|null
	 */
	public function getRunningActivity()
	{
		$sql = <<<EOT
SELECT *
FROM `Activities`
WHERE `Stopped` IS NULL OR `Stopped` = '' ;
EOT;
		$stmt = $this->pdo->query($sql, \PDO::FETCH_ASSOC);
		if ($stmt === false) {
			return null;
		}

		$data = $stmt->fetch();
		if ($data === false) {
			return null;
		}

		$activity = new Activity();
		$activity->exchangeArray($data);

		return $activity;
	}

	/**
	 * Return `TRUE` if there is a running activity.
	 * @return boolean
	 */
	public function isRunningActivity()
	{
		 $runningActivity = $this->getRunningActivity();
		 return ($runningActivity instanceof Activity);
	}

	/**
	 * Start new activity.
	 *
	 * Returns:
	 * <ul>
	 * <li>{@see Activity} - successfully started activity</li>
	 * <li><i>NULL</i> if there is another running activity</li>
	 * <li><i>false</i> when inserting activity into database failed.</li>
	 * </ul>
	 * @param integer $projectId Project's ID.
	 * @param string $name Activity's name.
	 * @param string $description Activity's description.
	 * @param string $tags Activity's tags.
	 * @return Activity|boolean|null
	 */
	public function startActivity($projectId, $name, $description = null, $tags = null)
	{
		if ($this->isRunningActivity()) {
			return null;
		}

		$sql = <<<EOL
INSERT INTO `Activities` (`ProjectId`, `Name`, `Description`, `Tags`, `Started`)
VALUES (?, ?, ?, ?, ?);
EOL;
		$stmt = $this->pdo->prepare($sql);
		$res = $stmt->execute(array($projectId, $name, $description, $tags));

		if ($res === false) {
			return false;
		}

		$activity->setActivityId($this->pdo->lastInsertId());

		return $activity;
	}

	/**
	 * Stop currently running activity (if there is any).
	 *
	 * Returns:
	 * <ul>
	 * <li>{@see Activity} - successfully stopped activity</li>
	 * <li><i>NULL</i> if there was no running activity</li>
	 * <li><i>false</i> when updating activity in database failed.</li>
	 * </ul>
	 * @return Activity|boolean|null
	 */
	public function stopActivity()
	{
		$activity = $this->getRunningActivity();
		if (!($activity instanceof Activity)) {
			return null;
		}

		$activity->setStopped(date(self::RFC3339));

		return $this->updateActivity($activity);
	}

	/**
	 * Update activity.
	 * @param Activity $activity
	 * @return Activity|false
	 */
	public function updateActivity(Activity $activity)
	{
		$sql = <<<EOL
UPDATE `Activities`
SET
	`ProjectId` = ?,
	`Name` = ?,
	`Description` = ?,
	`Tags` = ?,
	`Started` = ?,
	`Stopped` = ?
WHERE `ActivityId` = ? ;
EOL;
		$stmt = $this->pdo->prepare($sql);
		$res = $stmt->execute(array(
			$activity->getProjectId(),
			$activity->getName(),
			$activity->getDescription(),
			$activity->getTags(),
			$activity->getStarted(),
			$activity->getStopped(),
			$activity->getActivityId(),
		));

		if ($res === false) {
			return false;
		}

		return $activity;
	}

	/**
	 * Insert new project.
	 * @param Project $project
	 * @return Project|false
	 */
	public function insertProject(Project $project)
	{
		if (empty($project->getCreated) || is_null($project->getCreated())) {
			$project->setCreated(date(self::RFC3339));
		}

		$sql = <<<EOL
INSERT INTO `Projects` (`Name`, `Description`, `Created`)
VALUES (?, ?, ?);
EOL;
		$stmt = $this->pdo->prepare($sql);
		$res = $stmt->execute(array(
			$project->getName(),
			$project->getDescription(),
			$project->getCreated()
		));

		if ($res === false) {
			return false;
		}

		$project->setProjectId($this->pdo->lastInsertId());

		return $project;
	}

	/**
	 * Update project. Valuee of column `Created` will **NOT** be updated.
	 * @param Project $project
	 * @return Project|false
	 */
	public function updateProject(Project $project)
	{
		$sql = <<<EOL
UPDATE `Projects`
SET
	`Name` = ?,
	`Description` = ?
WHERE `ProjectId` = ? ;
EOL;
		$stmt = $this->pdo->prepare($sql);
		$res = $stmt->execute(array(
			$project->getName(),
			$project->getDescription(),
			$project->getCreated()
		));

		if ($res === false) {
			return false;
		}

		return $project;
	}

	/**
	 * Select activities.
	 * @param array $filter
	 * @return array Array of {@see Activity}.
	 */
	public function selectActivity($filter = array())
	{
		// TODO Finish this!
		return array();
	}

	/**
	 * Select projects.
	 * @param array $filter
	 * @return array Array of {@see Project}.
	 */
	public function selectProject($filter = array())
	{
		// TODO Finish this!
		return array();
	}

	/**
	 * Select activities.
	 * @param array $filter
	 * @param array $options
	 * @return integer Count of removed activities.
	 */
	public function removeActivity($filter = array(), $options = array())
	{
		// TODO Finish this!
		return 0;
	}

	/**
	 * Remove projects.
	 * @param array $filter
	 * @param array $options
	 * @return integer Count of removed projects.
	 */
	public function removeProject($filter = array(), $options = array())
	{
		// TODO Finish this!
		return 0;
	}
}
