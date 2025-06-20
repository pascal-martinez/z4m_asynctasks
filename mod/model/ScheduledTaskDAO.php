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
 * ZnetDK 4 Mobile Asynchronous tasks module DAO
 * 
 * File version: 1.0
 * Last update: 06/17/2025
 */

namespace z4m_asynctasks\mod\model;

/**
 * DAO to fetch scheduled tasks.
 * SQL table: 'z4m_asynchronous_scheduled_tasks'.
 */
class ScheduledTaskDAO extends \DAO {

    protected function initDaoProperties() {
        $this->table = 'z4m_asynchronous_scheduled_tasks';
        $this->tableAlias = 'scht';
        $todaySQLDateTime = (new \DateTime('now'))->format('Y-m-d 00:00:00');
        $this->query = "SELECT {$this->tableAlias}.*,
            IFNULL(asyt.task_count, 0) AS today_task_run_count,
            IFNULL(asyt.max_scheduled_time, '00:00:00') AS today_max_scheduled_time
            FROM {$this->table} AS {$this->tableAlias}
            LEFT JOIN (SELECT scheduled_task_id, COUNT(*) AS task_count,
                MAX(scheduled_time) AS max_scheduled_time
                FROM z4m_asynchronous_tasks
                WHERE creation_datetime >= '{$todaySQLDateTime}'
                GROUP BY scheduled_task_id
            ) AS asyt ON asyt.scheduled_task_id = {$this->tableAlias}.id";
    }
    
    /**
     * Applies search criteria
     * @param array $criteria Expected keys are 'is_enabled' and 'now'.
     * @return bool Value TRUE if a filter criterium has been applied.
     */
    public function setCriteria($criteria) {
        if (!is_array($criteria)) {
            return FALSE;
        }
        if (key_exists('is_enabled', $criteria) && is_bool($criteria['is_enabled'])) {
            $this->setEnabledAsFilter($criteria['is_enabled']);
        }
        if (key_exists('now', $criteria)) {
            $this->setNowAsFilter($criteria['now']);
        }
        return is_string($this->filterClause);
    }
    
    /**
     * Filters only enabled or disabled tasks
     * @param boolean $isEnabled Value TRUE to get enabled tasks, FALSE
     *  otherwise.
     */
    protected function setEnabledAsFilter($isEnabled) {
        $filter = "{$this->tableAlias}.is_enabled" . ($isEnabled ? ' = ?' : ' IS ?');
        $filterValue = $isEnabled ? 1 : NULL;
        $this->filterClause = ($this->filterClause === FALSE ? 'WHERE ' : $this->filterClause . ' AND ')
                . $filter;
        $this->filterValues []= $filterValue;
    }
    
    /**
     * Filters tasks scheduled the current day and whose scheduled time is
     * earlier than the current time.
     * @param DateTime $now Date time object of the current date and time.
     */
    protected function setNowAsFilter($now) {
        $filter = "{$this->tableAlias}.scheduled_week_days LIKE ?
            AND {$this->tableAlias}.scheduled_time <= ?";        
        $dayOfWeek = intval($now->format('N'))-1;
        $filterValues = ["%{$dayOfWeek}%", $now->format('H:i:00')];
        $this->filterClause = ($this->filterClause === FALSE ? 'WHERE ' : $this->filterClause . ' AND ')
                . $filter;
        $this->filterValues = array_merge($this->filterValues, $filterValues);
        $this->groupByClause = "HAVING {$this->tableAlias}.next_hours_repetition_count+1 > today_task_run_count";
    }

}