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
WHERE `Created` IS NULL ;
EOT;
		$stmt = $this->pdo->query($sql, \PDO::FETCH_ASSOC);
		if ($stmt === false) {
			return null;
		}

		$data = $stmt->fetch();

		return new Activity(
			$data['ActivityId'],
			$data['ProjectId'],
			$data['Name'],
			$data['Description'],
			$data['Tags'],
			$data['Started'],
			$data['Stopped']
		);
	}

	/**
	 * Start new activity. If other activity is already running return `FALSE`
	 * and no new activity is inserted into the database.
	 * @param integer $projectId
	 * @param string $name
	 * @param string $description
	 * @param string $tags
	 * @return Activity|boolean
	 */
	public function startActivity($projectId, $name, $description = null, $tags = null)
	{
		$activity = $this->getRunningActivity();
		if ($activity instanceof Activity) {
			return false;
		}

		$sql = <<<EOL
INSERT INTO `Activities` (`ProjectId`, `Name`, `Description`, `Tags`, `Started`)
VALUES (?, ?, ?, ?, ?);
EOL;
		$stmt = $this->pdo->prepare($sql);
		$res = $stmt->execute(array($projectId, $name, $description, $tags));

		if ($res === false) {
			// TODO Throw error?
		} else {
			$activity->setActivityId($this->pdo->lastInsertId());
		}

		return $activity;
	}

	/**
	 * Stop currently running activity (if there is any).
	 *
	 * Return:
	 * <ul>
	 * <li>stopped activity</li>
	 * <li>`NULL` if there was no running activity</li>
	 * <li>`false` when updating (e.g. stopping) activity in database failed.</li>
	 * </ul>
	 * @return Activity|boolean|null
	 */
	public function stopActivity()
	{
		$activity = $this->getRunningActivity();
		if (is_null($activity)) {
			return null;
		}

		$activity->setStopped(date('Y-m-d\TH:i:sO'));

		return $this->updateActivity($activity);
	}

	/**
	 * Update activity.
	 * @param Activity $activity
	 * @return Activity
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
			// TODO Throw error?
		}

		return $activity;
	}

	/**
	 * Insert new project.
	 * @param Project $project
	 * @return Project
	 */
	public function insertProject(Project $project)
	{
		if (empty($project->getCreated) || is_null($project->getCreated())) {
			$project->setCreated(date('Y-m-d\TH:i:sO'));
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
			// TODO Throw error?
		} else {
			$project->setProjectId($this->pdo->lastInsertId());
		}

		return $project;
	}

	/**
	 * Update project. Valuee of column `Created` will **NOT** be updated.
	 * @param Project $project
	 * @return Project
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
			// TODO Throw error?
		}

		return $project;
	}
}
