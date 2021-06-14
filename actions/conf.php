<?php
$saltOne = '6aD%kXj4w{P$@AA?Jl*hR';
$saltTwo = 'RVjEKUsrh%5$YKdJ{ziJ1';
define('debug', true);
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
$db = new Database();

if (!isset($_COOKIE['cart']))
{
    $cartHash = $db->generateUniqueCart();
    setcookie('cart', $cartHash, time() + 864000, '/');
}
else
{
    $cartHash = $_COOKIE['cart'];
    $id = $db->selectRows('Cart', ['Id'], ['=' => ['CookieHash' => $cartHash]], PDO::FETCH_OBJ, true);
    $id = $id === false ? null : $id->Id;
    if ($id == null)
    {
        $cartHash = $db->generateUniqueCart();
        setcookie('cart', $cartHash, time() + 864000, '/');
    }
}

if (isset($_COOKIE['usr']))
{
    $str = substr($_COOKIE['usr'], 4);
    $user = $db->getUserByHash($str);
    if ($user == null)
    {
        setcookie('usr', '', -1, '/');
    }
}
//check if request is get and person is trying to get into dashboard
if ($_SERVER["REQUEST_METHOD"] == 'GET' && strpos($_SERVER['SCRIPT_NAME'], '/user/') === 0)
{
    if ($_SERVER['SCRIPT_NAME'] == '/user/login.php')
    {
        if (isset($_COOKIE['usr']))
        {
            header('location: /user');
            exit();
        }
    }
    else
    {
        if (!isset($_COOKIE['usr']))
        {
            header('location: /user/login.php');
            exit();
        }
        else
        {
            $str = substr($_COOKIE['usr'], 4);
            $user = $db->getUserByHash($str);
            if ($user == null)
            {
                setcookie('usr', '', -1, '/');
                header('location: /user/login.php');
                exit();
            }
            else
            {
                $userOrders = $db->getUserOrders($user->Id);
            }
        }
    }
    if ($_SERVER['SCRIPT_NAME'] == '/user/admin.php')
    {
        if ($user->Role != 1)
        {
            setcookie('usr', '', -1, '/');
            header('location: /user/login.php');
            exit();
        }
        $users = $db->getAllRows('user');
    }
}
//proccess post request(form,ajax)
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
    if ($action == 'add_to_cart')
    {
        $id = $db->selectRows('Cart', ['Id'], ['=' => ['CookieHash' => $cartHash]], PDO::FETCH_OBJ, true);
        $id = $id === false ? null : $id->Id;
        $db->insertCartItem($_REQUEST['add-to-cart'], $id, $_REQUEST['quantity'], true);
        $data = array('error'       => false,
                      'product_url' => 'https://google.com');
        $addedToCart = true;
    }
    else if ($action == 'register')
    {
        $email = $_REQUEST['email'];
        $password = md5($saltOne . $_REQUEST['password'] . $saltTwo);
        if (!$db->userExists($email))
        {
            $db->insertUser($email, $password);
            $email = 'usr_' . md5($saltOne . $email . $password);
            setcookie('usr', $email, time() + 86400, '/');
            header('location: /user');
            exit();
        }
        else
        {
            $register_error = 'User already exists';
        }
    }
    else if ($action == 'login')
    {
        $email = $_REQUEST['username'];
        $password = md5($saltOne . $_REQUEST['password'] . $saltTwo);
        $user = $db->selectRows('User', '*', ['=' => ['email' => $email]], PDO::FETCH_OBJ, true);
        if ($user != null)
        {
            if ($user->Password == $password)
            {
                $email = 'usr_' . md5($saltOne . $email . $password);
                setcookie('usr', $email, time() + 86400, '/');
                if (!isset($_REQUEST['redirect']))
                {
                    header('location: /user/');
                }
                else
                {
                    header('location: ' . $_REQUEST['redirect']);
                }
                exit();
            }
        }
        $login_error = 'Wrong login or password';
    }
    else if ($action == 'support')
    {
        $name = $_REQUEST['contact_name'];
        $message = $_REQUEST['field_message'];
        $email = $_REQUEST['contact_email'];
        $admin_email = 'lberianidze@gmail.com';
        $from = 'tsu@tsu.com';
        $title = 'Support message';
        $html_headers = 'MIME-Version: 1.0' . "\r\n";
        $html_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $html_headers .= "From: tsu@tsu.com\r\nReply-To: tsu@tsu.com\r\n" . 'X-Mailer: PHP/' . phpversion();
        $message = '<html><body>';
        $message .= "<p>Name: $name</p>";
        $message .= "<p>Email: $email</p>";
        $message .= "<span>Message: $message</span>";
        $message .= '</body></html>';
        mail($admin_email, $title, $message, $html_headers);
        $message_sent = true;
    }
    else if ($action == 'export_user_data')
    {
        $export_user_id = $_REQUEST['user_id'];
        $export_user = $db->selectRows('user', '*', ['=' => ['id' => $export_user_id]], PDO::FETCH_OBJ, true);
        $orders = $db->getUserOrders($export_user_id);
        $summary = 0;
        foreach ($orders as $key => $order)
        {
            $summary += array_sum(array_map(function (&$item) {
                return $item['Price'] * $item['Quantity'];
            }, $order));
        }

        $filename = "/exports/user_$export_user_id.txt";
        $file = fopen(__DIR__ . $filename, "w");
        fwrite($file, 'Email: ' . $export_user->Email . "\n");
        fwrite($file, 'Display Name: ' . $export_user->DisplayName . "\n");
        fwrite($file, 'Register Date: ' . $export_user->RegisterDate . "\n");
        fwrite($file, 'Role: ' . $export_user->Role . "\n\n");
        fwrite($file, 'Orders Count: ' . count($orders) . "\n");
        fwrite($file, 'Summary spent: ' . $summary . " $\n\n");
        $i = 1;
        foreach ($orders as $key => $order)
        {
            fwrite($file, "$i) Order: " . $key . ' ' . $order[0]['OrderDate'] . "\n");
            foreach ($order as $order_item)
            {
                fwrite($file, $order_item['Name'] . ' x ' . $order_item['Quantity'] . ' = ' . $order_item['Quantity'] * $order_item['Price'] . "$\n");
            }
            fwrite($file, "\n");
            $i++;
        }

        fclose($file);
        echo "/actions" . $filename;
        exit();
    }
}

