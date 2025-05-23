<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\PriceMaths;
global $APPLICATION, $arRegion;

/**
 *
 * This file modifies result for every request (including AJAX).
 * Use it to edit output result for "{{ mustache }}" templates.
 *
 * @var array $result
 */

$mobileColumns = isset($this->arParams['COLUMNS_LIST_MOBILE'])
	? $this->arParams['COLUMNS_LIST_MOBILE']
	: $this->arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);

$result['BASKET_ITEM_RENDER_DATA'] = array();

$servicesIblockId = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_IBLOCK_ID", CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_services"][0]);
$catalogIblockId = \Bitrix\Main\Config\Option::get("aspro.max", "CATALOG_IBLOCK_ID", CMaxCache::$arIBlocks[SITE_ID]["aspro_max_catalog"]["aspro_max_catalog"][0]);
$bCache = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_CACHE", 'N') === 'Y';
$cacheTime = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_CACHE_TIME", '36000');
$showOldPrice = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_SHOW_OLD_PRICE", 'Y');
$countInAnnounce = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_COUNT_IN_ANNOUNCE", '2');
$priceType = explode(",", \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_PRICE_TYPE", 'BASE'));
$cacheGroups = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_CACHE_GROUPS", 'N');
$convertCurrency = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_CURRENCY", 'N');
$priceVat = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_PRICE_VAT_INCLUDE", 'Y');
$bConvertCurrency = $convertCurrency === 'N';
$bServicesRegionality = \Bitrix\Main\Config\Option::get("aspro.max", "SERVICES_REGIONALITY", 'N') === 'Y'
						&& \Bitrix\Main\Config\Option::get("aspro.max", "USE_REGIONALITY", 'N') === 'Y'
						&& \Bitrix\Main\Config\Option::get("aspro.max", "REGIONALITY_FILTER_ITEM", 'N') === 'Y';

if($arRegion)
{
	if($arRegion['LIST_PRICES'])
	{
		if(reset($arRegion['LIST_PRICES']) != 'component'){
			$priceType = array_keys($arRegion['LIST_PRICES']);
		}
	}
}

/**/
$link_services_in_basket = array();
foreach ($this->basketItems as $arItem)
{
	/*fill buy services array */
	if($arItem["PROPS"]){
		$arPropsByCode = array_column($arItem["PROPS"], NULL , "CODE");
		$isServices = isset($arPropsByCode["ASPRO_BUY_PRODUCT_ID"]) && $arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"]>0;
		$services_info = array();
		if($isServices){
			//$arResult["GRID"]["BUY_SERVICES"]['SERVICES'][$arItem["ID"]] = $arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"];
			$services_info['BASKET_ID'] = $arItem["ID"];
			$services_info['PRODUCT_ID'] = $arItem["PRODUCT_ID"];
			$services_info['QUANTITY'] = $arItem["QUANTITY"];
			$services_info['PRICE_FORMATED'] = $arItem["PRICE_FORMATED"];
			$services_info['FULL_PRICE_FORMATED'] = $arItem["FULL_PRICE_FORMATED"];
			$services_info['SUM_FORMATED'] = $arItem["SUM"];
			$services_info['SUM_FULL_PRICE_FORMATED'] = $arItem["SUM_FULL_PRICE_FORMATED"];
			$services_info['NEED_SHOW_OLD_SUM'] = $arItem["SUM_DISCOUNT_PRICE"] > 0 ? 'Y' : 'N';
			$services_info['CURRENCY'] = $arItem["CURRENCY"];
			$link_services_in_basket[$arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"]][$arItem["PRODUCT_ID"]] = $services_info;
		}
	}
	/**/
}
/**/
$arServices = $arItems = [
	'COUNT' => 0,
	'SUMM' => 0
];
foreach ($this->basketItems as $row)
{
	$buyServices = false;
	$isServices = false;
	$linkServices = $arParamsForServ = $itemForServ = array();
	if($row['DELAY'] !== 'Y'){
		if($row["PROPS"]){
			$arPropsByCode = array_column($row["PROPS"], NULL , "CODE");
			$isServices = isset($arPropsByCode["ASPRO_BUY_PRODUCT_ID"]) && $arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"]>0;
			$idParentProduct = $arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"];
		}

		$row["LINK_SERVICES"] = array();
		if(is_array($link_services_in_basket) && count($link_services_in_basket) > 0){
			if( isset($link_services_in_basket[$row["PRODUCT_ID"]]) ){
				$row["LINK_SERVICES"] = $link_services_in_basket[$row["PRODUCT_ID"]];
			}
		}
		$productId = CCatalogSku::GetProductInfo($row['PRODUCT_ID']);
		$productId = is_array($productId) ? $productId['ID'] : $row["PRODUCT_ID"];
		$arElementFilter = array("ID" => $productId);
		//CMax::makeElementFilterInRegion($arElementFilter);

		$arElement = CMaxCache::CIBLockElement_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CMaxCache::GetIBlockCacheTag($catalogIblockId))), $arElementFilter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_SERVICES"));
		if($arElement["PROPERTY_SERVICES_VALUE"]){
			if(is_array($arElement["PROPERTY_SERVICES_VALUE"])){
				$arServicesFromProp = $arElement["PROPERTY_SERVICES_VALUE"];
			} else {
				$arServicesFromProp = array( $arElement["PROPERTY_SERVICES_VALUE"]);
			}
			$itemForServ["DISPLAY_PROPERTIES"]['SERVICES']["VALUE"] = $arServicesFromProp;
		}
		$arParamsForServ["IBLOCK_SERVICES_ID"] = $servicesIblockId;
		$arParamsForServ["IBLOCK_ID"] = $catalogIblockId;
		$itemForServ["ID"]= $arElement["ID"];
		$linkServices = \Aspro\Functions\CAsproMax::getLinkedItems($itemForServ, "SERVICES", $arParamsForServ);


		if($linkServices){
			$GLOBALS['arBuyServicesFilterBasketPage']['ID'] = $linkServices;
			$GLOBALS['arBuyServicesFilterBasketPage']['PROPERTY_ALLOW_BUY_VALUE'] = 'Y';
			if($bServicesRegionality && isset($arRegion['ID'])){
				$GLOBALS['arBuyServicesFilterBasketPage'][] = array( "PROPERTY_LINK_REGION" => $arRegion['ID'] );
			}
			ob_start();
			$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"services_list",
				[
					'IBLOCK_ID' => $servicesIblockId,
					'PRICE_CODE' => $priceType,
					'FILTER_NAME' => 'arBuyServicesFilterBasketPage',
					'PROPERTIES' => [],
					"SHOW_OLD_PRICE" => $showOldPrice,
					'CACHE_TYPE' => $bCache && empty($row["LINK_SERVICES"]) ? 'A' : 'N',
					'CACHE_TIME' => $cacheTime,
					'CACHE_GROUPS' => $cacheGroups,
					"CACHE_FILTER" => 'Y',
					'SHOW_ALL_WO_SECTION' => 'Y',
					"CONVERT_CURRENCY" => $convertCurrency === 'N' ? 'N' : 'Y',
					"CURRENCY_ID" => $convertCurrency === 'N' ? 'RUB' : $convertCurrency,
					"PRICE_VAT_INCLUDE" => $priceVat,
					"PAGE_ELEMENT_COUNT" => '100',
					"COUNT_SERVICES_IN_ANNOUNCE" => $countInAnnounce,
					"COMPACT_MODE" => 'Y',
					"SHOW_ALL_IN_SLIDE" => 'Y',
					"SERVICES_IN_BASKET" => is_array($row["LINK_SERVICES"]) ? $row["LINK_SERVICES"] : array(),
					"PLACE_ID" => 'page_basket',
                    "COMPATIBLE_MODE" => "Y"
				],
				false, array("HIDE_ICONS"=>"Y")
			);
			$htmlBuyServices=ob_get_clean();
			if($htmlBuyServices && trim($htmlBuyServices) && strpos($htmlBuyServices, 'error') === false){
				$buyServices = true;
			}
		}

		if ($isServices) {
			$arServices['COUNT'] += 1;
			$arServices['SUMM'] += $row['PRICE'] * $row['QUANTITY'];
		} else {
			$arItems['COUNT'] += 1;
			$arItems['SUMM'] += $row['PRICE'] * $row['QUANTITY'];
		}
	}

	$rowData = array(
		'ID' => $row['ID'],
		'PRODUCT_ID' => $row['PRODUCT_ID'],
		'IBLOCK_ID' => CIBlockElement::GetIBlockByID($row['PRODUCT_ID']),
		'NAME' => isset($row['~NAME']) ? $row['~NAME'] : $row['NAME'],
		'QUANTITY' => $row['QUANTITY'],
		'PROPS' => $row['PROPS'],
		'PROPS_ALL' => $row['PROPS_ALL'],
		'HASH' => $row['HASH'],
		'SORT' => $row['SORT'],
		'DETAIL_PAGE_URL' => $row['DETAIL_PAGE_URL'],
		'CURRENCY' => $row['CURRENCY'],
		'DISCOUNT_PRICE_PERCENT' => $row['DISCOUNT_PRICE_PERCENT'],
		'DISCOUNT_PRICE_PERCENT_FORMATED' => $row['DISCOUNT_PRICE_PERCENT_FORMATED'],
		'SHOW_DISCOUNT_PRICE' => (float)$row['DISCOUNT_PRICE'] > 0,
		'PRICE' => $row['PRICE'],
		'PRICE_FORMATED' => $row['PRICE_FORMATED'],
		'FULL_PRICE' => $row['FULL_PRICE'],
		'FULL_PRICE_FORMATED' => $row['FULL_PRICE_FORMATED'],
		'DISCOUNT_PRICE' => $row['DISCOUNT_PRICE'],
		'DISCOUNT_PRICE_FORMATED' => $row['DISCOUNT_PRICE_FORMATED'],
		'SUM_PRICE' => $row['SUM_VALUE'],
		'SUM_PRICE_FORMATED' => $row['SUM'],
		'SUM_FULL_PRICE' => $row['SUM_FULL_PRICE'],
		'SUM_FULL_PRICE_FORMATED' => $row['SUM_FULL_PRICE_FORMATED'],
		'SUM_DISCOUNT_PRICE' => $row['SUM_DISCOUNT_PRICE'],
		'SUM_DISCOUNT_PRICE_FORMATED' => $row['SUM_DISCOUNT_PRICE_FORMATED'],
		'MEASURE_RATIO' => isset($row['MEASURE_RATIO']) ? $row['MEASURE_RATIO'] : 1,
		'MEASURE_TEXT' => $row['MEASURE_TEXT'],
		'AVAILABLE_QUANTITY' => $row['AVAILABLE_QUANTITY'],
		'CHECK_MAX_QUANTITY' => $row['CHECK_MAX_QUANTITY'],
		'MODULE' => $row['MODULE'],
		'PRODUCT_PROVIDER_CLASS' => $row['PRODUCT_PROVIDER_CLASS'],
		'NOT_AVAILABLE' => $row['NOT_AVAILABLE'] === true,
		'DELAYED' => $row['DELAY'] === 'Y',
		'SKU_BLOCK_LIST' => array(),
		'COLUMN_LIST' => array(),
		'SHOW_LABEL' => false,
		'LABEL_VALUES' => array(),
		'BRAND' => isset($row[$this->arParams['BRAND_PROPERTY'].'_VALUE'])
			? $row[$this->arParams['BRAND_PROPERTY'].'_VALUE']
			: '',
		'LINK_SERVICES_HTML' => $buyServices ? $htmlBuyServices : '',
		'WITH_SERVICES_CLASS' => $buyServices ? 'with-services' : '',
		'SERVICES_CLASS' => $isServices ? 'hidden' : '',
		'IS_SERVICES' => $isServices,
		'HAS_SERVICES' => $buyServices,
	);
	$typeStickers = \Bitrix\Main\Config\Option::get('aspro.max', 'ITEM_STICKER_CLASS_SOURCE', 'PROPERTY_VALUE', $rowData['LID']);
	$arProps = [];
	$rsProps = CIBlockElement::GetProperty(
		$rowData['IBLOCK_ID'],
		$row['PRODUCT_ID'],
		"sort", "asc",
		array("CODE" => "HIT")
	);
    while ($arProp = $rsProps->Fetch()) {
		if ($arProp['VALUE_ENUM']) {
			$arProps[] = [
				'VALUE' => $arProp['VALUE_ENUM'],
				'CODE' => strtolower($arProp['VALUE_XML_ID']),
				'CLASS' => 'sticker_'.($typeStickers === 'PROPERTY_VALUE' ? CUtil::translit($arProp['VALUE_ENUM'], 'ru') : strtolower($arProp['VALUE_XML_ID']))
			];
		}
    }
	$rowData['STICKERS'] = $arProps;

	// show price including ratio
	if ($rowData['MEASURE_RATIO'] != 1)
	{
		$price = PriceMaths::roundPrecision($rowData['PRICE'] * $rowData['MEASURE_RATIO']);
		if ($price != $rowData['PRICE'])
		{
			$rowData['PRICE'] = $price;
			$rowData['PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($price, $rowData['CURRENCY'], true);
		}

		$fullPrice = PriceMaths::roundPrecision($rowData['FULL_PRICE'] * $rowData['MEASURE_RATIO']);
		if ($fullPrice != $rowData['FULL_PRICE'])
		{
			$rowData['FULL_PRICE'] = $fullPrice;
			$rowData['FULL_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($fullPrice, $rowData['CURRENCY'], true);
		}

		$discountPrice = PriceMaths::roundPrecision($rowData['DISCOUNT_PRICE'] * $rowData['MEASURE_RATIO']);
		if ($discountPrice != $rowData['DISCOUNT_PRICE'])
		{
			$rowData['DISCOUNT_PRICE'] = $discountPrice;
			$rowData['DISCOUNT_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($discountPrice, $rowData['CURRENCY'], true);
		}
	}

	$rowData['SHOW_PRICE_FOR'] = (float)$rowData['QUANTITY'] !== (float)$rowData['MEASURE_RATIO'];

	$hideDetailPicture = false;

	if (!empty($row['PREVIEW_PICTURE_SRC']))
	{
		$rowData['IMAGE_URL'] = $row['PREVIEW_PICTURE_SRC'];
	}
	elseif (!empty($row['DETAIL_PICTURE_SRC']))
	{
		$hideDetailPicture = true;
		$rowData['IMAGE_URL'] = $row['DETAIL_PICTURE_SRC'];
	}

	if (!empty($row['SKU_DATA']))
	{
		$propMap = array();

		foreach($row['PROPS'] as $prop)
		{
			$propMap[$prop['CODE']] = !empty($prop['~VALUE']) ? $prop['~VALUE'] : $prop['VALUE'];
		}

		$notSelectable = true;

		foreach ($row['SKU_DATA'] as $skuBlock)
		{
			$skuBlockData = array(
				'ID' => $skuBlock['ID'],
				'CODE' => $skuBlock['CODE'],
				'NAME' => $skuBlock['NAME']
			);

			$isSkuSelected = false;
			$isImageProperty = false;

			if (count($skuBlock['VALUES']) > 1)
			{
				$notSelectable = false;
			}

			foreach ($skuBlock['VALUES'] as $skuItem)
			{
				if ($skuBlock['TYPE'] === 'S' && $skuBlock['USER_TYPE'] === 'directory')
				{
					$valueId = $skuItem['XML_ID'];
				}
				elseif ($skuBlock['TYPE'] === 'E')
				{
					$valueId = $skuItem['ID'];
				}
				else
				{
					$valueId = $skuItem['NAME'];
				}

				$skuValue = array(
					'ID' => $skuItem['ID'],
					'NAME' => $skuItem['NAME'],
					'SORT' => $skuItem['SORT'],
					'PICT' => !empty($skuItem['PICT']) ? $skuItem['PICT']['SRC'] : false,
					'XML_ID' => !empty($skuItem['XML_ID']) ? $skuItem['XML_ID'] : false,
					'VALUE_ID' => $valueId,
					'PROP_ID' => $skuBlock['ID'],
					'PROP_CODE' => $skuBlock['CODE']
				);

				if (
					!empty($propMap[$skuBlockData['CODE']])
					&& ($propMap[$skuBlockData['CODE']] == $skuItem['NAME'] || $propMap[$skuBlockData['CODE']] == $skuItem['XML_ID'])
				)
				{
					$skuValue['SELECTED'] = true;
					$isSkuSelected = true;
				}

				$skuBlockData['SKU_VALUES_LIST'][] = $skuValue;
				$isImageProperty = $isImageProperty || !empty($skuItem['PICT']);
			}

			if (!$isSkuSelected && !empty($skuBlockData['SKU_VALUES_LIST'][0]))
			{
				$skuBlockData['SKU_VALUES_LIST'][0]['SELECTED'] = true;
			}

			$skuBlockData['IS_IMAGE'] = $isImageProperty;

			$rowData['SKU_BLOCK_LIST'][] = $skuBlockData;
		}
	}

	if ($row['NOT_AVAILABLE'])
	{
		foreach ($rowData['SKU_BLOCK_LIST'] as $blockKey => $skuBlock)
		{
			if (!empty($skuBlock['SKU_VALUES_LIST']))
			{
				if ($notSelectable)
				{
					foreach ($skuBlock['SKU_VALUES_LIST'] as $valueKey => $skuValue)
					{
						$rowData['SKU_BLOCK_LIST'][$blockKey]['SKU_VALUES_LIST'][0]['NOT_AVAILABLE_OFFER'] = true;
					}
				}
				elseif (!isset($rowData['SKU_BLOCK_LIST'][$blockKey + 1]))
				{
					foreach ($skuBlock['SKU_VALUES_LIST'] as $valueKey => $skuValue)
					{
						if ($skuValue['SELECTED'])
						{
							$rowData['SKU_BLOCK_LIST'][$blockKey]['SKU_VALUES_LIST'][$valueKey]['NOT_AVAILABLE_OFFER'] = true;
						}
					}
				}
			}
		}
	}

	if (!empty($result['GRID']['HEADERS']) && is_array($result['GRID']['HEADERS']))
	{
		$skipHeaders = [
			'NAME' => true,
			'QUANTITY' => true,
			'PRICE' => true,
			'PREVIEW_PICTURE' => true,
			'SUM' => true,
			'PROPS' => true,
			'DELETE' => true,
			'DELAY' => true,
		];

		foreach ($result['GRID']['HEADERS'] as &$value)
		{
			if (
				empty($value['id'])
				|| isset($skipHeaders[$value['id']])
				|| ($hideDetailPicture && $value['id'] === 'DETAIL_PICTURE'))
			{
				continue;
			}

			if ($value['id'] === 'DETAIL_PICTURE')
			{
				$value['name'] = Loc::getMessage('SBB_DETAIL_PICTURE_NAME');

				if (!empty($row['DETAIL_PICTURE_SRC']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => array(
							array(
								'IMAGE_SRC' => $row['DETAIL_PICTURE_SRC'],
								'IMAGE_SRC_2X' => $row['DETAIL_PICTURE_SRC_2X'],
								'IMAGE_SRC_ORIGINAL' => $row['DETAIL_PICTURE_SRC_ORIGINAL'],
								'INDEX' => 0
							)
						),
						'IS_IMAGE' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'PREVIEW_TEXT')
			{
				$value['name'] = Loc::getMessage('SBB_PREVIEW_TEXT_NAME');

				if ($row['PREVIEW_TEXT_TYPE'] === 'text' && !empty($row['PREVIEW_TEXT']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['PREVIEW_TEXT'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'TYPE')
			{
				$value['name'] = Loc::getMessage('SBB_PRICE_TYPE_NAME');

				if (!empty($row['NOTES']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => isset($row['~NOTES']) ? $row['~NOTES'] : $row['NOTES'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'DISCOUNT')
			{
				$value['name'] = Loc::getMessage('SBB_DISCOUNT_NAME');

				if ($row['DISCOUNT_PRICE_PERCENT'] > 0 && !empty($row['DISCOUNT_PRICE_PERCENT_FORMATED']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['DISCOUNT_PRICE_PERCENT_FORMATED'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'WEIGHT')
			{
				$value['name'] = Loc::getMessage('SBB_WEIGHT_NAME');

				if (!empty($row['WEIGHT_FORMATED']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['WEIGHT_FORMATED'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif (!empty($row[$value['id'].'_SRC']))
			{
				$i = 0;

				foreach ($row[$value['id'].'_SRC'] as &$image)
				{
					$image['INDEX'] = $i++;
				}

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $row[$value['id'].'_SRC'],
					'IS_IMAGE' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id'].'_DISPLAY']))
			{
				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $row[$value['id'].'_DISPLAY'],
					'IS_TEXT' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id'].'_LINK']))
			{
				$linkValues = array();

				foreach ($row[$value['id'].'_LINK'] as $index => $link)
				{
					$linkValues[] = array(
						'LINK' => $link,
						'IS_LAST' => !isset($row[$value['id'].'_LINK'][$index + 1])
					);
				}

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $linkValues,
					'IS_LINK' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id']]))
			{
				$rawValue = isset($row['~'.$value['id']]) ? $row['~'.$value['id']] : $row[$value['id']];
				$isHtml = !empty($row[$value['id'].'_HTML']);

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $rawValue,
					'IS_TEXT' => !$isHtml,
					'IS_HTML' => $isHtml,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
		}

		unset($value);
	}

	if (!empty($row['LABEL_ARRAY_VALUE']))
	{
		$labels = array();

		foreach ($row['LABEL_ARRAY_VALUE'] as $code => $value)
		{
			$labels[] = array(
				'NAME' => $value,
				'HIDE_MOBILE' => !isset($this->arParams['LABEL_PROP_MOBILE'][$code])
			);
		}

		$rowData['SHOW_LABEL'] = true;
		$rowData['LABEL_VALUES'] = $labels;
	}

	$result['BASKET_ITEM_RENDER_DATA'][] = $rowData;
}
$result['SERVICES_RENDER_DATA'] = $arServices;
$result['ITEMS_RENDER_DATA'] = $arItems;

$totalData = array(
	'DISABLE_CHECKOUT' => (int)$result['ORDERABLE_BASKET_ITEMS_COUNT'] === 0,
	'PRICE' => $result['allSum'],
	'PRICE_FORMATED' => $result['allSum_FORMATED'],
	'PRICE_WITHOUT_DISCOUNT_FORMATED' => $result['PRICE_WITHOUT_DISCOUNT'],
	'CURRENCY' => $result['CURRENCY'],
);

if ($arServices['COUNT']) {
	$totalData['SERVICES_COUNT'] = $arServices['COUNT'];
	$totalData['SERVICES_SUMM'] = CCurrencyLang::CurrencyFormat($arServices['SUMM'], $rowData['CURRENCY'], true);

	$totalData['ITEMS_COUNT'] = $arItems['COUNT'];
	$totalData['ITEMS_SUMM'] = CCurrencyLang::CurrencyFormat($arItems['SUMM'], $rowData['CURRENCY'], true);
}

if ($result['DISCOUNT_PRICE_ALL'] > 0)
{
	$totalData['DISCOUNT_PRICE_FORMATED'] = $result['DISCOUNT_PRICE_FORMATED'];
}

if ($result['allWeight'] > 0)
{
	$totalData['WEIGHT_FORMATED'] = $result['allWeight_FORMATED'];
}

if ($this->priceVatShowValue === 'Y')
{
	$totalData['SHOW_VAT'] = true;
	$totalData['VAT_SUM_FORMATED'] = $result['allVATSum_FORMATED'];
	$totalData['SUM_WITHOUT_VAT_FORMATED'] = $result['allSum_wVAT_FORMATED'];
}

if ($this->hideCoupon !== 'Y' && !empty($result['COUPON_LIST']))
{
	$totalData['HAS_COUPON'] = true;
	$totalData['COUPON_LIST'] = $result['COUPON_LIST'];

	foreach ($totalData['COUPON_LIST'] as &$coupon)
	{
		if ($coupon['JS_STATUS'] === 'ENTERED')
		{
			$coupon['CLASS'] = 'danger';
		}
		elseif ($coupon['JS_STATUS'] === 'APPLYED')
		{
			$coupon['CLASS'] = 'muted';
		}
		else
		{
			$coupon['CLASS'] = 'danger';
		}
	}
}

$result['TOTAL_RENDER_DATA'] = $totalData;