<?= $arResult['NAV'] ?>
<br>
<div class="text-right">
    <button data-id="" class="btn btn-primary js-button-city-edit">Добавить</button>
</div>
<br>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Широта</th>
        <th>Долгота</th>
        <th>Редактировать</th>
        <th>Удалить</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($arResult['ITEMS'] as $item): ?>
        <tr class="item">
            <td><?= $item['ID'] ?></td>
            <td><?= $item['NAME'] ?></td>
            <td><?= $item['PROPERTY_LATITUDE_VALUE'] ?></td>
            <td><?= $item['PROPERTY_LONGITUDE_VALUE'] ?></td>
            <td>
                <button data-id="<?= $item['ID'] ?>" class="btn btn-primary js-button-city-edit">Редактировать</button>
            </td>
            <td>
                <button data-id="<?= $item['ID'] ?>" class="btn btn-danger js-button-city-delete">Удалить</button>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
<?= $arResult['NAV'] ?>