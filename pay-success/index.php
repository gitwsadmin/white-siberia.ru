<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Успешно оплачено");

//echo $USER->GetId();

if($USER->GetID()) {
    $db_sales = CSaleOrder::GetList(['DATE_INSERT' => 'DESC'], ['USER_ID' => $USER->GetID(),]);
    if($ar_sales = $db_sales->Fetch()) {
        echo 'Номер вашего заказа: '.$ar_sales['ID'];
    }
}
?><br><br>Заказ оплачен, ожидайте звонка оператора для уточнения деталей доставки.<br>
 <br>
 Если у вас возникнут вопросы звоните по номеру -&nbsp;<a href="tel:88005550014">8 (800) 555-00-14</a><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>