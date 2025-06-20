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
 * ZnetDK 4 Mobile Asynchronous tasks Module French translations
 *
 * File version: 1.0
 * Last update: 06/19/2025
 */

define('MOD_Z4M_ASYNCTASKS_PARENT_MENU_LABEL', 'Tâches asynchrones');

// Task lists
define('MOD_Z4M_ASYNCTASKS_LIST_ID_LABEL', 'ID');
define('MOD_Z4M_ASYNCTASKS_LIST_TASK_LABEL', 'Tâche');
define('MOD_Z4M_ASYNCTASKS_LIST_STATEMENT_LABEL', 'Instruction');

// Scheduled task list
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_MENU_LABEL', 'Tâches programmées');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_SCHEDULING_LABEL', 'Programmation');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_IS_ENABLED_LABEL', 'Est activée ?');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_YES_LABEL', 'Oui');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_NO_LABEL', 'Non');

// Asynchronous task history
define('MOD_Z4M_ASYNCTASKS_HISTORY_MENU_LABEL', 'Historique des tâches');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_PERIOD', 'Période');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_STATUS_ALL', 'Tous');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_SUCCESS', 'OK');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_FAILED', 'KO');
define('MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_NOTEXECUTED', 'En attente');
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_CONFIRMATION_TEXT', 'Confirmez-vous la purge de l\'historique des tâches ?');
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_BUTTON_LABEL', 'Purger...');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_LINK', 'Suppression de l\'historique...');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_QUESTION', 'Supprimer l\'historique d\'exécution de la tâche ID = %1 ?');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_CREATION_DATETIME', 'Ajoutée le %1');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_SCHEDULED_TIME', 'Programmée à %1');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_EXECUTION_LABEL', 'Exécution');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REPETITION_LABEL', 'Répétition après erreur  %1/%2');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_IN_ERROR_LABEL', 'Tâche en échec ID = [%1]');
define('MOD_Z4M_ASYNCTASKS_HISTORY_LIST_STATUS_LABEL', 'Statut');

// Scheduled task form
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_NEW_LABEL', 'Nouvelle tâche programmée');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_EDIT_LABEL', 'Edition tâche programmée ID=');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_REMOVE_LABEL', 'Supprimer la tâche programmée ID=');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TASK_NAME_LABEL', 'Nom de la tâche');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DESCRIPTION_LABEL', 'Description');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LEGEND', 'Jours programmés dans la semaine');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LABELS', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']);
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LEGEND', 'Heure programmée');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LABEL', 'Heure de début');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_HOUR_REPETITION_LABEL', 'Nombre de répétitions les heures suivantes');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_ERROR_REPETITION_LABEL', 'Nombre de répétitions en cas d\'erreur');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_LABEL', 'Méthode ou fonction PHP');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_PLACEHOLDER', 'Par exemple: MyClass::myMethod(\'my_value\')');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_IS_ENABLED_LABEL', 'Est-ce que la tâche est activée ?');

// Scheduled task actions
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_OPENING_PARENTHESIS_ERROR', 'La parenthèse ouvrante est manquante.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_STATEMENT_CLOSING_PARENTHESIS_ERROR', 'La parenthèse fermante est manquante.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_FUNCTION_ERROR', 'La fonction n\'existe pas.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_UNKNOWN_METHOD_ERROR', 'La méthode n\'existe pas.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_STORE_REPETITION_ERROR', 'La répétition de la tâche en cas d\'erreur n\'est pas permise si la tâche est configurée pour être répétée les heures suivantes.');
define('MOD_Z4M_ASYNCTASKS_SCHEDULED_EXECUTED_COUNT', 'Nombre de tâches exécutées: %1.');

// Asynchronous task actions
define('MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_SUCCESS', 'Purge de l\'historique réussie.');