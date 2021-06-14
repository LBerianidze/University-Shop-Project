<?php
require_once '../actions/conf.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TSU SHOP</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="/js/script.js" type="text/javascript"></script>
</head>
<body>
<?php include '../assets/header.php' ?>
<main class="page_content ">
    <div class="center_wrapper clearfix">
        <nav class="dashboard_nav">
            <ul>
                <li>
                    <a href="index.php">Dashboard</a>
                </li>
                <li>
                    <a href="orders.php" class="active">Orders</a>
                </li>
                <?php if ($user->Role == 1): ?>
                    <li>
                        <a href="admin.php">Admin</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="logout.php">Log out</a>
                </li>
            </ul>
        </nav>
        <div class="dashboard_content">
            <?php $counter = 1; foreach ($userOrders as $user_order_key => $user_order): ?>
                <div class="order-container">
                    <div>
                        <p>
                            <strong>Order:</strong>
                            <?= $user_order_key ?>
                        </p>
                        <p>
                            <strong><?= count($user_order) ?></strong>
                            Products
                        </p>
                    </div>
                    <div>
                        <p>
                            <strong>Date:</strong>
                            <?= $user_order[0]['OrderDate'] ?>
                        </p>
                        <?php
                        $itemsCount = 0;
                        $orderSum = 0;
                        foreach ($user_order as $userOrderItem)
                        {
                            $itemsCount += $userOrderItem['Quantity'];
                            $orderSum += $userOrderItem['Quantity'] * $userOrderItem['Price'];
                        }
                        ?>
                        <p>
                            <strong><?= $itemsCount ?></strong>
                            Items
                        </p>
                    </div>
                    <div>
                        <span>
                            <strong>Total:</strong>
                            $<?= number_format($orderSum, '2', '.', ',') ?>
                        </span>
                    </div>
                    <div>
                        <a data-order-id="<?=$counter?>" class="showlogin">
                            <div class="arrow"></div>
                        </a>
                    </div>
                </div>
                <div class="orders-expand closed expander-<?=$counter++?>">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="orders-table table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($user_order as $user_order_item): ?>
                                    <tr class="cart_item">
                                        <td><?=$user_order_item['Name']?>
                                            <strong>× <?=$user_order_item['Quantity']?></strong>
                                        </td>
                                        <td class="product-total">
                                            $ <?= number_format($user_order_item['Quantity'] * $user_order_item['Price'], '2', '.', ',') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php include '../assets/footer.html' ?>
</body>
</html>