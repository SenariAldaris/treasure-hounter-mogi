<?php

if(!empty($_GET['MERCHANT_ORDER_ID'])){
    $Functions->redirect('/success');
}

echo $Functions->getIndex("payment_message", ['from' => ['{message}'], 'to' => ['<div class="alert bg-success" role="alert" style="margin-top: 10px;"><span class="glyphicon glyphicon-exclamation-sign"></span> Вы успешно пополнили баланс.</div>']]);

?>