<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule('iblock')) {
    ShowMessage('Модуль iblock не установлен');
    return false;
}

$iblocks = array(); //  Массив инфоблоков для свойств

//  Список инфоблоков
$dbIBlock = CIBlock::GetList(
    array(
        'ID'  =>  'ASC',
    ),
    false,
    true
);
while ($arIBlock = $dbIBlock->Fetch()) {
    $iblocks[$arIBlock['ID']] = '[' . $arIBlock['ID'] . '] ' . $arIBlock['NAME'] . '(' . $arIBlock['ELEMENT_CNT'] . ')';
}

//  Список свойств
$properties['NAME'] = 'Наименование';
$dbProperties = CIBlockProperty::GetList(
    array(
        'SORT'  =>  'ASC',
        'NAME'  =>  'ASC',
    ),
    array(
        'IBLOCK_ID' =>  $arCurrentValues['IBLOCK_ID'],
        'ACTIVE'    =>  'Y',

    )
);
while ($arProperties = $dbProperties->Fetch()) {
    $properties['PROPERTY_'.$arProperties['CODE']] = $arProperties['NAME'];
}


//формирование массива параметров
$arComponentParameters = array(
    'GROUPS' => array(
    ),
    'PARAMETERS'    =>  array(
        'IBLOCK_ID'  =>  array(
            'PARENT'    =>  'BASE',
            'NAME'      =>  'Инфоблок записей',
            'TYPE'      =>  'LIST',
            'VALUES'    =>  $iblocks,
            'MULTIPLE'  =>  'N',
            'REFRESH'   =>  'Y',
        ),
        'PARAMS'    =>  array(
            'PARENT'    =>  'BASE',
            'NAME'      =>  'Поля по которым осуществляется поиск',
            'TYPE'      =>  'LIST',
            'VALUES'    =>  $properties,
            'MULTIPLE'  =>  'Y',
        ),
        'SEARCH'    =>  array(
            'PARENT'    =>  'BASE',
            'NAME'      =>  'Ключевые строки поиска',
            'TYPE'      =>  'STRING',
            'MULTIPLE'  =>  'Y',
            'ADDITIONAL'=>  'Y',
        ),
        'FIELDS'    =>  array(
            'PARENT'    =>  'BASE',
            'NAME'      =>  'Поля инфоборка',
            'TYPE'      =>  'LIST',
            'VALUES'      =>  array(
                'NAME'              =>  'Наименование',
                'DETAIL_TEXT'       =>  'Детальное описание',
                'DETAIL_PICTURE'    =>  'Детальная картинка',
                'PREVIEW_TEXT'      =>  'Описание для анонса',
                'PREVIEW_PICTURE'   =>  'Картинка для анонса',
                'DETAIL_PAGE_URL'   =>  'URL детальной страницы',
                'LIST_PAGE_URL'     =>  'URL списка',
                'DATE_CREATE'       =>  'Дата создания',
            ),
            'MULTIPLE'  =>  'Y',
        ),
        'ELEMENTS_COUNT'    =>  array(
            'PARENT'    =>  'BASE',
            'NAME'      =>  'Количество элементов',
            'TYPE'      =>  'STRING',
        ),
        'CURRENT_ID'    =>  array(
            'PARENT'    =>  'BASE',
            'NAME'      =>  'ID текущей статьи для выборки'
        ),
    ),
);