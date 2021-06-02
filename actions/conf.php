<?php
define('debug',true);
if (debug)
{
    error_reporting(E_ERROR | E_PARSE | E_NOTICE);
}
else
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/dbconfig.php';
if (!isset($_COOKIE['cart']))
{
    $cartHash = generateUniqueCart();
    setcookie('cart', $cartHash, time() + 864000, '/');
}
else
{
    $cartHash = $_COOKIE['cart'];
    $id = getCartIdByHash($cartHash);
    if ($id == null)
    {
        $cartHash = generateUniqueCart();
        setcookie('cart', $cartHash, time() + 864000, '/');
    }
}
if ($_SERVER["REQUEST_METHOD"] == 'POST')
{
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'add_to_cart')
    {
        $id = getCartIdByHash($cartHash);
        insertCartItem($_REQUEST['add-to-cart'], $id, $_REQUEST['quantity'], true);
        $data = array('error'       => false,
                      'product_url' => 'https://google.com');
        $addedToCart = true;
    }
}
if ($_SERVER['SCRIPT_NAME'] == '/index.php')
{
    $st = $pdo->prepare('SELECT Product.Id,Name,Price,(SELECT ThumbImage FROM ProductImage WHERE ProductId=Product.Id LIMIT 1) as ThumbImage FROM Product WHERE Available=1;');
    $st->execute();
    $items = $st->fetchAll(PDO::FETCH_OBJ);
}
if ($_SERVER['SCRIPT_NAME'] == '/contact/index.php')
{
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'support')
    {
        $name = $_REQUEST['contact_name'];
        $message = $_REQUEST['field_message'];
        $email = $_REQUEST['contact_email'];
        $admin_email = 'lberianidze@gmail.com';
        $from = 'tsu@tsu.com';
        $title = 'Support message';
        $html_headers = 'MIME-Version: 1.0' . "\r\n";
        $html_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $html_headers .= "From: tsu@tsu.com\r\nReply-To: tsu@tsu.com\r\n" . 'X-Mailer: PHP/' . phpversion();
        $message = '<html><body>';
        $message .= "<p>Name: $name</p>";
        $message .= "<p>Email: $email</p>";
        $message .= "<span>Message: $message</span>";
        $message .= '</body></html>';
        mail($admin_email, $title, $message, $html_headers);
        $message_sent = true;
    }
}
if ($_SERVER['SCRIPT_NAME'] == '/cart/index.php' || $_SERVER['SCRIPT_NAME'] == '/checkout/index.php')
{
    $cart_id = getCartIdByHash($cartHash);
    if (isset($_REQUEST['action']))
    {
        if ($_REQUEST['action'] == 'remove_product')
        {
            $itemId = $_REQUEST['product_id'];
            deleteCartItem($cart_id, $itemId);
        }
        else if ($_REQUEST['action'] == 'update_cart')
        {
            $cart = $_REQUEST['cart'];
            foreach ($cart as $id => $info)
            {
                insertCartItem($id, $cart_id, $info['qty']);
            }
        }
        else if ($_REQUEST['action'] == 'pay')
        {
            require_once __DIR__ . '/Freekassa.php';
            $cartItems = getCartItems($cart_id);
            $fname = $_REQUEST['fname'];
            $lname = $_REQUEST['lname'];
            $city = $_REQUEST['city'];
            $country = $_REQUEST['country'];
            $street_address1 = $_REQUEST['street_address1'];
            $street_address2 = $_REQUEST['street_address2'];
            $zip_code = $_REQUEST['zip_code'];
            $phone = $_REQUEST['phone'];
            $email = $_REQUEST['email'];
            $aditional_info = $_REQUEST['aditional_info'];
            $action = $_REQUEST['action'];
            $orderCode = strtoupper(generateRandomHash(5) . '-' . generateRandomHash(5) . '-' . generateRandomHash(5));
            $total = array_sum(array_map(function (&$item) {
                return $item->Price * $item->Quantity;
            }, $cartItems));
            insertPayment($orderCode,  $total, 0, 1);
            $order_id = insertOrder( $orderCode, $fname, $lname, $country, $street_address1, $street_address2, $city, $zip_code, $phone, $email, $aditional_info, $orderCode,  $total);
            foreach ($cartItems as $cartItem)
            {
                insertOrderItem($order_id, $cartItem->ProductId, $cartItem->Quantity, $cartItem->Price);
            }
            clearCart($cart_id);
            $payment = (new Freekassa())->GenerateUri($orderCode, $total);
            header('Location: ' . $payment);
            exit();
        }
    }
    if ($cart_id != null)
    {
        $coupon = getCart($cart_id);
    }
    $cartItems = getCartItems($cart_id);
}
