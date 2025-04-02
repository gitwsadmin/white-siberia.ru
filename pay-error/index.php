<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Не оплачено");

if($USER->GetID()) {
    $db_sales = CSaleOrder::GetList(['DATE_INSERT' => 'DESC'], ['USER_ID' => $USER->GetID(),]);
    if($ar_sales = $db_sales->Fetch()) {
        echo 'Номер вашего заказа: '.$ar_sales['ID'];
    }
}
?><br><br>Не удается оплатить заказ, попробуйте изменить способ оплаты в корзине. Если у вас остались вопросы - позвоните по номеру:<br>
<a href="tel:88005550014">8 (800) 555-00-14</a>&nbsp;и назовите оператору номер заказа<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>