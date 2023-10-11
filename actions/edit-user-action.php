<?php
    //include the class file
    include "../classes/User.php";

    //create/or instantiate an object
    $user = new User;

    //call the update() method
    $user->update($_POST, $_FILES);
    # NOTE: $_POST --> we can received the first_name, last_name, username using the $_POST method
    # NOTE: $_FILES --> we can received the images or file image file uploaded by the user using the $_FILES method
?>