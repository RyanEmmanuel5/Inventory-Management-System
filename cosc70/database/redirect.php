<?php
    session_start();
    //remove all session variable

    $_SESSION['success_message'] = "Successfully registered!";

    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: '.$_SERVER['HTTP_REFERER'].'?success=true');  
       } else {
        header('Location: record-add.php?success=true');  
       }
       exit;  
?>