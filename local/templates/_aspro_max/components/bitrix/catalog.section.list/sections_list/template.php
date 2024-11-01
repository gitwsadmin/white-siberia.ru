<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><? $this->setFrameMode( true ); ?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult["SECTIONS"]){?>
	<?global $arTheme;
	$iVisibleItemsMenu = CMax::GetFrontParametrValue('MAX_VISIBLE_ITEMS_MENU');
	$bSlide = false;
	$bSlick = ($arParams['NO_MARGIN'] == 'Y');
	$bSmallBlock = ($arParams['VIEW_TYPE'] == 'sm');
	$bSlideBlock = ($arParams['VIEW_TYPE'] == 'slide');
	$bBigBlock = ($arParams['VIEW_TYPE'] == 'lg');
	$bIcons = ($arParams['SHOW_ICONS'] == 'Y');?>
	<div class="catalog_section_list row items<?=($bSlick ? ' margin0' : '');?> flexbox type_<?=$arParams['TEMPLATE_TYPE']?>">
		<?foreach( $arResult["SECTIONS"] as $arItems ){
			$this->AddEditAction($arItems['ID'], $arItems['EDIT_LINK'], CIBlock::GetArrayByID($arItems["IBLOCK_ID"], "SECTION_EDIT"));
			$this->AddDeleteAction($arItems['ID'], $arItems['DELETE_LINK'], CIBlock::GetArrayByID($arItems["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));
		?>
			<div class="item_block lg">
				<div class="section_item item bordered box-shadow" id="<?=$this->GetEditAreaId($arItems['ID']);?>">
					<?\Aspro\Functions\CAsproMaxItem::showSectionImg($arParams, $arItems, $bIcons);?>
					<div class="name"><a href="<?=$arItems["SECTION_PAGE_URL"]?>" class="dark_link"><span class="<?=($bSlideBlock ? 'font_mlg' : 'font_md');?>"><?=$arItems["NAME"]?></span></a>
										<?if($arItems["ELEMENT_CNT"]):?>
											<?if($bBigBlock || $bSlideBlock):?>
												<span class="element-count2 muted font_xs"><?=\Aspro\Functions\CAsproMax::declOfNum($arItems["ELEMENT_CNT"], array(Loc::getMessage('COUNT_ELEMENTS_TITLE'), Loc::getMessage('COUNT_ELEMENTS_TITLE_2'), Loc::getMessage('COUNT_ELEMENTS_TITLE_3')))?></span>
											<?else:?>
												<span class="element-count muted font_xxs rounded3"><?=$arItems["ELEMENT_CNT"];?></span>
											<?endif;?>
										<?endif;?>
									</div>
				</div>
			</div>
		<?}?>
	</div>
<?}?>