<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */

if (!CModule::IncludeModule('iblock')) {
    ShowMessage('Модуль iblock не установлен');
    return false;
}

//  Преобразование параметров
if ($arParams['ELEMENTS_COUNT'] < 1)
    $arParams['ELEMENTS_COUNT'] = 3;

if (empty($arParams['CURRENT_ID']))
    $arParams['CURRENT_ID'] = 0;

$count = $arParams['ELEMENTS_COUNT'];

//  Ищем рекомендации в элементе
$dbEl = CIBlockElement::GetList(
    false,
    array(
        'IBLOCK_ID' =>  $arParams['IBLOCK_ID'],
        'ACTIVE'    =>  'Y',
        'ID'        =>  $arParams['CURRENT_ID'],
    ),
    false,
    false,
    array(
        'ID',
        'PROPERTY_BLOG_RECOMMEND',
    )
);
while ($arEl = $dbEl->GetNext()) {
    if (!empty($arEl['PROPERTY_BLOG_RECOMMEND_VALUE'])){
        $recommendID[] = $arEl['PROPERTY_BLOG_RECOMMEND_VALUE'];    //  ID вручную проставленных рекомендаций
    }
}

if (count($recommendID) > 0) {

    //  Получаем нужные поля рекомендаций
    $dbRecommend = CIBlockElement::GetList(
        false,
        array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTIVE'    => 'Y',
            'ID'        => $recommendID,
            '!ID'       => $arParams['CURRENT_ID'],
        ),
        false,
        array(
            'nTopCount' =>  $count,
        ),
        array(
            'ID',
            'NAME',
            'DETAIL_PAGE_URL',
            'PREVIEW_PICTURE',
        )
    );
    while ($arRecommend = $dbRecommend->GetNext()) {
        $rec[] = $arRecommend;
    }

    if (count($rec) > 0) {
        $count -= count($rec);
        $arResult['ITEMS'] = $rec;
    }

}

//      Собираем поиск
//  Поля из настроек
$arSubFilter = array(
    'LOGIC' =>  'OR',
);
foreach ($arParams['SEARCH'] as $search) {

    //  Bitrix грешит пустыми полями в списках в параметрах компонента
    if (!empty($search)) {

        $arTempFilter = array(
            'LOGIC' =>  'OR',
        );

        foreach ($arParams['PARAMS'] as $param) {

            //  Bitrix грешит пустыми полями в списках в параметрах компонента
            if (!empty($param)) {

                $arTempFilter['?'.$param] = $search;

            }
        }

        $arSubFilter[] = $arTempFilter;

    }

}
//  Стандартные поля
$arFilter = array(
    'IBLOCK_ID' =>  $arParams['IBLOCK_ID'],
    'ACTIVE'    =>  'Y',
    '!ID'       =>  $arParams['CURRENT_ID'],
    $arSubFilter,
);

//  Поля выборки
if (count($arParams['FIELDS']) > 0) {
    $arSelect = array_merge($arParams['FIELDS'], $arParams['PARAMS']);
} else {
    $arSelect = array(
        'ID',
        'NAME',
        'DETAIL_PAGE_URL',
        'PREVIEW_IMAGE',
    );
    $arSelect = array_merge($arSelect, $arParams['PARAMS']);
}


$arSelect = array_merge($arSelect, $arParams['PARAMS']);

//  Поиск
$CIBElement = new CIBlockElement;
$dbElements = $CIBElement->GetList(
    array(
        'RAND'  =>  'ASC',
    ),
    $arFilter,
    false,
    array(
        'nTopCount' =>  $count,
    ),
    $arSelect
);
while ($arElement = $dbElements->GetNext()) {
    $arResult['ITEMS'][] = $arElement;
}

//  Подключение шаблона
$this->IncludeComponentTemplate();