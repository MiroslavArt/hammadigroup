<?php

namespace Webmatrik\Interface\Events;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\EventManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Loader;
use CJSCore;

/**
 * Class for Main events
 **/
class MainEvents
{

    /**
     * @return void
     */
    public static function onProlog()
    {
        $eventManager = EventManager::getInstance();

        $eventManager->addEventHandler(
            'main',
            'OnEpilog',
            [MainEvents::class,'onEpilog']
        );

        \CJSCore::RegisterExt('webmatrik_interface_tasks', [
            "js" => "/local/js/webmatrik.interface/tasks/script.js",
        ]);
    }

    public static function onEpilog()
    {
        global $USER;

        $urlTemplates = [
            'tasks_detail' => 'company/personal/user/#user_id#/tasks/task/view/#task_id#/',
        ];

        $asset = Asset::getInstance();

        $page = \CComponentEngine::parseComponentPath('/', $urlTemplates, $arVars);
        $type = '';
        if ($page !== false) {
            switch ($page) {
                case 'tasks_detail':
                    $type = 'task';
                    break;
            }
        }

        //\Bitrix\Main\Diag\Debug::writeToFile($arVars,"vars", '__miros.log');




        \CJSCore::init('jquery3');

        if($type =='task') {
            $exuser = \COption::GetOptionString('webmatrik_interface', 'main_User_CanCCTasks');
            if($exuser != $arVars['user_id']) {
                \CJSCore::init(['webmatrik_interface_tasks']);
                $asset->addString('<script>BX.ready(function () {BX.Webmatrik.Interface.Tasks.init
                ();});</script>');
            }
        }
    }
}