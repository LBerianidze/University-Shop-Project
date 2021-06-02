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
<header class="header">
    <div class="header_content">
        <div class="logo_container">
            <a href="/">
                <img src="/assets/img/logo1.png">
            </a>
        </div>
        <ul class="menu">
            <li>
                <a href="/">Home</a>
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
        <form method="post" action="/checkout/index.php">
            <div>
                <div class="column">
                    <h2>Billing Details</h2>
                    <div class="fields-container checkout-fields-container">
                        <div class="field-container inline">
                            <label class="field-label" for="fname">First name
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" id="fname" name="fname" required="">
                        </div>
                        <div class="field-container inline">
                            <label class="field-label" for="lname">Last name
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" id="lname" name="lname" required="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="country">Country
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" readonly id="country" name="country" required="" value="Georgia">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="city">City
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" id="city" name="city" required="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="streetaddress1">Street address
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" id="street_address1" name="street_address1" required="" value="">
                            <input type="text" id="street_address2" name="street_address2" required="" value="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="zip_code">Zip code
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" id="zip_code" name="zip_code" required="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="phone">Phone
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" id="phone" name="phone" required="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="email">Email
                                <span class="field-required">*</span>
                            </label>
                            <input type="email" id="email" name="email" required="">
                        </div>
                    </div>
                    <?php if (isset($message_sent)): ?>
                        <div class="result_message">Message has been sent</div>
                    <?php endif; ?>
                </div>
                <div class="column">
                    <h2>Additional information</h2>
                    <div class="fields-container checkout-fields-container">
                        <div class="field-container">
                            <label class="field-label" for="aditional_info">Order notes (optional)
                                <span class="field-required">*</span>
                            </label>
                            <textarea type="text" id="aditional_info" name="aditional_info"></textarea>
                        </div>
                    </div>
                    <?php if (isset($message_sent)): ?>
                        <div class="result_message">Message has been sent</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="checkout-items-container">
                <h2>Order Items</h2>
                <table class="cart-table checkout-items-table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cartItems as $cartItem): ?>
                        <tr>
                            <td><?=$cartItem->Name?>
                                <strong>× <?=$cartItem->Quantity?></strong>
                            </td>
                            <td>
                                $<?=number_format($cartItem->Price * $cartItem->Quantity,2,'.',',')?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Total</th>
                        <td>
                            $ <?= number_format(array_sum(array_map(function (&$item) {
                                return $item->Price * $item->Quantity;
                            }, $cartItems)), '2', '.', ',') ?>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="submit-container">
                <input name="action" id="action" value="pay" hidden>
                <button type="submit">Pay for order</button>
            </div>
        </form>
    </div>
</main>
<?php include_once '../assets/footer.html' ?>
</body>
</html>