<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->IncludeComponent(
    "bitrix:socialnetwork_group", // Component name
    ".default",            // Template name (leave empty for default template)
    array(                      // Parameters
        "PARAM1" => "VALUE1",
        "PARAM2" => "VALUE2",
    ),
    false                       // Parent component (optional)
);

?>
