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
 * Last update: 06/15/2025
 */

require 'fragment/color_scheme.php';
?>
<style>
    #z4m-asynctasks-scheduled-list-header {
        position: sticky;
    }
</style>
<!-- Header -->
<div id="z4m-asynctasks-scheduled-list-header" class="w3-row <?php echo $color['content']; ?> w3-hide-small w3-border-bottom <?php echo $color['list_border_bottom']; ?>">
    <div class="w3-col m1 l1 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_LIST_ID_LABEL; ?></b></div>
    <div class="w3-col m3 l3 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_LIST_TASK_LABEL; ?></b></div>
    <div class="w3-col m3 l3 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_SCHEDULING_LABEL; ?></b></div>
    <div class="w3-col m3 l3 w3-padding-small"><b><?php echo MOD_Z4M_ASYNCTASKS_LIST_STATEMENT_LABEL; ?></b></div>
    <div class="w3-col m2 l2 w3-padding-small w3-right-align"><b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_IS_ENABLED_LABEL; ?></b></div>
</div>
<!-- Data List -->
<ul id="z4m-asynctasks-scheduled-list" class="w3-ul w3-hide w3-margin-bottom" data-zdk-load="Z4MAsyncTasksScheduledCtrl:all" data-zdk-autocomplete="Z4MAsyncTasksScheduledCtrl:suggestions">
    <li class="<?php echo $color['list_border_bottom']; ?> w3-hover-light-grey" data-id="{{id}}">
        <div class="w3-row w3-stretch">
            <a class="edit" href="javascript:void(0)">
                <div class="w3-col s2 l1 m1 w3-padding-small">
                    <span class="w3-tag <?php echo $color['tag']; ?>">{{id}}</span>
                </div>
            </a>
            <div class="w3-col s10 l3 m3 w3-padding-small">
                <b>{{name}}</b><br><i class="w3-small">{{description}}</i>
            </div>
            <div class="w3-col s12 l3 m3 w3-padding-small">
                <i class="fa fa-clock-o <?php echo $color['icon']; ?>"></i> {{scheduled_time}}{{time_repetition}}<br>
                <i class="fa fa-calendar-check-o <?php echo $color['icon']; ?>"></i> {{scheduled_week_days_display}}
            </div>
            <div class="w3-col s9 l3 m3 w3-padding-small"><code>{{statement_to_execute}}</code></div>
            <div class="w3-col s3 l2 m2 w3-padding-small w3-right-align">{{status}}</div>
        </div>
    </li>
    <li><h3 class="<?php echo $color['msg_error']; ?> w3-center w3-stretch"><i class="fa fa-frown-o"></i>&nbsp;<?php echo LC_MSG_INF_NO_RESULT_FOUND; ?></h3></li>
</ul>
<!-- Modal dialog for adding and editing -->
<div id="z4m-asynctasks-scheduled-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-hourglass-half fa-lg"></i>
                <span class="title">Scheduled task</span>
            </h4>
        </header>
        <form class="w3-container <?php echo $color['modal_content']; ?>" data-zdk-load="Z4MAsyncTasksScheduledCtrl:detail" data-zdk-submit="Z4MAsyncTasksScheduledCtrl:store">
            <input type="hidden" name="id">
            <div class="w3-section">
                <label>
                    <b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TASK_NAME_LABEL; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="name" required autocomplete="off" maxlength="50">
                </label>
                <label>
                    <b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DESCRIPTION_LABEL; ?></b>
                    <textarea class="w3-input w3-border w3-margin-bottom" name="description" rows="2" autocomplete="off" maxlength="250"></textarea>
                </label>
                <label>
                    <b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_LABEL; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="statement_to_execute" required autocomplete="off" placeholder="<?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_STATEMENT_PLACEHOLDER; ?>">
                </label>
                <fieldset class="w3-margin-bottom">
                    <legend><b class="zdk-required"><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LEGEND; ?></b></legend>
                    <div class="w3-bar w3-padding-16">
<?php foreach (MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_DAYS_OF_WEEK_LABELS as $index => $label) : ?>                    
                        <label class="w3-bar-item">
                            <input class="w3-check" type="checkbox" name="scheduled_week_days[]" value="<?php echo $index; ?>">
                            <?php echo $label; ?>
                        </label>
