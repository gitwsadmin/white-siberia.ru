<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
$APPLICATION->ShowIncludeStat = false;
global $USER;

$redirect = '/';
if ($USER->IsAuthorized()) {
	$arFilter = Array("USER_ID" => $USER->GetID());
	$db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter);
	if ($ar_sales = $db_sales->Fetch()) {
		$redirect = '/personal/order/?ORDER_ID='.$ar_sales['ID'];
	}
}

header("Location: ".$redirect);
die;