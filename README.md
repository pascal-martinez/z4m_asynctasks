# ZnetDK 4 Mobile module: Asynchronous Tasks (z4m_asynctasks)
![Screenshot of the Task execution history view provided by the ZnetDK 4 Mobile 'z4m_asynctasks' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_asynctasks/screenshot1.jpg)
The **z4m_asynctasks** module allows you to schedule and execute asynchronous tasks from the [ZnetDK 4 Mobile](/../../../znetdk4mobile) starter application.

Scheduled tasks are registered from the view named **Scheduled tasks** and can be scheduled on one or more days a week at a given time or over a given range of times.

Asynchronous tasks can also be registered using the **provided API** and be executed each time the scheduled tasks are processed.

Finally, task execution can be tracked from the view name **Task execution history**.

> [!NOTE]
> Scheduled task execution requires configuring a **webcron** or the **crontab** on the web hosting.


## LICENCE
This module is published under the [version 3 of GPL General Public Licence](LICENSE.TXT).

## FEATURES
- Scheduled Tasks Registration Form.
- List of the registered scheduled tasks.
- A scheduled task can be repeated the following hours.
- A scheduled task can be disabled if necessary.
- A scheduled task can be executed again in case of error.
- An asynchronous task can be added via the API provided with the module.
- History of registered asynchronous and scheduled tasks and their execution status.
- Purge of the history.

