<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL https://www.gnu.org/licenses/gpl-3.0.html GNU GPL
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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile Asynchronous tasks Module English translations
 *
 * File version: 1.0
 * Last update: 06/19/2025
 */

define('MOD_Z4M_ASYNCTASKS_PARENT_MENU_LABEL', 'Asynchronous tasks');

// Task lists
define('MOD_Z4M_ASYNCTASKS_LIST_ID_LABEL', 'ID');
define('MOD_Z4M_ASYNCTASKS_LIST_TASK_LABEL', 'Task');
define('MOD_Z4M_ASYNCTASKS_LIST_STATEMENT_LABEL', 'Statement');

// Scheduled task list
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_MENU_LABEL', 'Scheduled tasks');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_SCHEDULING_LABEL', 'Scheduling');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_IS_ENABLED_LABEL', 'Is enabled?');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_YES_LABEL', 'Yes');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_NO_LABEL', 'No');

// Asynchronous task history
define('MOD_Z4M_ASYNCTASKS_HISTORY_MENU_LABEL', 'Task execution history');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_PERIOD', 'Period');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_STATUS_ALL', 'All');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_SUCCESS', 'OK');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_FAILED', 'KO');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_NOTEXECUTED', 'Not executed');
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_CONFIRMATION_TEXT', 'Do you confirm the purge of the history?');
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_BUTTON_LABEL', 'Purge...');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_LINK', 'Delete history...');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_QUESTION', 'Delete task execution history ID=%1?');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_CREATION_DATETIME', 'Added on %1');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_SCHEDULED_TIME', 'Scheduled at %1');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_EXECUTION_LABEL', 'Execution');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REPETITION_LABEL', 'Repetition on error %1/%2');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_IN_ERROR_LABEL', 'Failed task ID = [%1]');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_STATUS_LABEL', 'Status');

// Scheduled task form
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_NEW_LABEL', 'New scheduled task');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_EDIT_LABEL', 'Edit scheduled task ID=');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_REMOVE_LABEL', 'Remove scheduled task ID=');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TASK_NAME_LABEL', 'Task name');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DESCRIPTION_LABEL', 'Description');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LEGEND', 'Scheduled days of week');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LABELS', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LEGEND', 'Scheduled time');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LABEL', 'Start time');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_HOUR_REPETITION_LABEL', 'Number of repetitions in the following hours');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_ERROR_REPETITION_LABEL', 'Repetition count on error');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_LABEL', 'PHP method or function');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_PLACEHOLDER', 'For example: MyClass::myMethod(\'my_value\')');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_IS_ENABLED_LABEL', 'Is task enabled?');

// Scheduled task actions
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_OPENING_PARENTHESIS_ERROR', 'Opening parenthesis is missing.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_CLOSING_PARENTHESIS_ERROR', 'Closing parenthesis is missing.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_FUNCTION_ERROR', 'Function does not exist.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_METHOD_ERROR', 'Method does not exist.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_REPETITION_ERROR', 'You can\'t repeat the task execution on error if the task is already repeated in the following hours.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_EXECUTED_COUNT', 'Number of scheduled task executed: %1.');

// Asynchronous task actions
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_SUCCESS', 'History purge successful.');
