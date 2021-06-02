<?php
try
{
    $pdo = new PDO("mysql:host=localhost;dbname=UniversityProjectDB", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8");
} catch (Exception $exception)
{
    exit();
}
function insertCart($cookieHash)
{
    global $pdo;
    $request = $pdo->prepare('INSERT INTO Cart (CookieHash,CreateDate) VALUES (?,?); SELECT @@IDENTITY;');
    $request->execute([$cookieHash, (new DateTime())->format('Y-m-d H:i:s')]);
    $request->nextRowset();
    return $request->fetch(PDO::FETCH_ASSOC)['@@IDENTITY'];
}
function insertCartItem($itemid, $cartId, $quantity, $increment = false)
{
    global $pdo;
    $request = $pdo->prepare('SELECT COUNT(*) as Count FROM CartItem WHERE CartId=? AND ProductId=?');
    $request->execute([$cartId, $itemid]);
    $count = $request->fetch(PDO::FETCH_OBJ)->Count;
    if ($count == 0)
    {
        $request = $pdo->prepare('INSERT INTO CartItem (CartId, ProductId, Quantity) VALUES (?,?,?);');
        $request->execute([$cartId, $itemid, $quantity]);
    }
    else
    {
        if (!$increment)
        {
            $request = $pdo->prepare('UPDATE CartItem SET Quantity=?  WHERE CartId = ? AND ProductId = ?;');
            $request->execute([$quantity, $cartId, $itemid]);
        }
        else
        {
            $request = $pdo->prepare('UPDATE CartItem SET Quantity=Quantity+1  WHERE CartId = ? AND ProductId = ?;');
            $request->execute([$cartId, $itemid]);
        }
    }
}
function getCartIdByHash($cookieHash)
{
    global $pdo;
    $request = $pdo->prepare('SELECT Id FROM Cart WHERE CookieHash=?');
    $request->execute([$cookieHash]);
    if ($request->rowCount() > 0)
    {
        return $request->fetch(PDO::FETCH_OBJ)->Id;
    }
    else
    {
        return null;
    }
}
function generateRandomHash($length)
{
    $symbols = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $result = '';
    for ($i = 0; $i < $length; $i++)
    {
        $result .= $symbols[rand(0, strlen($symbols) - 1)];
    }
    return $result;
}
function getCartItems($cart_id)
{
    global $pdo;
    $sql = 'SELECT ProductId,Quantity,Name,Price,(SELECT ThumbImage FROM ProductImage WHERE ProductId=p.Id LIMIT 1) as ThumbImage from CartItem JOIN Product p ON CartItem.ProductId = p.Id WHERE CartId=?;';
    $request = $pdo->prepare($sql);
    $request->execute([$cart_id]);
    return $request->fetchAll(PDO::FETCH_OBJ);
}
function deleteCartItem($cart_id, $item_id)
{
    global $pdo;
    $sql = 'DELETE FROM CartItem WHERE CartId=? AND ProductId = ?;';
    $request = $pdo->prepare($sql);
    $request->execute([$cart_id, $item_id]);
}
function generateUniqueCart($length = 32)
{
    global $pdo;
    while (true)
    {
        $hash = 'cart_' . generateRandomHash($length);
        $request = $pdo->prepare('SELECT COUNT(*) as Count FROM Cart WHERE CookieHash=?');
        $request->execute([$hash]);
        $count = $request->fetch(PDO::FETCH_OBJ)->Count;
        if ($count == 0)
        {
            break;
        }
    }
    insertCart($hash);
    return $hash;
}
function insertOrder( $orderCode, $billing_first_name, $billing_last_name, $billing_country, $billing_address_1, $billing_address_2, $billing_city, $billing_postcode, $billing_phone, $billing_email, $billing_comment, $payment_id, $total)
{
    global $pdo;
    $request = $pdo->prepare("INSERT INTO UserOrder (Code, FName, LName, Country, StreetAddress1, StreetAddress2, Postcode, City, Phone, Email,Comment,PaymentId,Total) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?); SELECT @@IDENTITY;");
    $request->execute([$orderCode, $billing_first_name, $billing_last_name, $billing_country, $billing_address_1, $billing_address_2, $billing_postcode, $billing_city, $billing_phone, $billing_email, $billing_comment, $payment_id, $total]);
    $request->nextRowset();
    return $request->fetch(PDO::FETCH_ASSOC)['@@IDENTITY'];
}
function insertPayment($code, $sum, $status,$type)
{
    global $pdo;
    $request = $pdo->prepare("INSERT INTO Payment (Code, Sum, CreateDate, Status, Type) VALUES (?,?,?,?,?);");
    $request->execute([$code, $sum, (new DateTime())->format('Y-m-d H:i:s'), $status,$type]);
}
function insertOrderItem($orderId, $itemid, $quantity, $price)
{
    global $pdo;
    $request = $pdo->prepare('INSERT INTO OrderItem (OrderId, ProductId, Quantity,Price) VALUES (?,?,?,?);');
    $request->execute([$orderId, $itemid, $quantity, $price]);
}
function clearCart($cart_id)
{
    global $pdo;
    $sql = 'DELETE FROM CartItem WHERE CartId=?;';
    $request = $pdo->prepare($sql);
    $request->execute([$cart_id]);
}
function updatePaymentStatus($paymentId, $status)
{
    global $pdo;
    $request = $pdo->prepare('UPDATE Payment SET Status=? WHERE Id=?;');
    $request->execute([$status, $paymentId]);
    $request = $pdo->prepare('UPDATE UserOrder SET Status=? WHERE PaymentId=?;');
    $request->execute([$status, $paymentId]);
}
function getAllRows($sql)
{
    global $pdo;
    $request = $pdo->prepare($sql);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}
function getCoupon($code)
{
    global $pdo;
    $request = $pdo->prepare('SELECT * FROM Coupon WHERE Code=?');
    $request->execute([$code]);
    if ($request->rowCount() == 0)
    {
        return null;
    }
    return $request->fetch(PDO::FETCH_OBJ);
}
function SetCartCoupon($cart_id, $coupon)
{
    global $pdo;
    $request = $pdo->prepare('UPDATE Cart SET Coupon=? WHERE Id=?;');
    $request->execute([$coupon, $cart_id]);
}
function getCart($cart_id)
{
    global $pdo;
    $request = $pdo->prepare('SELECT * FROM Cart WHERE Cart.Id = ?');
    $request->execute([$cart_id]);
    if ($request->rowCount() == 0)
    {
        return null;
    }
    $obj = $request->fetch(PDO::FETCH_OBJ);;
    return $obj;
}
function getOrder($code, $user)
{
    global $pdo;
    if ($user == null)
    {
        $request = $pdo->prepare('SELECT * FROM UserOrder WHERE Code=? AND UserId is null');
        $request->execute([$code]);
    }
    else
    {
        $request = $pdo->prepare('SELECT * FROM UserOrder WHERE Code=? AND UserId=?');
        $request->execute([$code, $user]);
    }
    if ($request->rowCount() == 0)
    {
        return null;
    }
    return $request->fetch(PDO::FETCH_OBJ);
}