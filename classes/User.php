<?php

    require_once "Database.php";

    // The LOGIC of our application will added here in User.php
    // extends is use for inheriting another class
    class User extends Database{
        public function store($request){
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
            $password = $request['password'];

            // HASHED THE PASSWORD
            $password = password_hash($password, PASSWORD_DEFAULT);

            #Query string
            $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES('$first_name', '$last_name', '$username', '$password')";

            #Execute the query string above
            if ($this->conn->query($sql)) {
                header("location: ../views"); // index.php --> login page
                exit;
            }else {
                die("Error in creating a user. " . $this->conn->error);
            }
        }

        public function login($request){
            $username = $_POST['username']; //received the username coming from the login form
            $password = $_POST['password']; //received the password coming from the login form

            $sql = "SELECT * FROM users WHERE username = '$username'"; //prepare the query string

            $result = $this->conn->query($sql); // Execute the query string above, and store the result in $result property

            //check the $result if it is equal to 1, meaning checking if the username exists
            if ($result->num_rows == 1) { 
                //check if the password is correct
                $user = $result->fetch_assoc();
                //$user = ['id' => 1, 'username' => 'john.doe', 'password' => '$2y10$c9v...'];

                    //check if the password supplied by the user is the same with the password in the database
                    if (password_verify($password, $user['password'])) {
                        //create session variables for future use
                        session_start(); // start the sessions, we need to start the session in order for us to use session variables
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['fullname'] = $user['first_name'] . " " . $user['last_name'];

                        //redirect to dashboard if everything is okay
                        header("location: ../views/dashboard.php"); // we will going to create dashboard.php later on
                        exit;
                    }else {
                        die("Password is incorrect");
                    }
                    
                }else {
                    die("Username not found.");
                }
            }

            public function logout(){
                session_start();   //start the session
                session_unset();   //unset the existion session
                session_destroy(); //destroy/or remove the existing session

                header('location: ../views'); //login page (index.php)
            }

            // This method is going to select every users we have in the database
            public function getAllUsers(){
                $sql = "SELECT id, first_name, last_name, username, photo FROM users";
                if ($result = $this->conn->query($sql)) {
                    return $result;
                }else {
                    die("Error in retrieving users." . $this->conn->error);
                }
            }

            //This method is going to select only 1 user base on [User ID]
            public function getUser(){
                $id = $_SESSION['id']; //The id of the user who is currently logged-in

                // Prepare the query
                $sql = "SELECT first_name, last_name, username, photo FROM users WHERE id = $id";

                //Execute the query above using the query() method, and assign the result in $result
                if ($result = $this->conn->query($sql)) {
                    //If there is no error in the execution of the query above, then do this...
                    //give/or return the result to the calling object
                    return $result->fetch_assoc(); //retrieved the user details
                }else{
                    //This will be displayed if there is an error in the query above
                    die("Error in retrieving the user details. " . $this->conn->error);
                }
            }

            public function update($request, $files){
                session_start(); //start the session inorder for us to use the session variable

                $id = $_SESSION['id']; // session variable
                $first_name = $request['first_name'];
                $last_name = $request['last_name'];
                $username = $request['username'];
                $photo = $files['photo']['name'];
                $tmp_photo = $files['photo']['tmp_name'];

                $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $id";
                if($this->conn->query($sql)){
                    $_SESSION['user_name'] = $username;
                    $_SESSION['full_name'] = $first_name . "" . $last_name;

                    #if there is an uploaded phyo , save it  to the database and copy the image to the imagesefolder.

                    if($photo){ //chek if $phto has an image.line106.
                        $sql = "UPDATE users SET photo ='$photo' WHERE id=$id";

                        $destination ="../assets/images/$photo";

                        // save the image to database
                        if($this->conn->query($sql)){
                            //save the file to the image folder
                            if(move_uploaded_file($tmp_photo, $destination)){
                                header('location: ../views/dashboard.php');
                                exit;
                            }else{
                                die("ERROR in moving the photo.");
                            }
                            }else{
                                die('ERROR in uploading the photo: "' .$this->conn->error);
                        }
                    }
                    header('location:../views/dashboard.php');
                    exit;
                }else{
                    die("ERROR in updating the user: ".$this->conn->error);
                }
            }
            public function delete(){
                //we need to start the session befor wegonna use it.
                //it's a session bariable
                session_start();
                $id = $_SESSION['id'];//this is the id of the user who is currently logged-in
                
                //prepare the query
                $sql= "DELETE FROM users WHERE id=$id";
                if($this->conn->query($sql)){ //excute the quet above 
                    //call log out method
                    $this->logout();
                    //after logout ,it will jump to 
                }else{
                    die('ERROR in deleting your account.' .$this->conn->error);
                }
            }

                // Note: we will add the execute query here...
            }
    
?>