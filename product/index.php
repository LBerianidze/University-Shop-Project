<?php
require_once '../actions/conf.php';
$item = array();
try
{
    $st = $db->getPDO()->prepare('SELECT * FROM Product WHERE Id=:param1;');
    $st->execute(['param1' => $_REQUEST['id']]);
    $item = $st->fetch(PDO::FETCH_OBJ);
    $st = $db->getPDO()->prepare('SELECT * FROM ProductImage WHERE ProductId=:param1;');
    $st->execute(['param1' => $item->Id]);
    $images = $st->fetchAll(PDO::FETCH_OBJ);
} catch (Exception $exception)
{
}
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
<?php include '../assets/header.php'?>
<main class="page_content ">
    <div class="center_wrapper">
        <div class="notifications_container">
            <?php if (isset($addedToCart)): ?>
                <div class="notification">
                    <div class="alert_icon"><i class="icon-check"></i></div>
                    <div class="alert_wrapper">
                        <a href="/cart">View cart</a>
                        “<?= $item->Name ?>” has been added to your cart.
                    </div>
                    <a class="close_btn alert_close" href="#">
                        <span></span>
                        <span></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <div class="clearfix">
            <div class="column">
                <div class="img_preview">
                    <button class="close_btn">
                        <span></span>
                        <span></span>
                    </button>
                    <img src="/assets/img/products/<?= $images[0]->Image ?>" alt="">
                </div>
                <div class="product_images_wrapper">
                    <a href="#" class="product_img_zoom">🔍</a>
                    <div class="product_img_container">
                        <a href="/assets/img/products/<?= $images[0]->Image ?>">
                            <img width="540" height="405" src="/assets/img/products/<?= $images[0]->Image ?>" alt="Product Image" title="<?= $item->Name ?>">
                        </a>
                    </div>
                    <ol class="img_list_container">
                        <?php foreach ($images as $image): ?>
                            <li>
                                <img src="/assets/img/products/<?= $image->ThumbImage ?>" data-big_image="/assets/img/products/<?= $image->Image ?>" draggable="false">
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
            <div class="column">
                <h1 class="product_title"><?= $item->Name ?></h1>
                <p class="product_price">
                    $ <?= number_format($item->Price, 2, '.', ',') ?>
                </p>
                <div class="product_details">
                    <div class="text">
                        <img src="/assets/svg/hashrate.svg">
                        <span>Hashrate: <?= $item->Hashrate ?></span>
                    </div>
                    <div class="text">
                        <img src="/assets/svg/weight.svg">
                        <span>Weight: <?= number_format($item->Weight, 3, '.', ',') ?>kg</span>
                    </div>
                    <div class="text threeParts">
                        <img src="/assets/svg/shipping.svg">
                        <span>Shipping in 21 working days after fully paid</span>
                    </div>
                </div>
                <form class="cart" method="post" enctype="multipart/form-data">
                    <input name="action" value="add_to_cart" hidden>
                    <div class="quantity">
                        <label for="quantity"><?= $item->Name ?> quantity</label>
                        <input type="number" id="quantity" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4">
                    </div>
                    <button type="submit" name="add-to-cart" value="<?= $item->Id ?>">Add to cart</button>
                </form>
            </div>
        </div>
        <div class="accordion">
                <div class="title">
                    <div class="icon-minus"></div>
                    Description
                </div>
                <div>
                    <div class="table-responsive">
                        <table style="border-collapse: collapse;" class="table">
                            <tbody>
                            <tr class="header_row">
                                <td>Product Glance</td>
                                <td>Value</td>
                            </tr>
                            <tr class="default_row">
                                <td>Version
                                    <br>
                                    Hashrate,
                                    <strong>TH/s</strong>
                                    <br>
                                    Crypto Algorithm
                                </td>
                                <td>S19j
                                    <br>
                                    90
                                    <br>
                                    SHA256
                                </td>
                            </tr>
                            <tr class="default_row">
                                <td>Power on wall @25°C,
                                    <strong>Watt</strong>
                                </td>
                                <td>3100</td>
                            </tr>
                            <tr class="default_row">
                                <td>Power efficiency on wall @25°C,
                                    <strong>J/TH</strong>
                                </td>
                                <td>34.5</td>
                            </tr>
                            <tr></tr>
                            <tr class="header_row">
                                <td>Product details</td>
                                <td>Value</td>
                            </tr>
                            <tr class="default_row">
                                <td>Miner Size (Length*Width*Height, w/o package),
                                    <strong>mm</strong>
                                    (1-1)
                                </td>
                                <td>400*195.5*290</td>
                            </tr>
                            <tr class="default_row">
                                <td>Net weight,
                                    <strong>kg</strong>
                                    (1-2)
                                </td>
                                <td>14.2</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</main>
<?php include '../assets/footer.html' ?>
</body>
</html>