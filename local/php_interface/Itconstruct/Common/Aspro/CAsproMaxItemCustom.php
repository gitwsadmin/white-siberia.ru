<?php

namespace Itconstruct\Common\Aspro;

use Bitrix\Main\Localization\Loc;
use \Aspro\Functions\CAsproMaxItem;

class CAsproMaxItemCustom extends CAsproMaxItem 
{
    public static function showImg($arParams = array(), $arItem = array(), $bShowFW = true, $bWrapLink = true, $dopClassImg = '')
    {
        if($arItem):?>
            <?ob_start();?>
            <?if($bWrapLink):?>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb shine">
            <?endif;?>
                <?
                $a_alt = (is_array($arItem["PREVIEW_PICTURE"]) && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem['SELECTED_SKU_IPROPERTY_VALUES'] ? ($arItem["SELECTED_SKU_IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ? $arItem["SELECTED_SKU_IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arItem["NAME"]) : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arItem["NAME"])));

                $a_title = (is_array($arItem["PREVIEW_PICTURE"]) && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem['SELECTED_SKU_IPROPERTY_VALUES'] ? ($arItem["SELECTED_SKU_IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ? $arItem["SELECTED_SKU_IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arItem["NAME"]) : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arItem["NAME"])));

                $bNeedFindSkuPicture = empty($arItem["DETAIL_PICTURE"]) && empty($arItem["PREVIEW_PICTURE"]) && (\CMax::GetFrontParametrValue("SHOW_FIRST_SKU_PICTURE") == "Y") &&  isset($arItem['OFFERS']) && !empty($arItem['OFFERS']);
                $arFirstSkuPicture = array();

                if($bNeedFindSkuPicture){

                    foreach ($arItem['OFFERS'] as $keyOffer => $arOffer)
                    {
                        if (!empty($arOffer['DETAIL_PICTURE'])){
                            $arFirstSkuPicture = $arOffer['DETAIL_PICTURE'];
                            if (!is_array($arFirstSkuPicture)){
                                $arFirstSkuPicture = \CFile::GetFileArray($arOffer['DETAIL_PICTURE']);
                            }
                        } elseif(!empty($arOffer['PREVIEW_PICTURE'])){
                            $arFirstSkuPicture = $arOffer['PREVIEW_PICTURE'];
                            if (!is_array($arFirstSkuPicture)){
                                $arFirstSkuPicture = \CFile::GetFileArray($arOffer['PREVIEW_PICTURE']);
                            }
                        }

                        if(isset($arFirstSkuPicture["ID"])){
                            $arFirstSkuPicture = \CFile::ResizeImageGet($arFirstSkuPicture["ID"], array( "width" => 600, "height" => 450 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );
                        }

                        if(!empty( $arFirstSkuPicture )){
                            break;
                        }
                    }
                }

                ?>

                <?if( !empty($arItem["DETAIL_PICTURE"])):?>
                    <?if(isset($arItem["DETAIL_PICTURE"]["src"])):?>
                        <?$img["src"] = $arItem["DETAIL_PICTURE"]["src"]?>
                    <?else:?>
                        <?$img = \CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array( "width" => 600, "height" => 450 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
                    <?endif;?>
                    <img class="lazy img-responsive <?=$dopClassImg;?>" src="<?=\Aspro\Functions\CAsproMax::showBlankImg($img["src"])?>" data-src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                <?elseif( !empty($arItem["PREVIEW_PICTURE"]) ):?>
                    <img class="lazy img-responsive <?=$dopClassImg;?>" src="<?=\Aspro\Functions\CAsproMax::showBlankImg($arItem["PREVIEW_PICTURE"]["SRC"]);?>" data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                <?elseif( $bNeedFindSkuPicture && !empty( $arFirstSkuPicture ) ):?>
                    <img class="lazy img-responsive <?=$dopClassImg;?>" src="<?=\Aspro\Functions\CAsproMax::showBlankImg($arFirstSkuPicture["src"]);?>" data-src="<?=$arFirstSkuPicture["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                <?else:?>
                    <img class="lazy img-responsive <?=$dopClassImg;?>" src="<?=\Aspro\Functions\CAsproMax::showBlankImg(SITE_TEMPLATE_PATH.'/images/svg/noimage_product.svg');?>" data-src="<?=SITE_TEMPLATE_PATH?>/images/svg/noimage_product.svg" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                <?endif;?>
                <?if($fast_view_text_tmp = \CMax::GetFrontParametrValue('EXPRESSION_FOR_FAST_VIEW'))
                    $fast_view_text = $fast_view_text_tmp;
                else
                    $fast_view_text = Loc::getMessage('FAST_VIEW');?>
            <?if($bWrapLink):?>
            </a>
            <?endif;?>
            <?if($bShowFW):?>
                <div class="fast_view_block wicons rounded2" data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="<?=$arParams["IBLOCK_ID"];?>" data-param-id="<?=$arItem["ID"];?>" data-param-item_href="<?=urlencode($arItem["DETAIL_PAGE_URL"]);?>" data-name="fast_view"><?=\CMax::showIconSvg("fw ncolor", SITE_TEMPLATE_PATH."/images/svg/quickview.svg");?><?=$fast_view_text;?></div>
            <?endif;?>
            <?$html = ob_get_contents();
            ob_end_clean();

            foreach(GetModuleEvents(FUNCTION_MODULE_ID, 'OnAsproShowImg', true) as $arEvent) // event for manipulation item img
                ExecuteModuleEventEx($arEvent, array($arParams, $arItem, $bShowFW, $bWrapLink, $dopClassImg, &$html));

            echo $html;?>
        <?endif;?>
    <?}
}