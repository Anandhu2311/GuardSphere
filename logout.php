<?php
session_start();
$_SESSION = array();
session_unset();

session_destroy();
if(!headers_sent()){
    header('location:signin.php');
    exit();
}
else{
    echo'<script>window.location.href="signin.php";</script>';
    exit();
}

?> 