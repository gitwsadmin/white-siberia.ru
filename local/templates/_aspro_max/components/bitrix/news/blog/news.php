<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?// intro text?>
<?global $isHideLeftBlock, $arTheme;?>

<?
if(isset($arParams["TYPE_LEFT_BLOCK"]) && $arParams["TYPE_LEFT_BLOCK"]!='FROM_MODULE'){
	$arTheme['LEFT_BLOCK']['VALUE'] = $arParams["TYPE_LEFT_BLOCK"];
}

if(isset($arParams["SIDE_LEFT_BLOCK"]) && $arParams["SIDE_LEFT_BLOCK"]!='FROM_MODULE'){
	$arTheme['SIDE_MENU']['VALUE'] = $arParams["SIDE_LEFT_BLOCK"];
}

?>
<?
if(!$isHideLeftBlock && $APPLICATION->GetProperty("HIDE_LEFT_BLOCK_LIST") == "N"){
	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
}
?>
<?$bIsHideLeftBlock = ($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") == "N");?>

<div class="text_before_items"><?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => ""
		)
	);?></div>
<?
$arItemFilter = CMax::GetIBlockAllElementsFilter($arParams);

if($arParams['CACHE_GROUPS'] == 'Y')
{
	$arItemFilter['CHECK_PERMISSIONS'] = 'Y';
	$arItemFilter['GROUPS'] = $GLOBALS["USER"]->GetGroups();
}

$itemsCnt = CMaxCache::CIblockElement_GetList(array("CACHE" => array("TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());?>

<?if(!$itemsCnt):?>
	<div class="alert alert-warning"><?=GetMessage("SECTION_EMPTY")?></div>
<?else:?>


	<?$this->EndViewTarget();?>

	<?
	$arAllSections = $aMenuLinksExt = [];
	$arSections = CMaxCache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N', 'URL_TEMPLATE' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'])), array_merge($arItemFilter, array(/*'<=DEPTH_LEVEL' => 2,*/ 'CNT_ACTIVE' => "Y")), false, array('ID', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID'));
	$arSectionsByParentSectionID = CMaxCache::GroupArrayBy($arSections, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));
	if ($arSections) {
		CMax::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt, true);
	}
	
	$arAllSections = CMax::getChilds2($aMenuLinksExt);
	
	if (isset($arItemFilter['CODE'])) {
		unset($arItemFilter['CODE']);
		unset($arItemFilter['SECTION_CODE']);
	}
	if (isset($arItemFilter['ID'])) {
		unset($arItemFilter['ID']);
		unset($arItemFilter['SECTION_ID']);
	}
	?>
	<?
	$arTags = array();
	if ($arAllSections) {
		foreach ($arAllSections as $key => $arSection) {
			$arElements = CMaxCache::CIblockElement_GetList(array('CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), array_merge($arItemFilter, array("SECTION_ID" => $arSection["PARAMS"]["ID"], "INCLUDE_SUBSECTIONS" => "Y")), false, false, array('ID', 'TAGS'));
			if (!$arElements) {
				unset($arAllSections[$key]);
			} else {
				foreach ($arElements as $arElement) {
					if ($arElement['TAGS']) {
						$arTags[] = explode(',', $arElement['TAGS']);
					}
				}
				$arAllSections[$key]['ELEMENT_COUNT'] = count($arElements);
			}
		}
	} else {
		$arElements = CMaxCache::CIblockElement_GetList(array('CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), $arItemFilter, false, false, array('ID', 'TAGS'));

		foreach ($arElements as $arElement) {
			if ($arElement['TAGS']) {
				$arTags[] = explode(',', $arElement['TAGS']);
			}
		}
	}
	?>


		<?$APPLICATION->IncludeComponent(
			"bitrix:search.tags.cloud",
			"main",
			Array(
				"CACHE_TIME" => "86400",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"COLOR_NEW" => "3E74E6",
				"COLOR_OLD" => "C0C0C0",
				"COLOR_TYPE" => "N",
				"TAGS_ELEMENT" => $arTags,
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"FONT_MAX" => "50",
				"FONT_MIN" => "10",
				"PAGE_ELEMENTS" => "150",
				"PERIOD" => "",
				"PERIOD_NEW_TAGS" => "",
				"SHOW_CHAIN" => "N",
				"SORT" => "NAME",
				"TAGS_INHERIT" => "Y",
				"URL_SEARCH" => SITE_DIR."search/index.php",
				"WIDTH" => "100%",
				"arrFILTER" => array("iblock_aspro_max_content"),
				"arrFILTER_iblock_aspro_max_content" => array($arParams["IBLOCK_ID"])
			), $component, array('HIDE_ICONS' => 'Y')
		);?>
	<?$this->__component->__template->EndViewTarget();?>




		
			


	<?// section elements?>
	<?if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y'))
	{
		$APPLICATION->RestartBuffer();
	}?>
	<?if($arAllSections):?>
			<div class="categories_block menu_top_block">
				<ul class="categories left_menu dropdown">
					<li class="categories_item item v_bottom"><a href="/blog/" class="categories_link bordered rounded2">Все статьи</a></li>
					<?foreach($arAllSections as $arSection):
						if(isset($arSection['TEXT']) && $arSection['TEXT']):?>
							<li class="categories_item item v_bottom <?=($arSection['CHILD'] ? 'has-child' : '')?>">
								<a href="<?=$arSection['LINK'];?>" class="categories_link bordered rounded2">
									<span class="categories_name darken"><?=$arSection['TEXT'];?></span>
									<?if ($arSection['CHILD']):?>
										<?=CMax::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/trianglearrow_down.svg', '', '', true, false);?>
										<span class="toggle_block"></span>
									<?endif;?>
								</a>
							</li>
						<?endif;?>
					<?endforeach;?>
				</ul>
			</div>
		<?endif;?>
	<?$sViewElementsTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["BLOG_PAGE"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>
	<?@include_once('page_blocks/'.$sViewElementsTemplate.'.php');?>


	<?if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y'))
	{
		die();
	}?>
<?endif;?>