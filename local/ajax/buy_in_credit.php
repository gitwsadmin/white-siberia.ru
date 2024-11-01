<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php
    use Bitrix\Sale\Order;

    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);

    AddMessage2Log($inputData, 'inputData');
    AddMessage2Log($data, 'data');
    AddMessage2Log($_REQUEST, '$_REQUEST');

    echo 'Подтверждение заказа';

    /*
    $jsonData = '{
          "id": "22c5d0f0-000f-5000-8000-13ece77bc6c1",
          "status": "succeeded",
          "paid": true,
          "amount": {
            "value": "5000.00",
            "currency": "RUB"
          },
          "income_amount": {
            "value": "4825.00",
            "currency": "RUB"
          },
          "captured_at": "2021-06-22T21:44:55.506Z",
          "created_at": "2021-06-22T21:43:44.794Z",
          "description": "Заказ №37",
          "metadata": {
            "order_id": "37"
          },
          "payment_method": {
            "type": "sber_loan",
            "id": "22c5d0f0-000f-5000-8000-13ece77bc6c1",
            "saved": false,
            "loan_option": "loan"
          },
          "recipient": {
            "account_id": "100500",
            "gateway_id": "100700"
          },
          "refundable": true,
          "refunded_amount": {
            "value": "0.00",
            "currency": "RUB"
          },
          "test": true
        }';


    $jsonEncode = json_decode($jsonData, true);
    $orderId = $jsonEncode['metadata']['order_id'];
    $orderStatus = $jsonEncode['status'];
    $orderPaid = $jsonEncode['paid'];

    $orderId = 16904;


    $order = Order::load($orderId);

    if ($order && $orderPaid && ($orderStatus == 'waiting_for_capture' || $orderStatus == 'succeeded')) {
        $paymentCollection = $order->getPaymentCollection();
        foreach ($paymentCollection as $payment) {
            if (!$payment->isPaid()) {
                $payment->setPaid('Y');
                $payment->save();
            }
        }
        $order->save();
    } else {
        AddMessage2Log('Заказ ' . $orderId . ' не найден');
    }

    AddMessage2Log($orderId, 'orderId');*/

?>