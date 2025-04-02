<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Если у Вас возникли вопросы-проблемы с нашей техникой! ✅ А также, если наш дилер повел себя некорректно, пожалуйста, напишите рекламацию. ✅ Мы в кратчайшее время решим Вашу проблему.");
$APPLICATION->SetPageProperty("title", "Рекламации | White Siberia");
$APPLICATION->SetTitle("Рекламации");
?><p>
</p>
<div>
</div>
<h2>Уважаемые клиенты!<br>
 </h2>
 Если у Вас возникли вопросы-проблемы с нашей техникой! А также, если наш дилер повел<br>
 себя некорректно, пожалуйста, напишите рекламацию.<br>
 Мы в кратчайшее время решим Вашу проблему.<br>
 <br>
 <?$APPLICATION->IncludeComponent(
	"bitrix:form", 
	"inline", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_ADDITIONAL" => "N",
		"EDIT_STATUS" => "Y",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"NOT_SHOW_FILTER" => "",
		"NOT_SHOW_TABLE" => "",
		"RESULT_ID" => "SIMPLE_FORM_12",
		"SEF_MODE" => "N",
		"SHOW_ADDITIONAL" => "N",
		"SHOW_ANSWER_VALUE" => "N",
		"SHOW_EDIT_PAGE" => "Y",
		"SHOW_LIST_PAGE" => "Y",
		"SHOW_STATUS" => "Y",
		"SHOW_VIEW_PAGE" => "Y",
		"START_PAGE" => "new",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "SIMPLE_FORM_12",
		"COMPONENT_TEMPLATE" => "inline",
		"VARIABLE_ALIASES" => array(
			"action" => "action",
		)
	),
	false
);?><br>
<p>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>