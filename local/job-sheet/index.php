<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("DAC : Job Sheet Form");

?>


<?$APPLICATION->IncludeComponent(
   "bitrix:catalog.search",
   "",
   array(
      "IBLOCK_TYPE" => "catalog",
      "IBLOCK_ID" => "22",
      "ELEMENT_SORT_FIELD" => "name",
      "ELEMENT_SORT_ORDER" => "asc",
      "PAGE_ELEMENT_COUNT" => "20",
      "LINE_ELEMENT_COUNT" => "3",
      "PROPERTY_CODE" => array("PRICE", "DESCRIPTION"),
      "PRICE_CODE" => array("BASE")
   ),
   false
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>