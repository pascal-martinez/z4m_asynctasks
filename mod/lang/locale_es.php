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
 * ZnetDK 4 Mobile Asynchronous tasks Module Spanish translations
 *
 * File version: 1.0
 * Last update: 06/19/2025
 */

define('MOD_Z4M_ASYNCTASKS_PARENT_MENU_LABEL', 'Tareas asincrónicas');

// Task lists
define('MOD_Z4M_ASYNCTASKS_LIST_ID_LABEL', 'ID');
define('MOD_Z4M_ASYNCTASKS_LIST_TASK_LABEL', 'Tarea');
define('MOD_Z4M_ASYNCTASKS_LIST_STATEMENT_LABEL', 'Instrucción');

// Scheduled task list
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_MENU_LABEL', 'Tareas programadas');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_SCHEDULING_LABEL', 'Programación');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_IS_ENABLED_LABEL', '¿Está activado?');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_YES_LABEL', 'Sí');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_NO_LABEL', 'No');

// Asynchronous task history
define('MOD_Z4M_ASYNCTASKS_HISTORY_MENU_LABEL', 'Historial de tareas');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_PERIOD', 'Período');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_STATUS_ALL', 'Todas');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_SUCCESS', 'OK');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_FAILED', 'KO');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_NOTEXECUTED', 'En espera');
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_CONFIRMATION_TEXT', '¿Confirmas la purga de la historia?');
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_BUTTON_LABEL', 'Purgar...');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_LINK', 'Eliminar el historial...');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_QUESTION', '¿Eliminar el historial de la tarea ID = %1?');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_CREATION_DATETIME', 'Añadido el %1');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_SCHEDULED_TIME', 'Programado a %1');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_EXECUTION_LABEL', 'Ejecución');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REPETITION_LABEL', 'Repetición en caso de error %1/%2');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_IN_ERROR_LABEL', 'Tarea fallida ID = [%1]');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_STATUS_LABEL', 'Estado');

// Scheduled task form
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_NEW_LABEL', 'Nueva tarea programada');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_EDIT_LABEL', 'Editar tarea programada ID=');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_REMOVE_LABEL', 'Eliminar tarea programada ID=');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TASK_NAME_LABEL', 'Nombre de la tarea');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DESCRIPTION_LABEL', 'Descripción');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LEGEND', 'Días de la semana programados');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LABELS', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']);
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LEGEND', 'Hora programada');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LABEL', 'Hora de inicio');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_HOUR_REPETITION_LABEL', 'Conteo de repeticiones en horas posteriores');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_ERROR_REPETITION_LABEL', 'Conteo de repeticiones en caso de error');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_LABEL', 'Método o función PHP');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_PLACEHOLDER', 'Por ejemplo: MyClass::myMethod(\'my_value\')');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_IS_ENABLED_LABEL', '¿La tarea está activada?');

// Scheduled task actions
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_OPENING_PARENTHESIS_ERROR', 'Falta el paréntesis de apertura.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_CLOSING_PARENTHESIS_ERROR', 'Falta el paréntesis de cierre.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_FUNCTION_ERROR', 'La función no existe.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_METHOD_ERROR', 'El método no existe.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_REPETITION_ERROR', 'No se permite repetir la tarea en caso de error si la tarea está configurada para repetirse en horas posteriores.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_EXECUTED_COUNT', 'Cantidad de tareas ejecutadas: %1.');

// Asynchronous task actions
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_SUCCESS', 'Se eliminó con éxito el historial.');