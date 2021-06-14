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
    <div class="center_wrapper">
        <div class="clearfix">
            <div class="column">
                <h2>Login</h2>
                <form class="auth_form" method="post" action="/user/login.php">
                    <div class="notifications_container">
                        <?php if (isset($login_error)): ?>
                            <div class="notification error-notification">
                                <div class="alert_wrapper">
                                    <?=$login_error?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="fields-container">
                        <div class="field-container">
                            <label class="field-label" for="username">Username or email address
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" name="username" autocomplete="username" value="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="password">Password
                                <span class="field-required">*</span>
                            </label>
                            <input type="password" name="password" id="password">
                        </div>
                        <div class="submit-container">
                            <input type="hidden" id="action" name="action" value="login">
                            <button type="submit" name="login" value="Log in">Log in</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column">
                <h2>Register</h2>
                <form class="auth_form" method="post" action="/user/login.php">
                    <div class="notifications_container">
                        <?php if (isset($register_error)): ?>
                            <div class="notification error-notification">
                                <div class="alert_wrapper">
                                    <?=$register_error?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="fields-container">
                        <div class="field-container">
                            <label class="field-label" for="username">Email address
                                <span class="field-required">*</span>
                            </label>
                            <input type="text" name="email" id="email" value="">
                        </div>
                        <div class="field-container">
                            <label class="field-label" for="password">Password
                                <span class="field-required">*</span>
                            </label>
                            <input type="password" name="password" id="password">
                        </div>
                        <div class="submit-container">
                            <input type="hidden" id="action" name="action" value="register">
                            <button type="submit" name="login" value="Register">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include '../assets/footer.html' ?>
</body>
</html>