<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<script>
    var componentCityParams = <?=\Bitrix\Main\Web\Json::encode($arParams)?>;
</script>

<div class="alert alert-danger" id="message" role="alert">
    Добрый день.
    1 - Поигрался с Ajax встроенным<br>
    Что нужно доработать( Времени к сожалению мало свободного=((( ):<br>
    1 - Валидацию<br>
    2 - Верстку надо причесывать.<br>
    3 - Локализацию вынести в файлы<br>

    Доступ к сайту:<br>
    Логин:admin<br>
    Пароль:adminadmin
    <br>
    Git: https://github.com/jhonSpb/test-work.git

</div>
<br>
<div id="cities-wrapper">

</div>
<div id="js-modal-change-city" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
