<?php

/*
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://www.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile Asynchrounous tasks module App controller
 *
 * File version: 1.0
 * Last update: 06/15/2025
 */

namespace z4m_asynctasks\mod\controller;

use \z4m_asynctasks\mod\ScheduledTask;

/**
 * App Controller of the Scheduled tasks
 */
class Z4MAsyncTasksScheduledCtrl extends \AppController {

    /**
     * Evaluates whether action is allowed or not.
     * When authentication is required, action is allowed if connected user has
     * full menu access or if has a profile allowing access to the
     * 'z4m_asynctasks_scheduled' view.
     * The 'trigger' action is allowed when called via HTTP GET method.
     * If no authentication is required, action is allowed if the expected view
     * menu item is declared in the 'menu.php' script of the application.
     * @param string $action Action name
     * @return Boolean TRUE if action is allowed, FALSE otherwise
     */
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        if ($action === 'trigger' && \Request::getMethod() === 'GET') {
            return TRUE; // 'trigger' action executed by webservice (GET method) is allowed
        }
        $menuItem = 'z4m_asynctasks_scheduled';
        return CFG_AUTHENT_REQUIRED === TRUE
            ? \controller\Users::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }

    /**
     * Triggers the execution of the scheduled tasks.
     * No authentication is required when this action is executed as web service
     * (GET method).
     * Example:
     * curl "http://myhost/myapp/?control=Z4MAsyncTasksScheduledCtrl&action=trigger"
     * @return \Response The number of task executed.
     */
    static protected function action_trigger() {
        $method = \Request::getMethod();
        $response = new \Response($method !== 'GET');
        try {
            $message = ScheduledTask::run();
            if ($method === 'GET') {
                $response->setCustomContent($message . PHP_EOL);
            } else {
                $response->setSuccessMessage(NULL, $message);
            }
        } catch (\Exception $e) {
            \General::writeErrorLog(__METHOD__, $e->getMessage());
            $error = 'Scheduled tasks run failed.';
            if ($method === 'GET') {
                $response->setCustomContent($error . PHP_EOL);
            } else {
                $response->setFailedMessage(NULL, $error);
            }
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        return $response;
    }

    /**
     * Returns the scheduled tasks. Expected POST parameters are:
     * - first: the first row number to return (for pagination purpose)
     * - rows: the number of rows to return (for pagination purpose)
     * @return \Response The scheduled tasks rows in JSON format.
     * The returned properties are:
     * - total: The total number of existing rows matching the search criteria
     * if specified. This number is generally greater than the number of rows
     * returned.
     * - rows: an array of objects containing history infos.
     * - success: value true on success, false in case of error.
     */
    static protected function action_all() {
        $request = new \Request();
        $first = $request->first;
        $count = $request->count;
        $rows = [];
        // Success response returned to the main controller
        $response = new \Response();
        $response->total = ScheduledTask::getRows($first, $count, NULL, 'id DESC', $rows);
        $response->rows = $rows;
        $response->success = TRUE;
        return $response;
    }

    /**
     * Returns the requested scheduled task informations.
     * Expected POST parameters are:
     * - id: internal identifier of the scheduled task.
     * @return \Response The scheduled task row found in JSON format.
     * If the requested task does not exist, a warning message is returned in
     * JSON format.
     */
    static protected function action_detail() {
        $request = new \Request();
        $response = new \Response();
        try {
            $task = new ScheduledTask($request->id);
            $response->setResponse($task->getDetail());
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setWarningMessage(NULL, LC_MSG_INF_NO_RESULT_FOUND);
        }
        return $response;
    }

    /**
     * Stores the specified scheduled task.
     * Expected POST parameters are:
     * - id: internal identifier
     * - name: task name
     * - description: task description
     * - statement_to_execute: PHP statement to execute
     * - scheduled_week_days: scheduled week days (comma separated list, 0 to 6)
     * - scheduled_time: Scheduled time (for example '16:35').
     * - next_hours_repetition_count: next hours repetition count (max. 23)
     * - repetition_count_on_error: repetition count on error (0 to 3)
     * - is_enabled: is enabled (1 is enabled)
     * @return \Response A confirmation message in JSON format.
     */
    static protected function action_store() {
        $response = new \Response();
        $task = new ScheduledTask();
        if (!$task->setFromHttpRequest()) {
            $response->setFailedMessage(NULL, $task->getLastErrorMessage(),
                $task->getLastErrorProperty());
            return $response;
        }
        $rowId = $task->store();
        $response->setSuccessMessage(NULL, LC_MSG_INF_SAVE_RECORD . " ID={$rowId}.");
        return $response;
    }

    /**
     * Removes the specified scheduled task.
     * Expected POST parameters are:
     * - id: internal identifier of the scheduled task to remove.
     * @return \Response A confirmation message on success or an error message
     * on error in JSON format.
     */
    static protected function action_remove() {
        $request = new \Request();
        $response = new \Response();
        try {
            $task = new ScheduledTask($request->id);
            $task->remove();
            $response->setSuccessMessage(NULL, LC_MSG_INF_REMOVE_RECORD . " ID={$request->id}.");
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setFailedMessage(NULL, LC_MSG_INF_NO_RESULT_FOUND .  " ID={$request->id}.");
        }
        return $response;
    }
}