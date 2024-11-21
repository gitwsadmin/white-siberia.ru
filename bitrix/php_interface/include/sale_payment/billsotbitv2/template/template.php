<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

\Bitrix\Main\Loader::includeModule('sotbit.bill');
$bill = new \Sotbit\Bill\Document\Template();
if ($bill->issetTemplate()) {
    $bill->setTemplateStyle('body { max-width:720px; padding: 42px}');
    print $bill->renderTemplate($payment);
} else {
    ShowError(\Bitrix\Main\Localization\Loc::getMessage("DOCUMENTS_TEMPLATES_ERROR_TEMPLATE_NOT_FOUND"));
}




