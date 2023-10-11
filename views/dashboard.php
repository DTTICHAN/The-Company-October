<?php
    // $_SESSION -- it is like a variable, actually special variable. It can also store data
    // it has a global scope ---> meaning it is accessible anywhere inside our application.

    session_start();

    require '../classes/User.php';      //include the User.php file
    $user = new User;                   //create the object of User class
    $all_users = $user->getAllUsers();  //get all the users, and assign it to $all_users

    //check the lists
    //print_r($all_users); //print_r() is a builtin function in PHP only use for debugging and for testing purposes
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- connect to CSS Link -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?=$_SESSION['fullname']?></span>
                <form action="../actions/logout-action.php" method="post" class="d-flex ms-2">
                    <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h2 class="text-center">USERS LISTS</h2>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                        <th>USERNAME</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // get/or fetch all the lists of users and assign it to $user property/variable
                        while ($user = $all_users->fetch_assoc()) {
                    ?>

                        <tr>
                            <td>
                                <?php
                                    // check if the user has photo
                                    if ($user['photo']) {
                                ?>
                                    <!-- If the user has an image, this code below will be use to display the image -->
                                    <img src="../assets/images/<?=$user['photo']?>" alt="<?=$user['photo']?>" class="d-block mx-auto dashboard-photo">
                                <?php
                                    }else {
                                ?>
                                    <!-- Icon from Fontawesome website... use to display icon, if the image of the user is not available-->
                                    <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                                <?php
                                    }
                                ?>
                            </td>
                            <td><?=$user['id']?></td>
                            <td><?=$user['first_name']?></td>
                            <td><?=$user['last_name']?></td>
                            <td><?=$user['username']?></td>
                            <td>
                                <!-- Edit and Delete Button -->
                                <?php
                                    if ($_SESSION['id'] == $user['id']) {
                                ?>
                                <!-- //edit button -->
                                    <a href="edit-user.php" class="btn btn-outline-warning" title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                <!-- //delete button -->
                                    <a href="../views/delete-user.php" class="btn btn-outline-danger" title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                        
                                <?php
                                    }
                                ?>
                            </td>
                        </tr>

                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>




    <!-- JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>