//proccess main page to receive all items
if ($_SERVER['SCRIPT_NAME'] == '/index.php')
{
    $st = $db->getPDO()->prepare('SELECT Product.Id,Name,Price,(SELECT ThumbImage FROM ProductImage WHERE ProductId=Product.Id LIMIT 1) as ThumbImage FROM Product WHERE Available=1;');
    $st->execute();
    $items = $st->fetchAll(PDO::FETCH_OBJ);
}
if ($_SERVER['SCRIPT_NAME'] == '/cart/index.php' || $_SERVER['SCRIPT_NAME'] == '/checkout/index.php')
{
    $cart_id = $db->selectRows('Cart', ['Id'], ['=' => ['CookieHash' => $cartHash]], PDO::FETCH_OBJ, true);
    $cart_id = $cart_id === false ? null : $cart_id->Id;
    if (isset($_REQUEST['action']))
    {
        if ($_REQUEST['action'] == 'remove_product')
        {
            $itemId = $_REQUEST['product_id'];
            $db->deleteCartItem($cart_id, $itemId);
        }
        else if ($_REQUEST['action'] == 'update_cart')
        {
            $cart = $_REQUEST['cart'];
            foreach ($cart as $id => $info)
            {
                $db->insertCartItem($id, $cart_id, $info['qty']);
            }
        }
        else if ($_REQUEST['action'] == 'pay')
        {
            if ($user == null)
            {
                header('Location: /user/login.php');
                exit();
            }
            require_once __DIR__ . '/Freekassa.php';
            $cartItems = $db->getCartItems($cart_id);
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
            $orderCode = strtoupper($db->generateRandomHash(5) . '-' . $db->generateRandomHash(5) . '-' . $db->generateRandomHash(5));
            $total = array_sum(array_map(function (&$item) {
                return $item->Price * $item->Quantity;
            }, $cartItems));
            if (debug)
            {
                $status = 1;
            }
            else
            {
                $status = 0;
            }
            $order_id = $db->insertOrder($orderCode, $user == null ? null : $user->Id, $fname, $lname, $country, $street_address1, $street_address2, $city, $zip_code, $phone, $email, $aditional_info, $total, $status);
            $db->insertPayment($orderCode, $order_id, $total, 0, 1);
            foreach ($cartItems as $cartItem)
            {
                $db->insertOrderItem($order_id, $cartItem->ProductId, $cartItem->Quantity, $cartItem->Price);
            }
            $db->clearCart($cart_id);
            if (debug)
            {
                $payment = 'Location: /user/orders/';
            }
            else
            {
                $payment = 'Location: ' . (new Freekassa())->GenerateUri($orderCode, $total);
            }
            header($payment);
            exit();
        }
    }
    $cartItems = $db->getCartItems($cart_id);
}