<?php endforeach; ?>
                    </div>
                </fieldset>
                <fieldset class="w3-margin-bottom">
                    <legend><b class="zdk-required"><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LEGEND; ?></b></legend>
                    <div class="w3-row-padding w3-stretch w3-padding-16">
                        <label class="w3-half">
                            <b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_TIME_LABEL; ?></b>
                            <input class="w3-input w3-border w3-margin-bottom" type="time" name="scheduled_time" autocomplete="off" required>
                        </label>
                        <label class="w3-half">
                            <b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_HOUR_REPETITION_LABEL; ?></b>
                            <input class="w3-input w3-border w3-margin-bottom" type="number" name="next_hours_repetition_count" value="0" required autocomplete="off" min="0" max="23">
                        </label>
                    </div>
                </fieldset>
                <div class="w3-row-padding w3-stretch">
                    <label class="w3-half">
                        <b><?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_ERROR_REPETITION_LABEL; ?></b>
                        <input class="w3-input w3-border w3-margin-bottom" type="number" name="repetition_count_on_error" value="0" required autocomplete="off" min="0" max="3">
                    </label>
                    <label class="w3-half">
                        <span>&nbsp;</span><br>
                        <input class="w3-check" type="checkbox" name="is_enabled" value="1">
                        <?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_IS_ENABLED_LABEL; ?>
                    </label>
                </div>
            </div>
            <!-- Submit button -->            
            <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                <i class="fa fa-save fa-lg"></i>&nbsp;
                <?php echo LC_BTN_SAVE; ?>
            </button>
        </form>
        <footer class="w3-container w3-border-top w3-padding-16 <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CANCEL; ?>
            </button>
            <button type="button" class="remove w3-button w3-right <?php echo $color['btn_action']; ?>">
                <i class="fa fa-trash fa-lg"></i>&nbsp;
                <?php echo LC_BTN_REMOVE; ?>
            </button>
        </footer>
    </div>
</div>
<script>
<?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4m_asynctasks_scheduled.php' ** For debug purpose **");
<?php endif; ?>
    $(function(){
        var dataList = z4m.list.make('#z4m-asynctasks-scheduled-list', false, false);
        dataList.beforeInsertRowCallback = function(rowData) {
            let icon, color, text;
            if (rowData.is_enabled === '1') {
                color = 'green';
                icon = 'check';
                text = "<?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_YES_LABEL; ?>";
            } else {
                color = 'red';
                icon = 'times';
                text = "<?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_LIST_NO_LABEL; ?>";
            }
            rowData.status = '<span class="w3-tag w3-round w3-' + color 
                +'"><i class="fa fa-' + icon + '"></i> ' + text + '</span>';
            rowData.time_repetition = rowData.next_hours_repetition_count > 0
                ? ' - ' + rowData.scheduled_end_time : '';
        };
        dataList.setModal('#z4m-asynctasks-scheduled-modal', true, function(innerForm){
            // NEW
            this.setTitle("<?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_NEW_LABEL; ?>");
            innerForm.setInputValue('is_enabled', '1');
            // The remove button is hidden
            this.element.find('button.remove').addClass('w3-hide');
        }, function(innerForm, formData) {
            // EDIT
            if (formData.hasOwnProperty('warning')) {
                // This row no longer exists in database
                z4m.messages.showSnackbar(formData.msg, true);
                return false;
            }
            this.setTitle("<?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_EDIT_LABEL; ?>" + formData.id);
            // The remove button is shown
            this.element.find('button.remove').removeClass('w3-hide');
        });
        // Click on remove button
        $('#z4m-asynctasks-scheduled-modal button.remove').on('click', function() {
            const modal = z4m.modal.make('#z4m-asynctasks-scheduled-modal'),
                innerForm = modal.getInnerForm(),
                entityId = innerForm.getInputValue('id');
            z4m.messages.ask("<?php echo MOD_Z4M_ASYNCTASKS_SCHEDULED_FORM_REMOVE_LABEL; ?>" + entityId,
                    "<?php echo LC_MSG_ASK_REMOVE; ?>", {yes: "<?php echo LC_BTN_YES; ?>",
                    no: "<?php echo LC_BTN_NO; ?>"}, function(isYes) {
                if (!isYes) {
                    return;
                }
                z4m.ajax.request({
                    controller: 'Z4MAsyncTasksScheduledCtrl',
                    action: 'remove',
                    data: {id: entityId},
                    callback: function(response) {
                        if (response.success) { // Success
                            // The list is refreshed
                            dataList.refresh();
                            // The modal is closed
                            modal.close();
                            // The removal notification shown
                            z4m.messages.showSnackbar(response.msg);
                        } else { // Error
                            innerForm.showError(response.msg, null, true);
                        }
                    }
                });
            });
        });
        // List header sticky position taking in account ZnetDK autoHideOnScrollEnabled property
        onTopSpaceChange();
        $('body').on('topspacechange.z4m-async-task-scheduled', onTopSpaceChange);
        function onTopSpaceChange() {
            $('#z4m-asynctasks-scheduled-list-header').css('top', z4m.header.autoHideOnScrollEnabled
                ? 0 : z4m.header.getHeight());
        }
    });
</script>