<?php

namespace Uchet;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class ProductRowDealMarginTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'uchet_deal_product_row_margin';
    }

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\IntegerField('OWNER_ID'),
            new Entity\StringField('OWNER_TYPE_ID'),
            new Entity\IntegerField('PRODUCT_ROW_ID'),
            new Entity\IntegerField('MARGIN'),
           new Entity\FloatField('QUOTE_PRICE_INITIAL'),
        );
    }
}