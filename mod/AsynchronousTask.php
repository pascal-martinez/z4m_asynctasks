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
 * ZnetDK 4 Mobile Asynchronous tasks module Manager class
 *
 * File version: 1.0
 * Last update: 06/19/2025
 */

namespace z4m_asynctasks\mod;

/**
 * Manage asynchronous tasks
 */
class AsynchronousTask {

    /**
     * Adds an asynchronous task to execute.
     * @param string $name Task name
     * @param string $statement Statement to execute.
     * @param int $repetitionCountOnError Number of times the task should be
     * executed in case of error.
     * @param int|NULL $scheduledTaskId Optional, identifier of the
     * corresponding scheduled task.
     * @param string|NULL $scheduledTaskTime Optional, scheduled time of the
     * corresponding scheduled task.
     * @return Identifier of the asynchronous task stored in database.
     * @throws \Exception Scheduled tasked specified and not the scheduled time
     * or vice-versa.
     */
    static public function add($name, $statement, $repetitionCountOnError = 0, $scheduledTaskId = NULL, $scheduledTaskTime = NULL) {
        if ((is_null($scheduledTaskId) && !is_null($scheduledTaskTime))
                || (!is_null($scheduledTaskId) && is_null($scheduledTaskTime))) {
            throw new \Exception('Invalid scheduled task argument.');
        }
        self::getStatementNameAndValues($statement);
        $dao = new model\AsynchronousTaskDAO();
        self::createModuleSqlTable($dao);
        return $dao->store([
            'creation_datetime' => \General::getCurrentW3CDate(TRUE),
            'name' => $name,
            'scheduled_task_id' => $scheduledTaskId,
            'scheduled_time' => $scheduledTaskTime,
            'statement_to_execute' => $statement,
            'repetition_count_on_error' => $repetitionCountOnError,
            'execution_count_after_error' => 0
        ]);
    }
    
    /**
     * Removes the specified task
     * @param string $taskId Identifier of the task to remove.
     * @return int Number of tasks removed.
     */
    static public function remove($taskId) {
        $dao = new model\AsynchronousTaskDAO();
        return $dao->remove($taskId);
    }

    /**
     * Extracts from the specified statement the function or method name and the
     * argument values.
     * @param string $statement The statement to process.
     * @return array The function or method name and the argument values.
     * @throws \Exception Missing opening or closing parenthesis, function or
     * method is unknown.
     */
    static public function getStatementNameAndValues($statement) {
        $valStartPos = strpos($statement, '(');
        if ($valStartPos === FALSE) {
            throw new \Exception(MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_OPENING_PARENTHESIS_ERROR);
        }
        $valEndPos = strpos($statement, ')', $valStartPos);
        if ($valEndPos === FALSE) {
            throw new \Exception(MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_CLOSING_PARENTHESIS_ERROR);
        }
        $functionName = substr($statement, 0, $valStartPos);
        $isFunction = strpos($functionName, '::') === FALSE;
        if ($isFunction && !function_exists($functionName)) {
            throw new \Exception(MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_FUNCTION_ERROR);
        } elseif (!$isFunction && !method_exists(explode('::', $functionName)[0],
                explode('::', $functionName)[1])) {
            throw new \Exception(MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_METHOD_ERROR);
        }
        $values = substr($statement, $valStartPos + 1, $valEndPos - $valStartPos - 1);
        $strValues = $values === '' ? [] : explode(',', $values);
        $typedValues = [];
        foreach ($strValues as $strValue) {
            $typedValues []= self::convertStringToTypedValue($strValue);
        }
        return [$functionName, $typedValues];
    }

    /**
     * Convert a string value to a typed value.
     * If the string value is rounded by single or double quotes, it is returned
     * as string value without quotes.
     * if the value is true or false (in lowercase or uppercase), a boolean
     * value is returned.
     * Otherwise an interger of float value is returned.
     * @param string $strValue The string value.
     * @return mixed The typed value.
     */
    static protected function convertStringToTypedValue($strValue) {
        $count = 0;
        $withoutQuotes = str_replace(['"', "'"], ['', ''], trim($strValue), $count);
        if ($count > 0) {
            return $withoutQuotes; // Type is string
        }
        if (in_array(strtolower($withoutQuotes), ['true', 'false'])) {
            return strtolower($withoutQuotes) === 'true';
        }
        return strpos($withoutQuotes, '.') !== FALSE ? floatval($withoutQuotes) : intval($withoutQuotes);
    }

