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
 * ZnetDK 4 Mobile Asynchrounous tasks module validator
 * 
 * File version: 1.0
 * Last update: 06/15/2025
 */


namespace z4m_asynctasks\mod\validator;

use \z4m_asynctasks\mod\AsynchronousTask;

class ScheduledTaskValidator extends \Validator {
    
    protected function initVariables() {
        return ['id', 'name', 'statement_to_execute', 'scheduled_week_days',
            'scheduled_time', 'next_hours_repetition_count',
            'repetition_count_on_error', 'is_enabled'];
    }
    
    /**
     * Scheduled task ID when specified must match an existing task in database.
     * @param int $value Internal identifier
     * @return bool Value TRUE if is NULL or identifier matches an existing task
     */
    protected function check_id($value) {
        if (!is_null($value)) {
            $dao = new \z4m_asynctasks\mod\model\ScheduledTaskDAO();
            if ($dao->getById($value) === FALSE) {
                $this->setErrorMessage(LC_MSG_INF_NO_RESULT_FOUND);
                $this->setErrorVariable(NULL);
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Task name is required and has a max length of 30 characters.
     * @param string $value Task name.
     * @return bool Value TRUE if name is valid.
     */
    protected function check_name($value) {
        if (is_null($value)) {
            $this->setErrorMessage(LC_MSG_ERR_MISSING_VALUE);
            return FALSE;
        }
        if (!is_null($value) && strlen($value) > 50) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_BADLENGTH);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * PHP function or method to execute for the task.
     * @param string $value The method or function name with its arguments.
     * @return bool Value TRUE if function or method exists.
     */
    protected function check_statement_to_execute($value) {
        if (is_null($value)) {
            $this->setErrorMessage(LC_MSG_ERR_MISSING_VALUE);
            return FALSE;
        }
        try {
            AsynchronousTask::getStatementNameAndValues($value);
        } catch (\Exception $ex) {
            $this->setErrorMessage($ex->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Week days are required.
     * @param array $value The week days from '0' (Monday) to '6' (Sunday).
     * @return bool TRUE if at least one week day is specified and the week days
     * are a digit between 0 and 6.
     */
    protected function check_scheduled_week_days($value) {
        if (!is_array($value) || count($value) === 0) {
            $this->setErrorMessage(LC_MSG_ERR_MISSING_VALUE);
            $this->setErrorVariable('scheduled_week_days[]');
            return FALSE;
        }
        foreach ($value as $dayNbr) {
            if ($dayNbr < 0 || $dayNbr > 6) {
                $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
                return FALSE;
            }    
        }
        return TRUE;
    }

    /**
     * Scheduled time is required
     * @param string $value For example '15:46'.
     * @return bool Value TRUE if time format is valid.
     */
    protected function check_scheduled_time($value) {
        if (is_null($value)) {
            $this->setErrorMessage(LC_MSG_ERR_MISSING_VALUE);
            return FALSE;
        }
        if (!in_array(strlen($value), [5,8])) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_BADLENGTH);
            return FALSE;
        }
        if (!preg_match('#^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$#', $value)) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Repetition the next hours is mandatory (0 or higher)
     * @param string $value Value '0' or more (max '23').
     * @return bool Value TRUE if is valid, FALSE otherwise.
     */
    protected function check_next_hours_repetition_count($value) {
        if (is_null($value)) {
            $this->setErrorMessage(LC_MSG_ERR_MISSING_VALUE);
            return FALSE;
        }
        if (!is_numeric($value)) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }        
        $maxValue = 23 - intval($this->getValue('scheduled_time'));
        if ($value < 0 || $value > $maxValue) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Number of times the task is executed on error is required and is between
     * '0' and '3'.
     * @param string $value Value between '0' and '3'.
     * @return bool TRUE if value is valid. If a value higher than '0' is set
     * for the 'next_hours_repetition_count' property then returns FALSE.
     */
    protected function check_repetition_count_on_error($value) {
        if (is_null($value)) {
            $this->setErrorMessage(LC_MSG_ERR_MISSING_VALUE);
            return FALSE;
        }
        if (!is_numeric($value)) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        if ($this->getValue('next_hours_repetition_count') > 0 && $value > 0) {
            $this->setErrorMessage(MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_REPETITION_ERROR);
            return FALSE;
        }
        if ($value < 0 || $value > 3) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Is enabled, expected value is '1' or NULL
     * @param string $value '1' or NULL
     * @return bool TRUE if value is valid.
     */
    protected function check_is_enabled($value) {
        if (!is_null($value) && $value !== '1') {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        return TRUE;
    }

}