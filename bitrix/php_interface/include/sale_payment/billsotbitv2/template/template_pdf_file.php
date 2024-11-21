<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::includeModule('sotbit.bill');
$bill = new \Sotbit\Bill\Document\Template();
if ($bill->issetTemplate()) {
    $bill->setTemplateStyle('* { font-family: DejaVu Serif, sans-serif; font-size: 92%; }');
    $bill->getPdf($payment);
}