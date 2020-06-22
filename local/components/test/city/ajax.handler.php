<?
use \Bitrix\Catalog;

define('STOP_STATISTICS', true);

require_once($_SERVER['DOCUMENT_ROOT']. '/bitrix/modules/main/include/prolog_before.php');

if($action == 'viewed') {
    \Bitrix\Main\Loader::includeModule('catalog');
    \Bitrix\Main\Loader::includeModule('sale');
    $skipUserInit = false;
    if (!Catalog\Product\Basket::isNotCrawler()) {
        $skipUserInit = true;
    }

    $basketUserId = (int)CSaleBasket::GetBasketUserID($skipUserInit);

    if ($basketUserId > 0) {
        $ids = array_values(Catalog\CatalogViewedProductTable::getProductSkuMap(
            5,
            false,
            $basketUserId,
            [],
            100,
            100
        ));
    }

    echo count($ids);
}

if($action == 'city-list') {
    $APPLICATION->IncludeComponent(
        'pss:city','',['TYPE' => 'LIST'], false
    );
}