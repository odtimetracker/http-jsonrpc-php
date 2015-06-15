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
 * Interface for implementing common storage class.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 */
interface StorageInterface
{
	/**
	 * Get schema version.
	 * @return integer
	 */
	public function getSchemaVersion();

	/**
	 * Create storage schema.
	 */
	public function createSchema();

	/**
	 * Clear all data from the storage.
	 */
	public function emptyStorage();

	/**
	 * Retrieve currently running activity.
	 * @return Activity|null
	 */
	public function getRunningActivity();

	/**
	 * Start new activity.
	 * @param integer $projectId
	 * @param string $name
	 * @param string $description
	 * @param string $tags
	 */
	public function startActivity($projectId, $name, $description = null, $tags = null);

	/**
	 * Stop currently running activity (if there is any).
	 * Return:
	 * - stopped activity
	 * - `NULL` if there was no running activity
	 * - `false` when updating (e.g. stopping) activity in database failed.
	 * @return Activity|boolean|null 
	 */
	public function stopActivity();

	/**
	 * Update activity.
	 * @param Activity $activity
	 * @return Activity
	 */
	public function updateActivity(Activity $activity);

	/**
	 * Insert new project.
	 * @param Project $project
	 * @return Project
	 */
	public function insertProject(Project $project);

	/**
	 * Update project.
	 * @param Project $project
	 * @return Project
	 */
	public function updateProject(Project $project);
}
