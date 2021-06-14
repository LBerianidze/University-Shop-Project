<?php
require_once 'actions/conf.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TSU SHOP</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="/js/script.js" type="text/javascript"></script>
    <script src="/js/carousel.js" type="text/javascript"></script>
</head>
<body>
<?php include 'assets/header.php';?>
<div class="draggable">
    <div class="carousel carousel_moving">
        <div class="carousel_item1"></div>
        <div class="carousel_item2"></div>
        <div class="carousel_item3"></div>
        <div class="carousel_item4"></div>
        <div class="carousel_item5"></div>
        <div class="carousel_item1"></div>
    </div>
    <div class="slider_mover prev"></div>
    <div class="slider_mover next"></div>
</div>
<main class="page_content">
    <ul class="products_container">
        <?php foreach ($items as $item): ?>
            <li class="product_item">
                <a class="product_item_link" href="/product/<?= $item->Id ?>/">
                    <div class="product_item_image_container">
                        <img width="300" height="300" alt="Img" class="product_item_image" src="/assets/img/products/<?= $item->ThumbImage ?>">
                    </div>
                    <div class="product_item_title"><?= $item->Name ?></div>
                </a>
                <div class="product_item_price">
                    $ <?= $item->Price ?>
                </div>
                <div class="product_item_cart_btn">
                    <a href="?add-to-cart=1" data-quantity="1" data-product_id="<?= $item->Id ?>" class="product_item_cart_btn_link add_to_cart_button">Add to cart
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
<?php include 'assets/footer.html' ?>
</body>
</html>