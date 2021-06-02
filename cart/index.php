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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="/js/script.js" type="text/javascript"></script>
    <script src="/js/carousel.js" type="text/javascript"></script>
</head>
<body>
<header class="header">
    <div class="header_content">
        <div class="logo_container">
            <a href="/">
                <img src="/assets/img/logo1.png">
            </a>
        </div>
        <ul class="menu">
            <li>
                <a class="active" href="/">Home</a>
            </li>
            <li>
                <a href="/about-us">Abous Us</a>
            </li>
            <li>
                <a href="/contact">Support</a>
            </li>
            <li>
                <div class="cart_container phone_cart_container">
                    <a href="/cart">Cart</a>
                </div>
            </li>
        </ul>
        <div class="cart_container">
            <a href="/cart">Cart</a>
        </div>
        <div class="hamburger_btn">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</header>
<main class="page_content">
    <div class="center_wrapper">
        <div class="table-responsive">
            <table class="cart-table">
                <thead>
                <tr>
                    <th class="product-image">&nbsp;</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var object $cartItems */
                foreach ($cartItems as $cartItem): ?>
                    <tr>
                        <td class="product-image">
                            <a href="/product/<?= $cartItem->ProductId ?>/">
                                <img alt="Product Image" src="/assets/img/products/<?= $cartItem->ThumbImage ?>">
                            </a>
                        </td>
                        <td data-title="Product">
                            <a href="/product/<?= $cartItem->ProductId ?>/<?= $cartItem->Name ?>"><?= $cartItem->Name ?></a>
                        </td>
                        <td data-title="Price">
                            <span>$<?= number_format($cartItem->Price, 2, '.', ',') ?></span>
                        </td>
                        <td data-title="Quantity">
                            <div class="quantity">
                                <label for="quantity_<?= $cartItem->ProductId ?>"><?= $cartItem->Name ?></label>
                                <input type="number" id="quantity_<?= $cartItem->ProductId ?>" step="1" min="0" max="999" data-product_id="<?= $cartItem->ProductId ?>" value="<?= $cartItem->Quantity ?>" title="Qty" size="4" placeholder="">
                            </div>
                        </td>
                        <td data-title="Total">
                            <span>$<?= number_format($cartItem->Price * $cartItem->Quantity, 2, '.', ',') ?></span>
                        </td>
                        <td class="product-remove">
                            <button type="button" class="remove button the-icon" aria-label="Remove this item" data-product_id="<?= $cartItem->ProductId ?>">
                                <span class="button_icon">×</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="6" class="actions">
                        <button type="button" class="button" name="update_cart" id="update_cart" value="Update cart">Update cart</button>
                        <input type="hidden" name="action" value="update_cart">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card_totals">
            <h2>Cart totals</h2>
            <table class="cart-table">
                <tbody>
                <tr>
                    <th>Total</th>
                    <td>
                        $<?= number_format(array_sum(array_map(function (&$item) {
                            return $item->Price * $item->Quantity;
                        }, $cartItems)), '2', '.', ',') ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <a href="/checkout" class="checkout-button">
                Proceed to checkout
            </a>
        </div>
    </div>
</main>
<?php include '../assets/footer.html' ?>
</body>
</html>