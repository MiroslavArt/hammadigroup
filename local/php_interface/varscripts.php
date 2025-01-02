<?php
if (CModule::IncludeModule("tasks"))
{
    $res = CTasks::GetList(
        Array("TITLE" => "ASC"),
        //Array("ID" => "88"),
        ['UF_CRM_TASK'=>'D_76','STATUS_COMPLETE'=>2],
        ['*','UF_*']
    );
    while ($arTask = $res->GetNext())
    {
        //echo "Task name: ".$arTask["TITLE"]."";
        echo "<pre>";
        print_r($arTask);
        echo "</pre>";
    }
}