## REQUIREMENTS
- [ZnetDK 4 Mobile](/../../../znetdk4mobile) version 2.9 or higher,
- A **MySQL** database [is configured](https://mobile.znetdk.fr/getting-started#z4m-gs-connect-config) to store the application data,
- **PHP version 7.4** or higher,
- Authentication is enabled
([`CFG_AUTHENT_REQUIRED`](https://mobile.znetdk.fr/settings#z4m-settings-auth-required)
is `TRUE` in the App's
[`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php)).

## INSTALLATION
1. Add a new subdirectory named `z4m_asynctasks` within the
[`./engine/modules/`](/../../../znetdk4mobile/tree/master/engine/modules/) subdirectory of your
ZnetDK 4 Mobile starter App,
2. Copy module's code in the new `./engine/modules/z4m_asynctasks/` subdirectory,
or from your IDE, pull the code from this module's GitHub repository,
3. Edit the App's [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and include the [`menu.inc`](mod/menu.inc) script to add menu item definition for the
`z4m_asynctasks_scheduled` and `z4m_asynctasks_history` views.
```php
require ZNETDK_MOD_ROOT . '/z4m_asynctasks/mod/menu.inc';
```

## USERS GRANTED TO MODULE FEATURES
Once the **Asynchronous tasks** menu item is added to the application, you can restrict 
its access via a [user profile](https://mobile.znetdk.fr/settings#z4m-settings-user-rights).  
For example:
1. Create a user profile named `Admin` from the **Authorizations | Profiles** menu,
2. Select for this new profile, the **Scheduled tasks** and **Task execution history** menu items,
3. Finally for each allowed user, add them the `Admin` profile from the **Authorizations | Users** menu. 

## CONFIGURING A CRON JOB TO TRIGGER ASYNCHRONOUS TASKS EXECUTION ##
In order to trigger the execution of the registered asynchronous tasks, a CRON job must be configured on the web hosting.
This CRON job calls the [`Z4MAsyncTasksScheduledCtrl::action_trigger()`](mod/controller/Z4MAsyncTasksScheduledCtrl.php) PHP method through an HTTP request (GET method).  
You can use a **webcron** service if exists or directly edit your Linux `crontab`.  
Here is below an example of `crontab` configuration:
```
### Every hour from 05:17 to 20:17, from Monday to Friday.
17 05-20 * * 1-5 curl "https://mydomain/myapp/?control=Z4MAsyncTasksScheduledCtrl&action=trigger"
```
> [!NOTE]
> No authentication is required to call in HTTP this `trigger` action. Nevertheless, if the tasks to run require authentication, just add your credentials to the HTTP request.  
> For example:   
> `https://myuser:mypassword@mydomain/myapp/?control=Z4MAsyncTasksScheduledCtrl&action=trigger`

## SCHEDULING TASK EXECUTION ##
![Screenshot of the Scheduled task list view provided by the ZnetDK 4 Mobile 'z4m_asynctasks' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_asynctasks/screenshot2.jpg)
To schedule a new asynchronous task, click the **Asynchronous tasks | Scheduled tasks** menu and next the plus button.
From the **New scheduled task** modal dialog, enter the informations of the task to schédule.

![Screenshot of the New scheduled task modal dialog provided by the ZnetDK 4 Mobile 'z4m_asynctasks' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_asynctasks/screenshot3.png)

- **Task name**: name given to the task.
- **Description** (optional): description of what the task does.
- **PHP method or function**: the PHP method or function to execute prefixed by its namespace if required and ended by its parenthesis with its optional arguments.
This function must return an informational message on success and throw an exception on error.
- **Scheduled days of week**: select the days of week when the task is to execute.
- **Scheduled time**: time from which the task should be executed and the number of times it is executed in the following hours.
- **Repetition count on error**: in case of error during its execution, the number of times the task execution is repeated. This option can't be set if the task is already configured to be executed in the following hours.
- **Is task enabled?**: when unchecked, the task is disabled.

## REGISTERING ASYNCHRONOUS TASKS VIA THE MODULE'S API ##
To register an asynchronous task via the module's API, call the [`AsynchronousTask::add()`](mod/AsynchronousTask.php) PHP method. For example:
```php
use \z4m_asynctasks\mod\AsynchronousTask;
$taskId = AsynchronousTask::add('My task', 'app\AsyncTaskExample::run(true)');
```
Once your asynchronous task is registered, your task will be executed the next time the configured CRON job will trigger the [`Z4MAsyncTasksScheduledCtrl::action_trigger()`](mod/controller/Z4MAsyncTasksScheduledCtrl.php) PHP method.  
Execution of the asynchronous tasks registered via the API can be disabled by setting the PHP constant `MOD_Z4M_ASYNCTASKS_TRIGGER_SCHEDULED_ONLY` to `TRUE` in the [`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php) script of the application.  
Then, all registered tasks via API can be executed by calling the [`AsynchronousTask::runAll('not_scheduled')`](mod/AsynchronousTask.php) PHP method.  
Otherwise, to execute only one registered task via the API, call the [`AsynchronousTask::runOne($taskId)`](mod/AsynchronousTask.php) PHP method.

The statement specified for an asynchronous task is a **PHP function or method** that returns an informational message (can also be an empty string) when its execution has succeeded or throws a PHP Exception in case of error.
Here is below an example of method you can invoke as asynchronous task:
```php
class AsyncTaskExample {
    static public function run($isSuccess = FALSE) {
        if ($isSuccess === TRUE) {
            return 'Task has succeeded';
        }
        throw new \Exception('Task has failed');
    }
}
```

## TRANSLATIONS
This module is translated in **French**, **English** and **Spanish** languages.  
To translate this module in another language or change the standard
translations:
1. Copy in the clipboard the PHP constants declared within the 
[`locale_en.php`](mod/lang/locale_en.php) script of the module,
2. Paste them from the clipboard within the
[`locale.php`](/../../../znetdk4mobile/blob/master/applications/default/app/lang/locale.php) script of your application,   
3. Finally, translate each text associated with these PHP constants into your own language.

## INSTALLATION ISSUES ##
The `z4m_asynchronous_scheduled_tasks` and `z4m_asynchronous_tasks` SQL tables
are created automatically by the module when one of the module views is displayed
for the first time.  
If the MySQL user declared through the
[`CFG_SQL_APPL_USR`](https://mobile.znetdk.fr/settings#z4m-settings-db-user)
PHP constant does not have `CREATE` privilege, the module can't create the
required SQL tables.   
In this case, you can create the module's SQL tables by importing in MySQL or
phpMyAdmin the script [`z4m_asynctasks.sql`](mod/sql/z4m_asynctasks.sql)
provided by the module.

## CHANGE LOG
See [CHANGELOG.md](CHANGELOG.md) file.

## CONTRIBUTING
Your contribution to the **ZnetDK 4 Mobile** project is welcome. Please refer to the [CONTRIBUTING.md](https://github.com/pascal-martinez/znetdk4mobile/blob/master/CONTRIBUTING.md) file.
