<?php

//inherite the user.php class
include "../classes/User.php";

//instatiate an object
$user = new User;

//call the delete method from the User.php
$user->delete();
