<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("catalog");

$products = [
    ["ID" => 32, "QUANTITY" => 10],
     ["ID" => 33, "QUANTITY" => 50],
    ["ID" => 34, "QUANTITY" => 75]

];

foreach ($products as $product) {
    CCatalogProduct::Update($product["ID"], ["QUANTITY" => $product["QUANTITY"]]);
}
?>