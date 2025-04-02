<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?global $arMainPageOrder; //global array for order blocks?>
<?global $arTheme, $dopBodyClass;?>
<?if($arMainPageOrder && is_array($arMainPageOrder)):?>
	<?foreach($arMainPageOrder as $key => $optionCode):?>
		<?$strTemplateName = $arTheme['TEMPLATE_PARAMS'][$arTheme['INDEX_TYPE']['VALUE']][$arTheme['INDEX_TYPE']['VALUE'].'_'.$optionCode.'_TEMPLATE']['VALUE'];?>
		<?$subtype = strtolower($optionCode);?>
		
		<?$dopBodyClass .= ' '.$optionCode.'_'.$strTemplateName;?>

		<?//BIG_BANNER_INDEX?>
		<?if($optionCode == "BIG_BANNER_INDEX"):?>
			<?global $bShowBigBanners, $bBigBannersIndexClass;?>
			<?if($bShowBigBanners):?>
				<?$bIndexLongBigBanner = ($strTemplateName != "type_1" && $strTemplateName != "type_4")?>
				<?if(!$bIndexLongBigBanner):?>
					<?$dopBodyClass .= ' right_mainpage_banner';?>
				<?endif;?>

				<?if($bIndexLongBigBanner):?>
					<?ob_start();?>
						<div class="middle">
				<?endif;?>

				<div class="drag-block grey container <?=$optionCode?> <?=$bBigBannersIndexClass?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>

				<?if($bIndexLongBigBanner):?>
						</div>
					<?$html = ob_get_contents();
					ob_end_clean();?>
					<?$APPLICATION->AddViewContent('front_top_big_banner',$html);?>
				<?endif;?>
			<?endif;?>
		<?endif;?>

		<?//STORIES?>
		<?if($optionCode == "STORIES"):?>
			<?global $bShowStories, $bStoriesIndexClass;?>
			<?if($bShowStories):?>
				<div class="drag-block container <?=$optionCode?> <?=$bStoriesIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//TIZERS_INDEX?>
		<?if($optionCode == "TIZERS"):?>
			<?global $bShowTizers, $bTizersIndexClass;?>
			<?if($bShowTizers):?>
				<div class="drag-block container <?=$optionCode?> <?=$bTizersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//CATALOG_SECTIONS?>
		<?if($optionCode == "CATALOG_SECTIONS"):?>
			<?global $bShowCatalogSections, $bCatalogSectionsIndexClass;?>
			<?if($bShowCatalogSections):?>
				<div class="drag-block container <?=$optionCode?> <?=$bCatalogSectionsIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//CATALOG_TAB?>
		<?if($optionCode == "CATALOG_TAB"):?>
			<?global $bShowCatalogTab, $bCatalogTabIndexClass;?>
			<?if($bShowCatalogTab):?>
				<div class="drag-block container grey mwnew <?=$optionCode?> <?=$bCatalogTabIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//MIDDLE_ADV?>
		<?if($optionCode == "MIDDLE_ADV"):?>
			<?global $bShowMiddleAdvBottomBanner, $bMiddleAdvIndexClass;?>
			<?if($bShowMiddleAdvBottomBanner):?>
				<div class="drag-block container <?=$optionCode?> <?=$bMiddleAdvIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//FLOAT_BANNERS?>
		<?if($optionCode == "FLOAT_BANNERS"):?>
			<?global $bShowFloatBanners, $bFloatBannersIndexClass;?>
			<?if($bShowFloatBanners):?>
				<div class="drag-block container <?=$optionCode?> <?=$bFloatBannersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//SALE?>
		<?if($optionCode == "SALE"):?>
			<?global $bShowSale, $bSaleIndexClass;?>
			<?if($bShowSale):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bSaleIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//COLLECTIONS?>
		<?if($optionCode == "COLLECTIONS"):?>
			<?global $bShowCollection, $bCollectionIndexClass;?>
			<?if($bShowCollection):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bCollectionIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//LOOKBOOKS?>
		<?if($optionCode == "LOOKBOOKS"):?>
			<?global $bShowLookbook, $bLookbookIndexClass;?>
			<?if($bShowLookbook):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bLookbookIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//REVIEWS?>
		<?if($optionCode == "REVIEWS"):?>
			<?global $bShowReview, $bReviewIndexClass;?>
			<?if($bShowReview):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bReviewIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//NEWS?>
		<?if($optionCode == "NEWS"):?>
			<?global $bShowNews, $bNewsIndexClass;?>
			<?if($bShowNews):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bNewsIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//BLOG?>
		<?if($optionCode == "BLOG"):?>
			<?global $bShowBlog, $bBlogIndexClass;?>
			<?if($bShowBlog):?>
				<div class="drag-block container <?=$optionCode?> <?=$bBlogIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//BOTTOM_BANNERS?>
		<?if($optionCode == "BOTTOM_BANNERS"):?>
			<?global $bShowBottomBanner, $bBottomBannersIndexClass;?>
			<?if($bShowBottomBanner):?>
				<div class="drag-block container <?=$optionCode?> <?=$bBottomBannersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//COMPANY_TEXT?>
		<?if($optionCode == "COMPANY_TEXT"):?>
			<?global $bShowCompany, $bCompanyTextIndexClass;?>
			<?if($bShowCompany):?>
				<div class="drag-block container <?=$optionCode?> <?=$bCompanyTextIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
				<script type="application/ld+json">
					{
					  "@context": "https://schema.org",
					  "@type": "BreadcrumbList",
					  "itemListElement": [{
					    "@type": "ListItem",
					    "position": 1,
					    "name": "White Siberia",
					    "item": "https://white-siberia.ru/"
					  },{
					    "@type": "ListItem",
					    "position": 2,
					    "name": "&#128293; Электротранспорт №1",
					    "item": "https://white-siberia.ru/#"
					  }]
					}
				</script>

			<?endif;?>
		<?endif;?>

		<?//MAPS?>
		<?if($optionCode == "MAPS"):?>
			<?global $bShowMaps, $bMapsIndexClass;?>
			<?if($bShowMaps):?>
				<div class="drag-block container <?=$optionCode?> <?=$bMapsIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//FAVORIT_ITEM?>
		<?if($optionCode == "FAVORIT_ITEM"):?>
			<?global $bShowFavoritItem, $bFavoritItemIndexClass;?>
			<?if($bShowFavoritItem):?>
				<div class="drag-block container <?=$optionCode?> <?=$bFavoritItemIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//BRANDS?>
		<?if($optionCode == "BRANDS"):?>
			<?global $bShowBrands, $bBrandsIndexClass;?>
			<?if($bShowBrands):?>
				<div class="drag-block container <?=$optionCode?> <?=$bBrandsIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//INSTAGRAMM?>
		<?if($optionCode == "INSTAGRAMM"):?>
			<?global $bShowInstagramm, $bInstagrammIndexClass;?>
			<?if($bShowInstagramm):?>
				<div class="drag-block container <?=$optionCode?> <?=$bInstagrammIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

	<?endforeach;?>
<?endif;?>

<?$APPLICATION->IncludeComponent("bitrix:news.list", "video", array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "69",
		"IBLOCK_TYPE" => "-",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10000",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "VIDEO",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>