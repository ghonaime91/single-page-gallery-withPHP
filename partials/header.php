<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles/css/bootstrap.css">
    <link rel="stylesheet" href="styles/css/style.css">
    <title><?php if(isset($title))echo $title; else echo "default page";?></title>
    <style>
       
    .uploaded-image{
        
        display: flex;
        flex-direction: row;
        justify-content: center;
    }
       
    </style>
</head>
<body>
<?php if(isset($_SESSION['user'])) {?>
    <nav class='navbar navbar-expand navbar-light bg-light justify-content-center mt-5 ml-50'>
        
        <ul class='nav-bar nav'>
            <li class="nav-item "><a class="nav-link " href="index.php">Home</a></li>
            <li class="nav-item mr-10"><a a class="nav-link  " href="index.php?do=show">images</a></li>
            <li class="nav-item mr-10"><a a class="nav-link  " href="index.php?do=upload">Upload Image</a></li>
            <li class="nav-item mr-10"><a a class="nav-link  " href="index.php?do=signout">Sign Out</a></li>
                
        </ul>
    </nav>
    <div class = "container "><h5>Welcome <?php echo  $_SESSION["user"]["username"];?></h5></div>
    <?php }else{?>
        <nav class='navbar navbar-expand navbar-light bg-light justify-content-center mt-5 ml-50'>
        <ul class='nav-bar nav'>
            <li class="nav-item "><a class="nav-link " href="index.php">Home</a></li>
            <li class="nav-item mr-10"><a a class="nav-link  " href="index.php?do=signup">Sign Up</a></li>
            <li class="nav-item mr-10"><a a class="nav-link  " href="index.php?do=signin">Sign In</a></li>
        </ul>
        </nav>
  
    <?php } ?>