<?
namespace Aspro\Functions;

use Bitrix\Main\Application;
use Bitrix\Main\Web\DOM\Document;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\DOM\CssParser;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Main\IO\File;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

//user custom functions

if(!class_exists("CAsproMaxCustom"))
{
	class CAsproMaxCustom{
		const MODULE_ID = \CMax::moduleID;

        public static function ShowHeaderPhonesMy($class = '', $bFooter = false)
        {
            static $hphones_call;
            global $arTheme;

            $iCalledID = ++$hphones_call;
            $arBackParametrs = \CMax::GetBackParametrsValues(SITE_ID);

            $iCountPhones = ($arRegion ? ($arRegion['PHONES'][0]['PHONE'] ? count($arRegion['PHONES']) : 0) : $arBackParametrs['HEADER_PHONES']);
            $regionID = ($arRegion ? $arRegion['ID'] : '');

            if($arRegion){
                $frame = new \Bitrix\Main\Page\FrameHelper('header-allphones-block'.$iCalledID);
                $frame->begin();
            }

            if ($iCountPhones == 1)
                $iCountPhones++;

            ?>
            <?if($iCountPhones):?>
            <?
            $phone = ($arRegion ? $arRegion['PHONES'][0]['PHONE'] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_0']);
            $href = ($arRegion ? $arRegion['PHONES'][0]['HREF'] : $arBackParametrs['HEADER_PHONES_array_PHONE_HREF_0']);
            if(!strlen($href)){
                $href = 'javascript:;';
            }

            $bHaveIcons = $bHaveDescription = false;

            for($i = 0; $i < $iCountPhones; ++$i){
                if(
                    ( $bHaveIcons = strlen($arRegion ? $arRegion['PHONES'][$i]['ICON'] : $arBackParametrs['HEADER_PHONES_array_PHONE_ICON_'.$i]))
                    || ( $bHaveDescription = strlen($arRegion ? $arRegion['PROPERTY_PHONES_DESCRIPTION'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_DESCRIPTION_'.$i]))
                ){
                    break;
                }
            }
            ?>

            <!-- noindex -->
            <div class="phone with_dropdown<?=($class ? ' '.$class : '')?>">
                <?if($bFooter):?>
                <div class="wrap">
                    <div>
                        <?endif;?>
                        <?=\CMax::showIconSvg("phone", SITE_TEMPLATE_PATH."/images/svg/".($bFooter ? "phone_footer" : "Phone_black").".svg");?><a rel="nofollow" href="<?=$href?>"><?=$phone?></a>
                        <?if($bFooter):?>
                    </div>
                </div>
            <?endif;?>
                <? if( $iCountPhones > 1 || $bHaveIcons || $bHaveDescription ): ?>
                    <div class="dropdown <?=($bHaveIcons ? 'with_icons' : '')?>">
                        <div class="wrap scrollblock">
                            <?for($i = 0; $i < $iCountPhones-1; ++$i):?>
                                <?
                                $phone = ($arRegion ? $arRegion['PHONES'][$i]['PHONE'] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_'.$i]);
                                $href = ($arRegion ? $arRegion['PHONES'][$i]['HREF'] : $arBackParametrs['HEADER_PHONES_array_PHONE_HREF_'.$i]);
                                if(!strlen($href)){
                                    $href = 'javascript:;';
                                }

                                $icon = ($arRegion ? $arRegion['PHONES'][$i]['ICON'] : $arBackParametrs['HEADER_PHONES_array_PHONE_ICON_'.$i]);
                                $icon = (strlen($icon) ? '<span class="icon">'.\Aspro\Max\Iconset::showIcon($icon).'</span>' : '');

                                $description = ($arRegion ? $arRegion['PROPERTY_PHONES_DESCRIPTION'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_DESCRIPTION_'.$i]);
                                $description = (strlen($description) ? '<span class="descr">'.$description.'</span>' : '');
                                ?>
                                <div class="more_phone"><a rel="nofollow" <?=(strlen($description) ? '' : 'class="no-decript"')?> href="<?=$href?>"><?=$icon?><?=$phone?><?=$description?></a></div>
                            <?endfor;?>
                            <?
                            $description = '<span class="descr">Отдел продаж</span>';
                            ?>
                            <div class="more_phone"><a rel="nofollow" href="mailto:sales@white-siberia.ru"><?=$icon?>sales@white-siberia.ru<?=$description?></a></div>
                        </div>
                    </div>
                    <?= \CMax::showIconSvg("down", SITE_TEMPLATE_PATH."/images/svg/trianglearrow_down.svg"); ?>
                <? endif; ?>
            </div>
            <!-- /noindex -->
        <?endif;?>
            <?
            if($arRegion){
                $frame->end();
            }
        }

	}
}?>