<?php

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use \Bitrix\Main\Data\Cache;

Loader::includeModule('iblock');

class CityComponent extends \CBitrixComponent implements Controllerable
{

    const CACHE_NAME = 'cities';
    const CACHE_DIR = 'cities';


    private function prepareDataList($post, $params)
    {
        $pageSize = is_int($params['PAGE_SIZE']) ? $params['PAGE_SIZE'] : 50;
        $parts = parse_url($post['url']);
        parse_str($parts['query'], $query);
        $page = empty($query['PAGEN_1']) ? null : $query['PAGEN_1'];

        $arNavParams = [
            'nPageSize' => $pageSize,
            'bShowAll' => false
        ];

        if (!empty($page)) {
            $arNavParams['iNumPage'] = $page;
        }

        $navigation = CDBResult::GetNavParams($arNavParams);

        $cache = Cache::createInstance();

        if ($cache->initCache($params['CACHE_TIME'], self::CACHE_NAME . '-page-' . $navigation['PAGEN'],
            self::CACHE_DIR)) {
            $items = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $dbResult = \CIBlockElement::GetList(
                ['ID' => 'DESC'],
                [
                    'IBLOCK_ID' => $params['IBLOCK_ID']
                ],
                false,
                $arNavParams,
                [
                    'ID',
                    'NAME',
                    'PROPERTY_LATITUDE',
                    'PROPERTY_LONGITUDE'
                ]
            );

            $navStr = $dbResult->GetPageNavStringEx($navigation, '', '.default', true, null,
                ['BASE_LINK' => $params['BASE_URL']]);

            while ($item = $dbResult->GetNext()) {
                $this->arResult['ITEMS'][] = $item;
            }
            $this->arResult['NAV'] = $navStr;

            ob_start();
            $this->includeComponentTemplate('items');
            $items = ob_get_contents();
            $cache->endDataCache($items);
        }

        return $items;
    }

    public function configureActions()
    {
        return [
            'items' => [
                'prefilters' => [],
            ],
            'show' => [
                'prefilters' => [],
            ],
            'delete' => [
                'prefilters' => [],
            ],
            'save' => [
                'prefilters' => [],
            ]
        ];
    }

    public function deleteAction($post, $params)
    {
        $id = $post['id'];
        \CIBlockElement::Delete($id);

        $cache = Cache::createInstance();
        $cache->cleanDir(self::CACHE_DIR);

        return $this->itemsAction($post, $params);
    }

    public function itemsAction($post, $params)
    {
        $result = $this->prepareDataList($post, $params);
        return ['cities' => $result];
    }

    public function showAction($post, $params)
    {
        $id = $post['id'];

        if (!empty($id)) {
            $dbResult = CIBlockElement::GetByID($id);
            if ($element = $dbResult->GetNextElement()) {
                $this->arResult['ITEM'] = $element->GetFields();
                $this->arResult['ITEM']['PROPERTIES'] = $element->GetProperties();
            }
        }
        ob_start();
        $this->includeComponentTemplate('item');
        $item = ob_get_contents();
        return ['item' => $item];
    }


    public function saveAction($post, $params)
    {
        $id = $post['ID'];

        if (empty($post['NAME'])) {
            return [
                'status' => 'error',
                'message' => 'Назван обязаельно для заполнения'
            ];
        }

        if (!empty($id)) {
            $element = new \CIBlockElement;
            $res = $element->Update($id, [
                'NAME' => $post['NAME']
            ]);

            \CIBlockElement::SetPropertyValuesEx($id, $params['IBLOCK_ID'], [
                'LATITUDE' => $post['LATITUDE'],
                'LONGITUDE' => $post['LONGITUDE']
            ]);
        } else {
            $element = new \CIBlockElement;
            $res = $element->Add([
                'IBLOCK_ID' => $params['IBLOCK_ID'],
                'PROPERTY_VALUES' => [
                    'LATITUDE' => $post['LATITUDE'],
                    'LONGITUDE' => $post['LONGITUDE']
                ],
                'NAME' => $post['NAME']
            ]);
        }

        $cache = Cache::createInstance();
        $cache->cleanDir(self::CACHE_DIR);

        return $this->itemsAction($post, $params);
    }


    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}