<?php
$shop = '97052';
$secret = 'dt7zrfp5';

$sign = md5($shop.':'.$_REQUEST['AMOUNT'].':'.$secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);
if ($sign != $_REQUEST['SIGN'])
{
    exit('Error');
}
require_once 'dbconfig.php';
updatePaymentStatus($_REQUEST['MERCHANT_ORDER_ID'],1);