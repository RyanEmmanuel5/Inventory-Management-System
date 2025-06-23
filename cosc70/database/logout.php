<?php
    session_start();
    //remove all session variable
    session_unset();
    //destory
    session_destroy();
    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: '.$_SERVER['HTTP_REFERER']);  
       } else {
        header('Location: index.php');  
       }
       exit;  
?>