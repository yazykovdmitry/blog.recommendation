<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
    'NAME'          =>  'Поиск рекомендаций',
    'DESCRIPTION'   =>  'Ищет рекомендации к текущей статье',
    'ICON'          =>  '/images/icon.gif',
    'SORT'          =>  10,
    'CACHE_PATH'    =>  'Y',
    'PATH'          =>  array(
        'ID'    =>  'dd',
        'NAME'  =>  'Языков Дмитрий',
        'CHILD' =>  array(
            'ID'    =>  'blog_preview',
            'NAME'  =>  'Блог',
        ),
    ),
    'COMPLEX' => 'N',
);