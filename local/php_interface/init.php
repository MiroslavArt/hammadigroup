<?php

AddEventHandler('tasks', 'OnTaskUpdate', "my_OnTaskUpdate");

function my_OnTaskUpdate($taskId){
    //\Bitrix\Main\Diag\Debug::writeToFile($taskId, "upevent", "__miros.log");
    if (CModule::IncludeModule("tasks"))
    {
        $resone = CTasks::GetList(
            Array("TITLE" => "ASC"),
            Array("ID" => $taskId),
            ['ID', 'STATUS_COMPLETE', 'DURATION_FACT', 'UF_CRM_TASK']
        );

        $startbp = false;
        $carwashdur = 0;
        $plantingdur = 0;
        $dentingdur = 0;
        $polishingdur = 0;
        $mechanicaldur = 0;
        $electriciandur = 0;

        while ($arTaskone = $resone->GetNext())
        {
            if($arTaskone['STATUS_COMPLETE']==2 && is_array($arTaskone['UF_CRM_TASK'])) {
                if(preg_replace('/[^D]/', "", $arTaskone['UF_CRM_TASK'][0])) {
                    $dealid = preg_replace('/[^0-9]/', "", $arTaskone['UF_CRM_TASK'][0]);
                    if($dealid) {
                        //$totaldurations = intval($arTaskone['DURATION_FACT']);
                        $restwo = CTasks::GetList(
                            Array("TITLE" => "ASC"),
                            //['UF_CRM_TASK'=>$arTaskone['UF_CRM_TASK'][0], '!ID'=>$taskId],
                            ['UF_CRM_TASK'=>$arTaskone['UF_CRM_TASK'][0]],
                            ['ID', 'STATUS_COMPLETE', 'DURATION_FACT', 'UF_*']
                        );
                        //$totaldurations = 0;

                        while ($arTasktwo = $restwo->GetNext())
                        {
                            $duraction = intval($arTasktwo['DURATION_FACT']);
                            if($arTasktwo['STATUS_COMPLETE']==2 && $duraction>0) {
                                if($arTasktwo['UF_AUTO_262642916192']==1) {
                                    $carwashdur += $duraction;
                                }
                                if($arTasktwo['UF_AUTO_980879271911']==1) {
                                    $plantingdur += $duraction;
                                }
                                if($arTasktwo['UF_AUTO_786510545486']==1) {
                                    $dentingdur += $duraction;
                                }
                                if($arTasktwo['UF_AUTO_158137272241']==1) {
                                    $polishingdur += $duraction;
                                }
                                if($arTasktwo['UF_AUTO_412749767905']==1) {
                                    $mechanicaldur += $duraction;
                                }
                                if($arTasktwo['UF_AUTO_315586262608']==1) {
                                    $electriciandur += $duraction;
                                }
                                //$totaldurations = $totaldurations + intval($arTasktwo['DURATION_FACT']);
                            }
                        }
                    }
                }
            }
        }
        if($dealid) {
            if($carwashdur || $plantingdur || $dentingdur || $polishingdur || $mechanicaldur || $electriciandur) {
                if(CModule::IncludeModule("bizproc"))
                {
                    $arWorkflowParameters = array(
                        "carwashdur" => $carwashdur,
                        "plantingdur" => $plantingdur,
                        "dentingdur" => $dentingdur,
                        "polishingdur" => $polishingdur,
                        "mechanicaldur" => $mechanicaldur,
                        "electriciandur" => $electriciandur
                    );
                    $arErrorsTmp = [];
                    $deal = 'DEAL_'.$dealid;
                    $wfId = \CBPDocument::StartWorkflow(
                        '113', // константа шаблона БП
                        array("crm","CCrmDocumentDeal", $deal),
                        $arWorkflowParameters,
                        $arErrorsTmp
                    );
                }
            }
            //\Bitrix\Main\Diag\Debug::writeToFile($totaldurations, "total durations", "__miros.log");
        }
    }
}

function numToWordsRec($number) {
    $words = array(
        0 => 'zero', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five',
        6 => 'six', 7 => 'seven', 8 => 'eight',
        9 => 'nine', 10 => 'ten', 11 => 'eleven',
        12 => 'twelve', 13 => 'thirteen',
        14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty',
        90 => 'ninety'
    );

    if ($number < 20) {
        return $words[$number];
    }

    if ($number < 100) {
        return $words[10 * floor($number / 10)] .
            ' ' . $words[$number % 10];
    }

    if ($number < 1000) {
        return $words[floor($number / 100)] . ' hundred '
            . numToWordsRec($number % 100);
    }

    if ($number < 1000000) {
        return numToWordsRec(floor($number / 1000)) .
            ' thousand ' . numToWordsRec($number % 1000);
    }

    return numToWordsRec(floor($number / 1000000)) .
        ' million ' . numToWordsRec($number % 1000000);
}