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
 * Parameters of the ZnetDK 4 Mobile Asynchronous tasks module
 *
 * File version: 1.0
 * Last update: 06/20/2025
 */

/**
 * Specifies whether only scheduled tasks are executed when the
 * Z4MAsyncTasksScheduledCtrl::action_trigger() method is called.
 * @boolean If TRUE, only scheduled tasks are executed. Value FALSE is set by
 * default meaning that other asynchronous tasks are also executed when the 
 * Z4MAsyncTasksScheduledCtrl::action_trigger() method is called.
 */
define('MOD_Z4M_ASYNCTASKS_TRIGGER_SCHEDULED_ONLY', FALSE);


/**
 * Path of the SQL script to update the database schema
 * @string Path of the SQL script
 */
define('MOD_Z4M_ASYNCTASKS_SQL_SCRIPT_PATH', ZNETDK_MOD_ROOT
        . DIRECTORY_SEPARATOR . 'z4m_asynctasks' . DIRECTORY_SEPARATOR
        . 'mod' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR
        . 'z4m_asynctasks.sql');

/**
 * Color scheme applied to the Asynchronous tasks views.
 * @var array|NULL Colors used to display the module's views. The expected array
 * keys are 'filter_bar', 'list_border_bottom', 'content', 'btn_action',
 * 'btn_hover', 'btn_submit', 'btn_cancel', 'tag', 'icon', 'modal_header',
 * 'modal_content', 'modal_footer', 'modal_footer_border_top' and 'msg_error'.
 * If NULL, default color CSS classes are applied.
 */
define('MOD_Z4M_ASYNCTASKS_COLOR_SCHEME', NULL);

/**
 * Module version number
 * @return string Version
 */
define('MOD_Z4M_ASYNCTASKS_VERSION_NUMBER','1.0');
/**
 * Module version date
 * @return string Date in W3C format
 */
define('MOD_Z4M_ASYNCTASKS_VERSION_DATE','2025-06-20');