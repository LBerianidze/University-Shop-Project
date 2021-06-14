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
<?php include '../assets/header.php'?>
<main class="page_content">
    <div class="center_wrapper">
        <form method="post" action="/contact/index.php">
            <div class="fields-container">
                <div class="field-container">
                    <label class="field-label" for="contact_name">Name
                        <span class="field-required">*</span>
                    </label>
                    <input type="text" id="contact_name" name="contact_name" required="">
                </div>
                <div class="field-container">
                    <label class="field-label" for="contact_email">Email
                        <span class="field-required">*</span>
                    </label>
                    <input type="email" id="contact_email" name="contact_email" required="">
                </div>
                <div class="field-container">
                    <label class="field-label" for="field_message">Comment or Message
                        <span class="field-required">*</span>
                    </label>
                    <textarea id="field_message" name="field_message" required=""></textarea>
                </div>
            </div>
            <div class="submit-container">
                <input name="action" id="action" value="support" hidden>
                <button type="submit" name="sendbtn" id="sendbtn">Submit</button>
            </div>
            <?php if (isset($message_sent)): ?>
                <div class="result_message">Message has been sent</div>
            <?php endif; ?>
        </form>
    </div>
</main>
<?php include_once '../assets/footer.html' ?>
</body>
</html>