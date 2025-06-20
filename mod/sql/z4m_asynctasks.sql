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
 * ZnetDK 4 Mobile Asynchronous tasks module SQL Script
 * 
 * File version: 1.0
 * Last update: 06/15/2025
 */

CREATE TABLE IF NOT EXISTS `z4m_asynchronous_scheduled_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Internal Identifier',
  `name` varchar(50) NOT NULL COMMENT 'Task name',
  `description` varchar(250) NULL COMMENT 'Task description',
  `statement_to_execute` TEXT NOT NULL COMMENT 'Statement to execute',
  `scheduled_week_days` VARCHAR(50) NOT NULL COMMENT 'Scheduled week days',
  `scheduled_time` TIME NOT NULL COMMENT 'Scheduled time',
  `next_hours_repetition_count` tinyint NOT NULL COMMENT 'Next hours repetition count',
  `repetition_count_on_error` tinyint NOT NULL COMMENT 'Repetition count on error',
  `is_enabled` tinyint(1) NULL COMMENT 'Is enabled?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Asynchronous scheduled task' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `z4m_asynchronous_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Internal Identifier',
  `creation_datetime` DATETIME NOT NULL COMMENT 'Creation date and time',
  `name` varchar(50) NOT NULL COMMENT 'Task name',
  `scheduled_task_id` int(11) NULL COMMENT 'Internal Id. of the corresponding scheduled task',
  `scheduled_time` TIME NULL COMMENT 'Scheduled time',
  `statement_to_execute` TEXT NOT NULL COMMENT 'Statement to execute',
  `repetition_count_on_error` tinyint NOT NULL COMMENT 'Repetition count on error',
  `execution_datetime` DATETIME NULL COMMENT 'Execution date and time',
  `execution_count_after_error` tinyint NOT NULL COMMENT 'Execution count after error',
  `status` tinyint(1) NULL COMMENT 'Status',
  `previous_failed_task_id` int(11) NULL COMMENT 'Internal Id. of the previous task that failed',
  `execution_message` TEXT NULL COMMENT 'Error or information message',
  PRIMARY KEY (`id`),
  KEY `scheduled_task_id` (`scheduled_task_id`),
  KEY `previous_failed_task_id` (`scheduled_task_id`),
  KEY `creation_datetime` (`creation_datetime`),
  KEY `execution_datetime` (`execution_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Asynchronous task' AUTO_INCREMENT=1 ;

ALTER TABLE `z4m_asynchronous_tasks` 
ADD CONSTRAINT `z4m_asynchronous_tasks_ibfk_1`
FOREIGN KEY (`previous_failed_task_id`) 
REFERENCES `z4m_asynchronous_tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `asynchronous_tasks_ibfk_2` 
FOREIGN KEY (`scheduled_task_id`)
REFERENCES `z4m_asynchronous_scheduled_tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
