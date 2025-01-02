<?php

namespace Uchet\Events;

use Bitrix\Main\Loader;
use Bitrix\Crm\Service;
use Bitrix\Crm\Item;
use Bitrix\Main\Diag\Debug; // For logging

Loader::includeModule('tasks');
Loader::includeModule('crm');

class Deal
{
    public static function OnBeforeCrmDealProductRowsSave(int $ownerId, array $rows)
    {
        foreach ($rows as $row) {
            // Prepare the fields array for the custom table
            $fields = [
                'OWNER_ID' => $ownerId,
                'OWNER_TYPE_ID' => 'D', // 'D' for Deal
                'PRODUCT_ROW_ID' => $row['ID'],
            ];

            // Handle MARGIN field
            if (isset($row['MARGIN'])) {
                // Perform validation for MARGIN if needed (e.g., numeric check)
                if (is_numeric($row['MARGIN'])) {
                    $fields['MARGIN'] = $row['MARGIN'];
                } else {
                    AddMessage2Log("Invalid MARGIN value: {$row['MARGIN']} for Product Row ID: {$row['ID']}", "Deal_Product_Row");
                }
            }

            // Handle Quote Price (Initial) field
            if (isset($row['QUOTE_PRICE_INITIAL'])) {
                // Perform validation for QUOTE_PRICE_INITIAL if needed
                if (is_numeric($row['QUOTE_PRICE_INITIAL'])) {
                    $fields['QUOTE_PRICE_INITIAL'] = $row['QUOTE_PRICE_INITIAL'];
                } else {
                    AddMessage2Log("Invalid QUOTE_PRICE_INITIAL value: {$row['QUOTE_PRICE_INITIAL']} for Product Row ID: {$row['ID']}", "Deal_Product_Row");
                }
            }


            $rsData = \Uchet\ProductRowDealMarginTable::getList([
                'filter' => [
                    'OWNER_ID' => $fields['OWNER_ID'],
                    'OWNER_TYPE_ID' => $fields['OWNER_TYPE_ID'],
                    'PRODUCT_ROW_ID' => $fields['PRODUCT_ROW_ID']
                ]
            ])->Fetch();

            if ($rsData) {
                // Update existing data
                try {
                    \Uchet\ProductRowDealMarginTable::update($rsData['ID'], $fields);
                    AddMessage2Log("Updated Product Row ID: {$fields['PRODUCT_ROW_ID']} for Deal ID: {$ownerId}", "Deal_Product_Row");
                } catch (\Exception $e) {
					// AddMessage2Log("Error updating Product Row ID: {$fields['PRODUCT_ROW_ID']} for Deal ID: {$ownerId}. Error: " . $e->getMessage(), "Deal_Product_Row");
                }
            } else {
                // Add new data
                try {
                    \Uchet\ProductRowDealMarginTable::add($fields);
					//AddMessage2Log("Added new Product Row ID: {$fields['PRODUCT_ROW_ID']} for Deal ID: {$ownerId}", "Deal_Product_Row");
                } catch (\Exception $e) {
					//AddMessage2Log("Error adding new Product Row ID: {$fields['PRODUCT_ROW_ID']} for Deal ID: {$ownerId}. Error: " . $e->getMessage(), "Deal_Product_Row");
                }
            }
        }
    }
}
