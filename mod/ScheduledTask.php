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
 * Last update: 06/17/2025
 */

namespace z4m_asynctasks\mod;

use \z4m_asynctasks\mod\model\ScheduledTaskDAO;
use \z4m_asynctasks\mod\validator\ScheduledTaskValidator;

/**
 * Manage asynchronous tasks
 */
class ScheduledTask {

    protected $data = NULL;
    protected $lastErrorMessage;
    protected $lastErrorProperty;

    /**
     * Constructs a new scheduled task object.
     * @param int|NULL $scheduledTaskId Optional, scheduled task identifier.
     */
    public function __construct($scheduledTaskId = NULL) {
        $this->data = ['id' => $scheduledTaskId];
        $this->fetchData();
        $this->lastErrorMessage = NULL;
        $this->lastErrorProperty = NULL;
    }

    /**
     * Fetches task data in database.
     * @throws \Exception No task found for the row ID specified via the class
     * constructor.
     */
    protected function fetchData() {
        if (is_null($this->data['id'])) {
            return;
        }
        $dao = new ScheduledTaskDAO();
        $row = $dao->getById($this->data['id']);
        if (is_array($row)) {
            $row['scheduled_week_days[]'] = explode(',', $row['scheduled_week_days']);
            $row['scheduled_time'] = substr($row['scheduled_time'], 0, 5);
            $this->data = $row;
        } else {
            throw new \Exception("No scheduled task found for ID={$this->data['id']}.");
        }
    }

    /**
     * Returns the scheduled task informations.
     * @return array The scheduled task informations
     */
    public function getDetail() {
        return $this->data;
    }

    /**
     * Sets the scheduled task data from the HTTP request
     * @return boolean TRUE on success, FALSE otherwise.
     */
    public function setFromHttpRequest() {
        $this->lastErrorMessage = NULL;
        $this->lastErrorProperty = NULL;
        $validator = new ScheduledTaskValidator();
        $validator->setCheckingMissingValues();
        if (!$validator->validate()) {
            $this->lastErrorMessage = $validator->getErrorMessage();
            $this->lastErrorProperty = $validator->getErrorVariable();
            return FALSE;
        }
        $request = new \Request();
        $formData = $request->getValuesAsMap('id', 'name', 'description',
            'statement_to_execute', 'scheduled_time', 'next_hours_repetition_count',
            'repetition_count_on_error', 'is_enabled');
        $formData['scheduled_week_days'] = implode(',', $request->scheduled_week_days);
        $this->data = $formData;
        return TRUE;
    }

    /**
     * Returns the last error message
     * @return string|NULL the last error message or NULL if no error
     */
    public function getLastErrorMessage() {
        return $this->lastErrorMessage;
    }

    /**
     * Returns the last property in error
     * @return string|NULL the last property name in error or NULL if no error
     */
    public function getLastErrorProperty() {
        return $this->lastErrorProperty;
    }

    /**
     * Stores the scheduled task data
     * @return int Database row ID of the stored task.
     */
    public function store() {
        $dao = new ScheduledTaskDAO();
        return $dao->store($this->data);
    }

    /**
     * Removes the scheduled task.
     * @return int The number of rows removed.
     * @throws \Exception The row ID is not specified for the object.
     */
    public function remove() {
        if (is_null($this->data['id'])) {
            throw new \Exception('Not row ID set for the scheduled task to remove.');
        }
        $dao = new ScheduledTaskDAO();
        return $dao->remove($this->data['id']);
    }