    /**
     * Executes the specified task statement
     * @param string $statement The statement to execute.
     * @return array The execution status code (0 failed, 1 success) and the
     * message returned by the statement.
     */
    static protected function executeStatement($statement) {
        try {
            list($function, $args) = self::getStatementNameAndValues($statement);
            $message = call_user_func_array($function, $args);
        } catch (\Exception $ex) {
            return [0, $ex->getMessage()];
        }
        return [1, $message];
    }

    /**
     * Runs the specified task.
     * @param array $task Task informations
     */
    static protected function run($task) {
        $execDateTime = \General::getCurrentW3CDate(TRUE);
        list($status, $message) = self::executeStatement($task['statement_to_execute']);
        $dao = new model\AsynchronousTaskDAO();
        $dao->store([
            'id' => $task['id'],
            'execution_datetime' => $execDateTime,
            'status' => $status,
            'execution_message' => $message
        ]);
        return $status;
    }

    /**
     * Adds a new task from a task whose task execution has failed.
     * The new task is only created if the task in error is configured to rerun
     * on error.
     * @param array $taskInError Informations of the task in error
     * @return boolean|int Returns TRUE if no task needs to be recreated on
     * error. Returns FALSE if a new task need to be recreated but its
     * registration has failed.
     * Finally returns the identifier of the new task.
     */
    static protected function addNewOnError($taskInError) {
        if ($taskInError['repetition_count_on_error'] === '0' ||
                $taskInError['execution_count_after_error'] === $taskInError['repetition_count_on_error']) {
            return TRUE;
        }
        $newTask = array_intersect_key($taskInError, array_flip(['name', 'statement_to_execute', 'repetition_count_on_error']));
        $newTask['creation_datetime'] = \General::getCurrentW3CDate(TRUE);
        $newTask['scheduled_task_id'] = empty($taskInError['scheduled_task_id']) ? NULL : $taskInError['scheduled_task_id'];
        $newTask['scheduled_time'] = empty($taskInError['scheduled_time']) ? NULL : $taskInError['scheduled_time'];
        $newTask['previous_failed_task_id'] = $taskInError['id'];
        $newTask['execution_count_after_error'] = $taskInError['execution_count_after_error'] + 1;
        $dao = new model\AsynchronousTaskDAO();
        try {
            return $dao->store($newTask);
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, "Unable to recreate the task in error ID={$taskInError['id']}. Cause: "
                . $ex->getMessage());
        }
        return FALSE;
    }


    /**
     * Runs all the tasks that are not yet executed.
     * If a task execution fails, the task is recreated if it is configured to
     * rerun on error.
     * @param string $filter Filter to run only scheduled tasks
     * ('only_scheduled'), only not scheduled tasks ('not_scheduled') or all
     * tasks ('all', default value).
     * @return int Number of tasks executed.
     */
    static public function runAll($filter = 'all') {
        $tasks = [];
        $appliedFilter = ['not_executed' => TRUE];
        if ($filter !== 'all') {
            $appliedFilter[$filter] = TRUE;
        }
        self::getRows(NULL, NULL, $appliedFilter, 'id', $tasks);
        foreach ($tasks as $task) {
            if (self::run($task) === 0) {
                self::addNewOnError($task);
            }
        }
        return count($tasks);
    }
    
    /**
     * Runs the specified task by its identifier.
     * @param string $taskId The identifier of the task to execute
     * @return bool TRUE on success, FALSE or the new task ID on error.
     * @throws \Exception No task found for the specified ID or the task has
     * already been executed or the on error task creation has failed.
     */
    static public function runOne($taskId) {
        $dao = new model\AsynchronousTaskDAO();
        $task = $dao->getById($taskId);
        if (!is_array($task)) {
            throw new \Exception("No task found for ID={$taskId}");
        }
        if ($task['status'] !== '') {
            throw new \Exception("The task with ID={$taskId} has already been executed.");
        }
        if (self::run($task) === 0) {
            $newTaskId = self::addNewOnError($task);
            if ($newTaskId === FALSE) {
                throw new \Exception("Unable to recreate a task on error.");
            }
            return $newTaskId === TRUE ? FALSE : $newTaskId;
        }
        return TRUE;
    }


    /**
     * Returns the history rows.
     * @param int|NULL $first First row to select or NULL to select all.
     * @param int|NULL $count Maximum number of rows to select or NULL to select
     * all.
     * @param array|NULL $searchCriteria Search criteria ('start', 'end',
     * 'status' and '') or NULL if no criteria are applied.
     * @param string $sortCriteria Sorted columns (ORDER BY clause).
     * @param array $rows An array to fill with the found rows.
     * @return int Total number of found rows (can be greater than the number of
     * returned rows if the $first and $count arguments are filled in.
     */
    static public function getRows($first, $count, $searchCriteria, $sortCriteria, &$rows) {
        $dao = new model\AsynchronousTaskDAO();
        self::createModuleSqlTable($dao);
        if (is_array($searchCriteria)) {
            $dao->setCriteria($searchCriteria);
        }
        $dao->setSortCriteria($sortCriteria);
        $total = $dao->getCount();
        if (!is_null($first) && !is_null($count)) {
            $dao->setLimit($first, $count);
        }
        while ($row = $dao->getResult()) {
            $row['creation_task_infos'] = \General::getFilledMessage(MOD_Z4M_ASYNCTASKS_HISTORY_LIST_CREATION_DATETIME,
                    $row['creation_datetime_locale']);
            $row['scheduled_task_infos'] = !empty($row['scheduled_time']) ?
                \General::getFilledMessage(MOD_Z4M_ASYNCTASKS_HISTORY_LIST_SCHEDULED_TIME,
                        substr($row['scheduled_time'], 0, 5)) : '';
            $row['task_repetition_infos'] = !empty($row['previous_failed_task_id']) ?
                \General::getFilledMessage(MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REPETITION_LABEL,
                        $row['execution_count_after_error'], $row['repetition_count_on_error']) : '';
            $row['failed_task_infos'] = !empty($row['previous_failed_task_id']) ?
                \General::getFilledMessage(MOD_Z4M_ASYNCTASKS_HISTORY_LIST_IN_ERROR_LABEL,
                        $row['previous_failed_task_id']) : '';
            $rows[] = $row;
        }
        return $total;
    }

    /**
     * Purge history rows. If search criteria are set, only the matching rows
     * are removed.
     * History rows of the current day are not removed since they are required
     * to the scheduled task execution.
     * @param array $searchCriteria Filter criteria. Expected keys are 'status',
     * 'start_date' and 'end_date'.
     * @return int The number of rows removed
     */
    static public function purge($searchCriteria) {
        $dao = new model\AsynchronousTaskDAO();
        $endDateTime = new \DateTime('now');
        $endDateTime->sub(new \DateInterval('P1D'));
        $endDate = $endDateTime->format('Y-m-d');
        $defaultStartDate = '2020-01-01';
        if (!is_array($searchCriteria)) {
            $dao->setCriteria(['start' => $defaultStartDate, 'end' => $endDate]);
        } else {
            if (!key_exists('end', $searchCriteria) || $searchCriteria['end'] > $endDate) {
                $searchCriteria['end'] = $endDate;
            }
            if (!key_exists('start', $searchCriteria)) {
                $searchCriteria['start'] = $defaultStartDate;
            }
            $dao->setCriteria($searchCriteria);
        }
        $dao->setSortCriteria('id DESC');
        $idsToRemove = [];
        while ($row = $dao->getResult()) {
            $idsToRemove[] = $row['id'];
        }
        $removeCount = 0;
        foreach ($idsToRemove as $rowId) {
            $removeCount += $dao->remove($rowId);
        }
        return $removeCount;
    }
    
    /**
     * Create the SQL tables required for the module.
     * The tables are created from the SQL script defined via the
     * MOD_Z4M_ASYNCTASKS_SQL_SCRIPT_PATH constant.
     * @param DAO $dao DAO for which existence is checked
     * @throws \Exception SQL script is missing and SQL table creation failed.
     */
    static public function createModuleSqlTable($dao) {
        if ($dao->doesTableExist()) {
            return;
        }
        if (!file_exists(MOD_Z4M_ASYNCTASKS_SQL_SCRIPT_PATH)) {
            $error = "SQL script '" . MOD_Z4M_ASYNCTASKS_SQL_SCRIPT_PATH . "' is missing.";
            throw new \Exception($error);
        }
        $sqlScript = file_get_contents(MOD_Z4M_ASYNCTASKS_SQL_SCRIPT_PATH);
        $db = \Database::getApplDbConnection();
        try {
            $db->exec($sqlScript);
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            throw new \Exception("Error executing 'z4m_asynctasks' module SQL script.");
        }

    }

}
