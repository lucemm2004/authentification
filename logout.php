<?php
    session_start();
    session_destroy(); 
    unset($_COOKIE['remember']);
    setcookie('remember', '');
    header("Location: login.html");
?>