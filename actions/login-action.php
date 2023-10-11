<?php
    include "../classes/User.php";

    //Create an object
    $user = new User;

    //Call the login method/function
    $user->login($_POST);
?>