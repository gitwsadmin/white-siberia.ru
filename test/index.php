<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");
?>

    <? /*<a href="" class="buy_in_sber_credit callback-block animate-load colored" data-event="jqm" data-param-form_id="TOORDER" data-name="callback" data-autoload-product_name="adasdsdsd" data-autoload-product_id="12834">Заказать звонок</a>*/ ?>
    <a href="javascript:void(0);" class="one_click buy_in_sber_credit callback-block animate-load colored" data-item="13684" data-iblockid="55" data-quantity="1" onclick="oneClickBuySber('13684', '55', this)">Заказать звонок</a>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>