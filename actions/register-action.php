<?php
    include '../classes/User.php';

    //Create the object
    $user = new User;

    //Call the method
    $user->store($_POST); // method in User.php
?>