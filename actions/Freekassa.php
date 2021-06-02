<?php
$configs = array('secret' => 'dt7zrfp5',
                 'ShopID' => '97052');
class Freekassa
{
    public function GenerateUri($id, $value)
    {
        global $configs;
        $shopid = $configs['ShopID'];
        $secret = $configs['secret'];
        $hash = md5("$shopid:$value:$secret:$id");
        return "http://www.free-kassa.ru/merchant/cash.php?m=$shopid&oa=$value&o=$id&s=$hash&lang=ru&i=&em=";
    }
}