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
                    <a href="orders.php">Orders</a>
                </li>
                <?php if ($user->Role == 1): ?>
                    <li>
                        <a class="active" href="admin.php">Admin</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="logout.php">Log out</a>
                </li>
            </ul>
        </nav>
        <div class="dashboard_content">
            <div class="table-responsive">
                <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Register Date</th>
                        <th>Role</th>
                        <th class="product-remove">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $usr):?>
                        <tr>
                            <td data-title="Id">
                                <span><?=$usr->Id?></span>
                            </td>
                            <td data-title="Email">
                                <span><?=$usr->Email?></span>
                            </td>
                            <td data-title="Register Date">
                                <span><?=$usr->RegisterDate?></span>
                            </td>
                            <td data-title="Role">
                                <span><?=$usr->Role?></span>
                            </td>
                            <td class="product-remove">
                                <button type="button" class="export button the-icon" aria-label="Export this user" data-user_id="<?= $usr->Id ?>">
                                    <span class="button_icon">></span>
                                </button>
                                <button type="button" class="remove button the-icon" aria-label="Remove this user" data-product_id="<?= $usr->Id ?>">
                                    <span class="button_icon">×</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php include '../assets/footer.html' ?>
</body>
</html>