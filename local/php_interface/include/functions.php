<?php

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();
$eventManager->addEventHandlerCompatible("crm", "OnBeforeCrmDealProductRowsSave", ["\Uchet\Events\Deal", "OnBeforeCrmDealProductRowsSave"]);