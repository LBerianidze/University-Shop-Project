<?php
class Database
{
    private $pdo;
    function __construct()
    {
        try
        {
            $this->pdo = new PDO("mysql:host=localhost;dbname=UniversityProjectDB", 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
        } catch (Exception $exception)
        {
            exit();
        }
    }
    function insertCart($cookieHash)
    {

        $request = $this->pdo->prepare('INSERT INTO Cart (CookieHash,CreateDate) VALUES (?,?); SELECT @@IDENTITY;');
        $request->execute([$cookieHash, (new DateTime())->format('Y-m-d H:i:s')]);
        $request->nextRowset();
        return $request->fetch(PDO::FETCH_ASSOC)['@@IDENTITY'];
    }
    function insertCartItem($itemid, $cartId, $quantity, $increment = false)
    {

        $request = $this->pdo->prepare('SELECT COUNT(*) as Count FROM CartItem WHERE CartId=? AND ProductId=?');
        $request->execute([$cartId, $itemid]);
        $count = $request->fetch(PDO::FETCH_OBJ)->Count;
        if ($count == 0)
        {
            $request = $this->pdo->prepare('INSERT INTO CartItem (CartId, ProductId, Quantity) VALUES (?,?,?);');
            $request->execute([$cartId, $itemid, $quantity]);
        }
        else
        {
            if (!$increment)
            {
                $request = $this->pdo->prepare('UPDATE CartItem SET Quantity=?  WHERE CartId = ? AND ProductId = ?;');
                $request->execute([$quantity, $cartId, $itemid]);
            }
            else
            {
                $request = $this->pdo->prepare('UPDATE CartItem SET Quantity=Quantity+1  WHERE CartId = ? AND ProductId = ?;');
                $request->execute([$cartId, $itemid]);
            }
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

        $sql = 'SELECT ProductId,Quantity,Name,Price,(SELECT ThumbImage FROM ProductImage WHERE ProductId=p.Id LIMIT 1) as ThumbImage from CartItem JOIN Product p ON CartItem.ProductId = p.Id WHERE CartId=?;';
        $request = $this->pdo->prepare($sql);
        $request->execute([$cart_id]);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
    function deleteCartItem($cart_id, $item_id)
    {

        $sql = 'DELETE FROM CartItem WHERE CartId=? AND ProductId = ?;';
        $request = $this->pdo->prepare($sql);
        $request->execute([$cart_id, $item_id]);
    }
    function generateUniqueCart($length = 32)
    {

        while (true)
        {
            $hash = 'cart_' . $this->generateRandomHash($length);
            $request = $this->pdo->prepare('SELECT COUNT(*) as Count FROM Cart WHERE CookieHash=?');
            $request->execute([$hash]);
            $count = $request->fetch(PDO::FETCH_OBJ)->Count;
            if ($count == 0)
            {
                break;
            }
        }
        $this->insertCart($hash);
        return $hash;
    }
    function insertOrder($orderCode, $userid, $billing_first_name, $billing_last_name, $billing_country, $billing_address_1, $billing_address_2, $billing_city, $billing_postcode, $billing_phone, $billing_email, $billing_comment, $total, $status)
    {

        $request = $this->pdo->prepare("INSERT INTO UserOrder (Code, UserId, FName, LName, Country, StreetAddress1, StreetAddress2, Postcode, City, Phone, Email,Comment,Total,Status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?); SELECT @@IDENTITY;");
        $request->execute([$orderCode, $userid, $billing_first_name, $billing_last_name, $billing_country, $billing_address_1, $billing_address_2, $billing_postcode, $billing_city, $billing_phone, $billing_email, $billing_comment, $total, $status]);
        $request->nextRowset();
        return $request->fetch(PDO::FETCH_ASSOC)['@@IDENTITY'];
    }
    function insertPayment($code, $order_id, $sum, $status, $type)
    {

        $request = $this->pdo->prepare("INSERT INTO Payment (Code,OrderId, Sum, CreateDate, Status, Type) VALUES (?,?,?,?,?,?);");
        $request->execute([$code, $order_id, $sum, (new DateTime())->format('Y-m-d H:i:s'), $status, $type]);
    }
    function insertOrderItem($orderId, $itemid, $quantity, $price)
    {

        $request = $this->pdo->prepare('INSERT INTO OrderItem (OrderId, ProductId, Quantity,Price) VALUES (?,?,?,?);');
        $request->execute([$orderId, $itemid, $quantity, $price]);
    }
    function clearCart($cart_id)
    {

        $sql = 'DELETE FROM CartItem WHERE CartId=?;';
        $request = $this->pdo->prepare($sql);
        $request->execute([$cart_id]);
    }
    function updatePaymentStatus($paymentId, $status)
    {

        $request = $this->pdo->prepare('UPDATE Payment SET Status=? WHERE Id=?;');
        $request->execute([$status, $paymentId]);
        $request = $this->pdo->prepare('UPDATE UserOrder SET Status=? WHERE PaymentId=?;');
        $request->execute([$status, $paymentId]);
    }
    function insertUser($email, $password)
    {

        $request = $this->pdo->prepare("INSERT INTO User (Email, Password, DisplayName)
VALUES (?,?,?);");
        $request->execute([$email, $password, strstr($email, '@', true)]);
    }
    function userExists($email)
    {
        $sql = "SELECT * from User WHERE Email = ?;";

        $request = $this->pdo->prepare($sql);
        $request->execute([$email]);
        return $request->fetch(PDO::FETCH_OBJ) != null;
    }
    function getUserByHash($hash)
    {
        $sql = "SELECT * from User WHERE md5(CONCAT('6aD%kXj4w{P$@AA?Jl*hR', Email,Password)) = ?;";

        $request = $this->pdo->prepare($sql);
        $request->execute([$hash]);
        return $request->fetch(PDO::FETCH_OBJ);
    }
    function getAllRows($table)
    {

        $request = $this->pdo->prepare('select * from ' . $table);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
    function selectRows($table, $columns, $where = null, $result_style = PDO::FETCH_OBJ, $return_single = false)
    {

        $sql = "SELECT ";
        $sql .= $columns == '*' ? '*' : '`' . implode('`,`', $columns) . '`';
        $sql .= " FROM $table";
        $execute_parameters = [];
        if ($where != null)
        {
            $sql .= ' WHERE ';
            $first = true;
            foreach ($where as $key => $item)
            {
                if ($key == '=' || $key == '>' || $key == '<')
                {
                    foreach ($item as $column => $value)
                    {
                        if (!$first)
                        {
                            $sql .= ' AND ';
                        }
                        $sql .= "`$column`$key?";
                        $execute_parameters[] = $value;
                        $first = false;
                    }
                }
            }
        }
        if ($return_single)
        {
            $sql .= ' LIMIT 1';
        }
        $request = $this->pdo->prepare($sql);
        $request->execute($execute_parameters);
        if ($return_single)
        {
            $result = $request->fetch($result_style);
        }
        else
        {
            $result = $request->fetchAll($result_style);
        }
        return $result;
    }
    function getPDO()
    {
        return $this->pdo;
    }
    function getUserOrders($user_id)
    {
        $sql = 'SELECT e1.Code, e1.OrderDate, e2.ProductId, e2.Quantity, e2.Price, e3.Name
FROM UserOrder e1
         LEFT JOIN OrderItem e2
                   ON e1.Id = e2.OrderId
         LEFT JOIN Product e3
                   ON e2.ProductId = e3.Id
WHERE e1.UserId = ? AND e1.Status=1';
        $request = $this->pdo->prepare($sql);
        $request->execute([$user_id]);
        return $this->group_by($request->fetchAll(PDO::FETCH_ASSOC), 'Code');
    }
    private function group_by($array, $key)
    {
        $return = array();
        foreach ($array as $val)
        {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}