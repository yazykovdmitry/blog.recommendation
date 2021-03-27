<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
//Helpers::dump($arResult);
$this->setFrameMode(true);
?>

<div class="container recommendation-block">
    <div class="row">
        <div class="col-md-12">
            <h3>Не пропустите!</h3>
        </div>

        <?foreach ($arResult['ITEMS'] as $item):?>
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 recommendation">
                <a href="<?=$item['DETAIL_PAGE_URL']?>">
                    <?=CFile::ShowImage($item['PREVIEW_PICTURE'], 200,200)?><br>
                    <?=$item['NAME']?>
                </a>
            </div>
        <?endforeach?>
    </div>
</div>