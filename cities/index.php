<? require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/header.php'); ?>
<? $APPLICATION->IncludeComponent(
    'test:city', '', [
    'IBLOCK_ID' => 1,
    'PAGE_SIZE' => 50,
    'CACHE_TIME' => 3600,
    'BASE_URL' => '/cities/'
], false
);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/footer.php'); ?>
