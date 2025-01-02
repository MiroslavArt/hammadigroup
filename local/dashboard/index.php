<meta http-equiv="refresh" content="120">
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
header("Refresh: 120"); // Refresh every 120 seconds
$APPLICATION->SetTitle("Dashboard");

$APPLICATION->IncludeComponent(
    'bitrix:tasks.kanban',
    '',
    [
        'GROUP_ID' => 1, // Specify the Project Group ID dynamically
        'PERSONAL' => 'N',                  // Ensure it's for group tasks, not personal tasks
        'ITEMS_COUNT' => 50,                // Number of tasks per page
        'PAGE_TITLE' => "Dashboard", // Custom page title
        'PATH_TO_USER_PROFILE' => '/company/personal/user/#user_id#/', // User profile path
        'PATH_TO_TASKS' => '/workgroups/group/#group_id#/tasks/', // Tasks path for the group
        'PATH_TO_TASKS_TASK' => '/workgroups/group/#group_id#/tasks/task/#task_id#/', // Task detail path for the group
        'USE_FILTER' => 'N',               // Enable filters
        'SHOW_QUICK_FORM' => 'N',          // Allow quick task creation
        'SHOW_USER_SORT' => 'N',           // Enable user sorting
        'FILTER' => [
            '=GROUP_ID' => 1, // Filter tasks by the group ID
            '!STATUS' => [5, 6],                  // Exclude completed and deferred tasks (optional)
        ],
    ],
    false
);


?>
<script>
    setInterval(function() {
        location.reload();
    }, 120000); // 120000 ms = 120 seconds
</script>