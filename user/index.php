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
                    <a href="index.php" class="active">Dashboard</a>
                </li>
                <li>
                    <a href="orders.php">Orders</a>
                </li>
                <?php if($user->Role==1):?>
                <li>
                    <a href="admin.php">Admin</a>
                </li>
                <?php endif;?>
                <li>
                    <a href="logout.php">Log out</a>
                </li>
            </ul>
        </nav>
        <div class="dashboard_content">
            <p>
                Hello
                <strong><?=$user->DisplayName?></strong>
                (not
                <strong><?=$user->DisplayName?></strong>
                ?
                <a href="logout.php">Log out</a>
                )
            </p>
        <br/>
            <p>
                Ut ultrices augue nec ante dignissim tempor. Sed a ligula euismod, luctus diam nec, pellentesque eros. Nulla dictum tortor quis faucibus venenatis. Sed rutrum dapibus egestas. Ut felis lorem, facilisis vitae ornare sed, ullamcorper quis diam. Ut non commodo ante, vitae pharetra felis. Donec et sapien aliquet, mollis nibh et, vehicula erat. In augue augue, semper eu egestas sed, egestas sit amet diam. Suspendisse ac neque et felis blandit aliquet in at est. Morbi dictum massa sit amet mauris pretium consequat. Phasellus vel erat a diam accumsan auctor sit amet non risus. Duis viverra nunc in ante pretium gravida. Aliquam cursus, est id elementum faucibus, turpis metus consequat lacus, quis venenatis orci elit a odio. In risus enim, dignissim quis risus et, dictum ultricies mi.
            </p>
        </div>
    </div>
</main>
<?php include '../assets/footer.html' ?>
</body>
</html>