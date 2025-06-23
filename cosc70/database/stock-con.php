<?php
    $con = mysqli_connect('localhost','root','','inventory');
    if (!$con){
        die(mysqli_error("error"+$con));
    }
?>