    /**
     * Executes the scheduled tasks.
     * Only tasks scheduled for the current day and at a time greater or equal
     * to the current time are executed.
     * @return string Message indicating the number of scheduled tasks executed.
     */
    static public function run() {
        $now = new \DateTime('now');
        $currentTime = ($now)->format('H:i');
        $tasks = [];
        self::getRows(NULL, NULL, [
            'is_enabled' => TRUE,
            'now' => $now
        ], 'id', $tasks);
        foreach ($tasks as $task) {
            $scheduledTime = self::calculateNextTime($task['scheduled_time'],
                $task['next_hours_repetition_count'], $task['today_task_run_count'],
                    $currentTime, $task['today_max_scheduled_time']);
            if ($scheduledTime !== FALSE) {
                AsynchronousTask::add($task['name'], $task['statement_to_execute'],
                    $task['repetition_count_on_error'], $task['id'], $scheduledTime);
            }
        }
        $runOption = MOD_Z4M_ASYNCTASKS_TRIGGER_SCHEDULED_ONLY === TRUE
                ? 'only_scheduled' : 'all';
        $count = AsynchronousTask::runAll($runOption);
        return \General::getFilledMessage(MOD_Z4M_ASYNCTASKS_SCHEDULED_EXECUTED_COUNT, $count);
    }

    static public function getRows($first, $count, $searchCriteria, $sortCriteria, &$rows) {
        $dao = new ScheduledTaskDAO();
        AsynchronousTask::createModuleSqlTable($dao);
        $dao->setCriteria($searchCriteria);
        $dao->setSortCriteria($sortCriteria);
        $total = $dao->getCount();
        if (!is_null($first) && !is_null($count)) {
            $dao->setLimit($first, $count);
        }
        while ($row = $dao->getResult()) {
            $row['scheduled_week_days_display'] = implode(', ', array_map(function($dayNbr){
                return MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LABELS[$dayNbr];
            }, explode(',', $row['scheduled_week_days'])));
            $row['scheduled_time'] = substr($row['scheduled_time'], 0, 5);
            $row['scheduled_end_time'] = self::calculateEndTime($row['scheduled_time'],
                    $row['next_hours_repetition_count']);
            $rows[] = $row;
        }
        return $total;
    }

    /**
     * Calculates end time from a start time and its repetition count.
     * @param string $startTime Start time (for example '13:45:00').
     * @param string $repetitionCount Repetition count (zero or more)
     * @return string The calculated end time: for example '15:45' if start time
     * is '13:45' and repetition count is 2.
     */
    static protected function calculateEndTime($startTime, $repetitionCount) {
        if ($repetitionCount === '0') {
            return $startTime;
        }
        $endTime = new \DateTime();
        $endTime->setTime(intval(substr($startTime, 0, 2)), intval(substr($startTime, 3, 2)));
        $endTime->add(new \DateInterval("PT{$repetitionCount}H"));
        return $endTime->format('H:i');
    }
    
    /**
     * Calculates next time from a start time and its maximum repetition count,
     * the current repetition count and the current time.
     * 
     * @param string $startTime Start time (for example '13:45:00').
     * @param string $maxRepetitionCount Maximum repetition count (zero or more)
     * @param string $todayTaskRunCount Number of times the task has been executed
     * today (zero or more).
     * @param string $currentTime The current time.
     * @param string $todayMaxScheduledTime Today max scheduled time
     * @return string The calculated next time or FALSE if no task execution is
     * needed.
     */
    static protected function calculateNextTime($startTime, $maxRepetitionCount, $todayTaskRunCount,
            $currentTime, $todayMaxScheduledTime) {
        if ($maxRepetitionCount === '0') {
            return $startTime; // First and last execution
        }
        $shortTodayMaxScheduledTime = substr($todayMaxScheduledTime, 0, 5);
        $maxEndTime = self::calculateEndTime($startTime, $maxRepetitionCount);
        if ($currentTime >= $maxEndTime) {
            return $shortTodayMaxScheduledTime < $maxEndTime
                ? $maxEndTime // Last execution
                : FALSE; // No execution
        }
        //Before max end time
        $nextRunTime = self::calculateEndTime($startTime, $todayTaskRunCount);
        $nextHourTime = $nextRunTime;
        $hourCounter = 0;
        while ($currentTime > $nextHourTime) {
            $hourCounter++;
            $nextRunTime = $nextHourTime;
            $nextHourTime = self::calculateEndTime($startTime, $todayTaskRunCount + $hourCounter);
        }
        return $hourCounter > 0 
                && $nextRunTime > $shortTodayMaxScheduledTime
                && $nextRunTime <= $maxEndTime
            ? $nextRunTime // Execution allowed
            : FALSE; // No execution needed
    }

}