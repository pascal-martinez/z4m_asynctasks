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
 * ZnetDK 4 Mobile Asynchronous tasks module view
 *
 * File version: 1.0
 * Last update: 06/19/2025
 */

require 'fragment/color_scheme.php';
?>
<style>
    #z4m-asynctasks-history-list-filter .no-wrap {
        white-space: nowrap;
    }
    #z4m-asynctasks-history-list-header {
        position: sticky;
    }
</style>
<!-- Filter by dates and status -->
<form id="z4m-asynctasks-history-list-filter" class="w3-padding w3-panel <?php echo $color['filter_bar']; ?>">
    <div class="w3-cell w3-mobile w3-margin-bottom">
        <div class="w3-cell no-wrap"><i class="fa fa-calendar"></i>&nbsp;<b><?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_PERIOD; ?></b>&nbsp;</div>
        <div class="w3-cell w3-mobile">
            <input class="w3-padding" type="date" name="start_filter">
            <input class="w3-padding w3-margin-right" type="date" name="end_filter">
        </div>
    </div>
    <div class="w3-cell w3-mobile w3-margin-bottom">
        <div class="w3-cell no-wrap"><i class="fa fa-list"></i>&nbsp;<b><?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_STATUS_LABEL; ?></b>&nbsp;</div>
        <div class="w3-cell no-wrap">
            <label class="w3-mobile">
                <input class="w3-radio" type="radio" value="" name="status_filter" checked>
                <?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_FILTER_STATUS_ALL; ?>&nbsp;&nbsp;
            </label>
            <label class="w3-mobile">
                <input class="w3-radio" type="radio" value="1" name="status_filter">
                <?php echo MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_SUCCESS; ?>&nbsp;&nbsp;
            </label>
            <label class="w3-mobile">
                <input class="w3-radio" type="radio" value="0" name="status_filter">
                <?php echo MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_FAILED; ?>&nbsp;&nbsp;
            </label>
            <label class="w3-mobile">
                <input class="w3-radio" type="radio" value="-1" name="status_filter">
                <?php echo MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_NOTEXECUTED; ?>&nbsp;&nbsp;
            </label>
        </div>
    </div>
    <div class="w3-cell">
        <button class="purge w3-button <?php echo $color['btn_action']; ?>" type="button" data-confirmation="<?php echo MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_CONFIRMATION_TEXT; ?>">
            <i class="fa fa-trash fa-lg"></i> <?php echo MOD_Z4M_ASYNCTASKS_HISTORY_PURGE_BUTTON_LABEL; ?>
        </button>
    </div>
</form>
<!-- Header -->
<div id="z4m-asynctasks-history-list-header" class="w3-row <?php echo $color['content']; ?> w3-hide-small w3-hide-medium w3-border-bottom <?php echo $color['list_border_bottom']; ?>">
    <div class="w3-col l1 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_LIST_ID_LABEL; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_LIST_TASK_LABEL; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_LIST_STATEMENT_LABEL; ?></b></div>
    <div class="w3-col l2 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_EXECUTION_LABEL; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_STATUS_LABEL; ?></b></div>
</div>
<!-- Data List -->
<ul id="z4m-asynctasks-history-list" class="w3-ul w3-hide w3-margin-bottom" data-zdk-load="Z4MAsyncTasksHistoryCtrl:all" data-question-remove="<?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_QUESTION; ?>">
    <li class="<?php echo $color['list_border_bottom']; ?> w3-hover-light-grey" data-id="{{id}}">
        <div class="w3-row w3-stretch">
            <div class="w3-col s3 l1 m1 w3-padding-small">
                <span class="w3-tag <?php echo $color['tag']; ?>">{{id}}</span>
            </div>
            <div class="w3-col s9 l3 m3 w3-padding-small">
                <b>{{name}}</b>                
                <div class="w3-small">
                    <i class="fa fa-calendar-plus-o <?php echo $color['icon']; ?>"></i> {{creation_task_infos}}
                    <a class="remove" href="#" title="<?php echo MOD_Z4M_ASYNCTASKS_HISTORY_LIST_REMOVE_LINK; ?>">
                        <i class="fa fa-trash fa-fw w3-text-red w3-medium"></i>
                    </a>
                    {{schedule_display}}
                </div>
            </div>
            <div class="w3-col s12 l3 m3 w3-padding-small"><code>{{statement_to_execute}}</code></div>
            <div class="w3-col s12 l2 m2 w3-padding-small">
                {{not_run}}{{execution_datetime_display}}{{failed_task_repetition_display}}
            </div>
            <div class="w3-col s12 l3 m3 w3-padding-small">
                {{status_display}} {{message_display}}

            </div>
        </div>
    </li>
    <li><h3 class="<?php echo $color['msg_error']; ?> w3-center w3-stretch"><i class="fa fa-frown-o"></i>&nbsp;<?php echo LC_MSG_INF_NO_RESULT_FOUND; ?></h3></li>
