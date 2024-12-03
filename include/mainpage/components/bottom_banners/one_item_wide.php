<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$APPLICATION->IncludeComponent(
	"aspro:com.banners.max", 
	"only_img", 
	array(
		"IBLOCK_TYPE" => "aspro_max_adv",
		"IBLOCK_ID" => "42",
		"TYPE_BANNERS_IBLOCK_ID" => "42",
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "RAND",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "ASC",
		"PROPERTY_CODE" => array(
			0 => "URL",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"SIZE_IN_ROW" => "1",
		"WIDE" => "Y",
		"NO_MARGIN" => "N",
		"BG_POSITION" => "center",
		"CACHE_GROUPS" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"BANNER_TYPE_THEME" => "BANNER_IMG_WIDE",
		"COMPONENT_TEMPLATE" => "only_img",
		"FILTER_NAME" => "arRegionLink",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"BANNER_TYPE_THEME_CHILD" => "",
		"SECTION_ID" => "",
		"NEWS_COUNT2" => "20",
		"WIDE_BANNER" => "N",
		"PRICE_CODE" => "",
		"STORES" => array(
			0 => "",
			1 => "",
		),
		"CONVERT_CURRENCY" => "N"
	),
	false
);?>