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
 * DAO to fetch all registered asynchronous tasks.
 * SQL table: 'z4m_asynchronous_tasks'
 */
class AsynchronousTaskDAO extends \DAO {

    protected function initDaoProperties() {
        $this->table = 'z4m_asynchronous_tasks';
        $this->setDateColumns('creation_datetime', 'execution_datetime');
    }
    
    /**
     * Sets the row filter criteria 
     * @param array $criteria Expected keys are 'not_executed', 'only_scheduled'
     * 'not_scheduled', 'start', 'end' and 'status'.
     */
    public function setCriteria($criteria) {
        if (!is_array($criteria)) {
            return;
        }
        if (key_exists('not_executed', $criteria) && $criteria['not_executed'] === TRUE) {
            $this->setNotExecutedAsFilter();
        }
        if (key_exists('only_scheduled', $criteria) && $criteria['only_scheduled'] === TRUE) {
            $this->setOnlyScheduledAsFilter();
        }
        if (key_exists('not_scheduled', $criteria) && $criteria['not_scheduled'] === TRUE) {
            $this->setNotScheduledAsFilter();
        }
        if (key_exists('start', $criteria) && is_string($criteria['start'])) {
            $this->setStartDateAsFilter($criteria['start']);
        }
        if (key_exists('end', $criteria) && is_string($criteria['end'])) {
            $this->setEndDateAsFilter($criteria['end']);
        }
        if (key_exists('status', $criteria) && $criteria['status'] > -2
                && $criteria['status'] < 2) {
            $this->setStatusAsFilter($criteria['status']);
        }
    }
    
    /**
     * Filters tasks not yet executed.
     */
    protected function setNotExecutedAsFilter() {
        $filter = "creation_datetime > ? AND status IS ?";
        $this->filterClause = $this->filterClause === FALSE 
                ? "WHERE $filter" : "{$this->filterClause} AND {$filter}";
        $yesterdayDateTime = new \DateTime('now');
        $yesterdayDateTime->sub(new \DateInterval('P1D'));
        $this->filterValues = array_merge($this->filterValues, [
            $yesterdayDateTime->format('Y-m-d 00:00:00'), NULL
        ]);        
    }
    
    /**
     * Filters scheduled tasks only
     */
    protected function setOnlyScheduledAsFilter() {
        $filter = "scheduled_task_id IS NOT ?";
        $this->filterClause = $this->filterClause === FALSE 
                ? "WHERE $filter" : "{$this->filterClause} AND {$filter}";        
        $this->filterValues []= NULL;
    }
    
    /**
     * Filters tasks that are not scheduled
     */
    protected function setNotScheduledAsFilter() {
        $filter = "scheduled_task_id IS ?";
        $this->filterClause = $this->filterClause === FALSE 
                ? "WHERE $filter" : "{$this->filterClause} AND {$filter}";        
        $this->filterValues []= NULL;
    }
    
    /**
     * Filters tasks created after the specified date
     * @param string $start W3C start date
     */
    protected function setStartDateAsFilter($start) {
        $filter = "creation_datetime >= ?";
        $this->filterClause = $this->filterClause === FALSE 
                ? "WHERE $filter" : "{$this->filterClause} AND {$filter}";
        $this->filterValues[] = $start . ' 00:00:00';
    }
    
    /**
     * Filters tasks created until the specified date
     * @param string $end W3C end date
     */
    protected function setEndDateAsFilter($end) {
        $filter = "creation_datetime <= ?";
        $this->filterClause = $this->filterClause === FALSE 
                ? "WHERE $filter" : "{$this->filterClause} AND {$filter}";
        $this->filterValues[] = $end . ' 23:59:59';
    }
    
    /**
     * Sets the status code as filter.
     * @param string $status Status code ('-1' not executed, '0' KO, '1' OK).
     */
    protected function setStatusAsFilter($status) {
        $filter = $status === '-1' ? "status IS ?" : "status = ?";
        $value = $status === '-1' ? NULL : $status;
        $this->filterClause = $this->filterClause === FALSE 
                ? "WHERE $filter" : "{$this->filterClause} AND {$filter}";
        $this->filterValues[] = $value;
    }

}