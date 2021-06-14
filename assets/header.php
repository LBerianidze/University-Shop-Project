<?php
$headerPages = array('/'    => 'Home',
                     '/about-us/' => 'About us',
                     '/contact/'  => 'Support');
$currentPage = $_SERVER['PHP_SELF'];
?>
<header class="header">
    <div class="header_content">
        <div class="logo_container">
            <a href="/">
                <img src="/assets/img/logo1.png">
            </a>
        </div>
        <ul class="menu">
            <?php foreach ($headerPages as $pageUrl => $pageName):?>
                <li>
                    <a <?=($pageUrl.'index.php'==$currentPage?'class="active"':'')?> href="<?=$pageUrl?>"><?=$pageName?></a>
                </li>
            <?php endforeach;?>
            <li>
                <div class="cart_container phone_cart_container">
                    <a href="/cart">Cart</a>
                    <a class="login_menuitem" href="/user"><?=(!isset($user) || $user==null?'Sign in / Sign up':'Dashboard')?></a>
                </div>
            </li>
        </ul>
        <div class="cart_container">
            <a href="/cart">Cart</a>
            <a href="/user"><?=(!isset($user) || $user==null?'Sign in / Sign up':'Dashboard')?></a>
        </div>
        <div class="hamburger_btn">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</header>