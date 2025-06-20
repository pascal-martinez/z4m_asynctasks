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
 * Menu definition of the ZnetDK 4 Mobile Asynchronous tasks module
 *
 * File version: 1.0
 * Last update: 06/19/2025
 */
\MenuManager::addMenuItem(NULL, '_asynctasks', MOD_Z4M_ASYNCTASKS_PARENT_MENU_LABEL, 'fa-hourglass-end');
\MenuManager::addMenuItem('_asynctasks', 'z4m_asynctasks_history', MOD_Z4M_ASYNCTASKS_HISTORY_MENU_LABEL, 'fa-history');
\MenuManager::addMenuItem('_asynctasks', 'z4m_asynctasks_scheduled', MOD_Z4M_ASYNCTASKS_SCHEDULED_MENU_LABEL, 'fa-clock-o');