</ul>
<script>
<?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4m_asynctasks_history.php' ** For debug purpose **");
<?php endif; ?>
    $(function(){
        var dataList = z4m.list.make('#z4m-asynctasks-history-list', false, false);
        dataList.beforeInsertRowCallback = function(rowData) {
            let statusTag = '<span class="w3-tag w3-round w3-color">label</span>';
            rowData.not_run = ''; rowData.status_display = '';
            if (rowData.status === '1') {
                rowData.status_display = statusTag.replace('color', 'green').replace('label', "<?php echo MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_SUCCESS; ?>");
            } else if (rowData.status === '0') {
                rowData.status_display = statusTag.replace('color', 'red').replace('label', "<?php echo MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_FAILED; ?>");
            } else {
                rowData.not_run = statusTag.replace('color', 'orange').replace('label', "<?php echo MOD_Z4M_ASYNCTASKS_HISTORY_STATUS_NOTEXECUTED; ?>");
            }
            rowData.message_display = '';
            if (rowData.execution_message.length > 0) {
                const shortMsg = rowData.execution_message.length < 106
                    ? rowData.execution_message : rowData.execution_message.substring(0, 106) + '...';
                rowData.message_display = rowData.status === '0'
                    ? '<span class="w3-text-red" title="' + rowData.execution_message
                        + '"><i class="fa fa-warning"></i> <b>' + shortMsg + '</b></span>'
                    : '<span title="' + rowData.execution_message + '"><i>' + shortMsg + '</i></span>';
            }
            rowData.execution_datetime_display = '';
            if (rowData.execution_datetime_locale.length > 0) {
                rowData.execution_datetime_display = '<i class="fa fa-calendar-check-o <?php echo $color['icon']; ?>"></i> '
                    + rowData.execution_datetime_locale;
            }
            rowData.failed_task_repetition_display = '';
            if (rowData.task_repetition_infos.length > 0 && rowData.failed_task_infos.length > 0) {
                rowData.failed_task_repetition_display = '<br><span class="w3-small">' 
                    + '<i class="fa fa-repeat <?php echo $color['icon']; ?>"></i> '
                    + rowData.task_repetition_infos + '<br>'
                    + '<i class="fa fa-cog <?php echo $color['icon']; ?>"></i> '
                    + rowData.failed_task_infos
                        .replace('[', '<span class="w3-tag <?php echo $color['tag']; ?>">')
                        .replace(']', '</span>')
                    + '</span>';
            }
            rowData.schedule_display = rowData.scheduled_task_infos.length > 0
                ? '<br><i class="fa fa-clock-o <?php echo $color['icon']; ?>"></i> '
                    + rowData.scheduled_task_infos : '';
        };
        dataList.beforeSearchRequestCallback = function(requestData) {
            const JSONFilters = getFilterCriteria();
            if (JSONFilters !== null) {
                requestData.search_criteria = JSONFilters;
            }
        };
        dataList.loadedCallback = function(rowCount, pageNumber) {
            const purgeBtn = $('#z4m-asynctasks-history-list-filter button.purge');
            purgeBtn.prop('disabled', rowCount === 0 && pageNumber === 1);
        };
        function getFilterCriteria() {
            const filterForm = z4m.form.make('#z4m-asynctasks-history-list-filter'),
                status = filterForm.getInputValue('status_filter'),
                startDate = filterForm.getInputValue('start_filter'),
                endDate = filterForm.getInputValue('end_filter'),
                filters = {};
            if (status !== '') {
                filters.status = status;
            }
            if (startDate !== '') {
                filters.start = startDate;
            }
            if (endDate !== '') {
                filters.end = endDate;
            }
            if (Object.keys(filters).length > 0) {
                return JSON.stringify(filters);
            }
            return null;
        }
        // Filter change events
        $('#z4m-asynctasks-history-list-filter input').on('change.z4m_asynctasks', function(){
            if ($(this).attr('name') === 'start_filter') {
                const startDate = new Date($(this).val()),
                    endDateEl = $('#z4m-asynctasks-history-list-filter input[name=end_filter]'),
                    endDate = new Date(endDateEl.val());
                if (startDate > endDate) {
                    endDateEl.val($(this).val());
                }
            } else if ($(this).attr('name') === 'end_filter') {
                const endDate = new Date($(this).val()),
                    startDateEl = $('#z4m-asynctasks-history-list-filter input[name=start_filter]'),
                    startDate = new Date(startDateEl.val());
                if (startDate > endDate) {
                    startDateEl.val($(this).val());
                }
            }
            dataList.refresh();
        });
        // Purge button click events
        $('#z4m-asynctasks-history-list-filter button.purge').on('click.z4m_asynctasks', function(){
            z4m.messages.ask($(this).text(), $(this).data('confirmation'), null, function(isOK){
                if(!isOK) {
                    return;
                }
                const requestObj = {
                    controller: 'Z4MAsyncTasksHistoryCtrl',
                    action: 'purge',
                    callback(response) {
                        if (response.success) {
                            dataList.refresh();
                        }
                        z4m.messages.showSnackbar(response.msg, !response.success);
                    }
                };
                const JSONFilters = getFilterCriteria();
                if (JSONFilters !== null) {
                    requestObj.data = {search_criteria: JSONFilters};
                }
                z4m.ajax.request(requestObj);
            });
        });
        // Remove task history link
        $('#z4m-asynctasks-history-list').on('click.z4m_asynctasks', 'a.remove', function(event){
            event.preventDefault();
            const taskId = $(this).closest('li').data('id');
            z4m.messages.ask($(this).attr('title'),
                dataList.element.data('question-remove').replace('%1', '<b>' + taskId + '</b>'), null, function(isYes){
                if (!isYes) {
                   return;
                }
                z4m.ajax.request({
                    controller: 'Z4MAsyncTasksHistoryCtrl',
                    action: 'remove',
                    data: {id: taskId},
                    callback(response) {
                        if (response.success) {
                            dataList.refresh();
                        }
                        z4m.messages.showSnackbar(response.msg, !response.success);
                    }
                });
            });
        });
        // List header sticky position taking in account ZnetDK autoHideOnScrollEnabled property
        onTopSpaceChange();
        $('body').on('topspacechange.z4m-asynctasks-history', onTopSpaceChange);
        function onTopSpaceChange() {
            $('#z4m-asynctasks-history-list-header').css('top', z4m.header.autoHideOnScrollEnabled
                ? 0 : z4m.header.getHeight());
        }
    });
</script>