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
	 * Return `TRUE` if there is a running activity.
	 * @return boolean
	 */
	public function isRunningActivity();

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
	public function startActivity($projectId, $name, $description = null, $tags = null);

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
	public function stopActivity();

	/**
	 * Update activity.
	 * @param Activity $activity
	 * @return Activity|false
	 */
	public function updateActivity(Activity $activity);

	/**
	 * Insert new project.
	 * @param Project $project
	 * @return Project|false
	 */
	public function insertProject(Project $project);

	/**
	 * Update project.
	 * @param Project $project
	 * @return Project|false
	 */
	public function updateProject(Project $project);

	/**
	 * Select activities.
	 * @param array $filter
	 * @return array Array of {@see Activity}.
	 */
	public function selectActivity($filter = array());

	/**
	 * Select projects.
	 * @param array $filter
	 * @return array Array of {@see Project}.
	 */
	public function selectProject($filter = array());

	/**
	 * Select activities.
	 * @param array $filter
	 * @param array $options
	 * @return integer Count of removed activities.
	 */
	public function removeActivity($filter = array(), $options = array());

	/**
	 * Remove projects.
	 * @param array $filter
	 * @param array $options
	 * @return integer Count of removed projects.
	 */
	public function removeProject($filter = array(), $options = array());
}
