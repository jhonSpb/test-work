<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>

<div class="modal-header">
    <b class="modal-title">
        <? if (!empty($arResult['ITEM']['ID'])): ?>
            Редктирование города
        <? else: ?>
            Добавление города
        <? endif; ?>
    </b>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form>
        <input type="hidden" name="ID" value="<?= $arResult['ITEM']['ID']?>">
        <div class="alert alert-primary" id="message" role="alert"></div>
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="NAME" value="<?= $arResult['ITEM']['NAME'] ?>" class="form-control">
        </div>
        <div class="form-group">
            <label>Широта</label>
            <input type="text" name="LATITUDE" value="<?= $arResult['ITEM']['PROPERTIES']['LATITUDE']['VALUE'] ?>"
                   class="form-control">
        </div>
        <div class="form-group">
            <label>Долгота</label>
            <input type="text" name="LONGITUDE" value="<?= $arResult['ITEM']['PROPERTIES']['LONGITUDE']['VALUE'] ?>"
                   class="form-control">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary js-button-city-save">Сохранить</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
</div>