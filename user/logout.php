<?php
setcookie('usr', '', -1, '/');
header('location: /user/login.php');
exit();