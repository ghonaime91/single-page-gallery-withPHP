<?php
session_start();
include_once("helpers/data-base.php");
include_once("helpers/validation.php");
?>
    <?php
    # sign up section
    if(isset($_GET["do"]) && $_GET["do"] === "signup")
    {

        $do = "signup";
        $title = "Sign Up";

        include_once "partials/header.php";

        if($_SERVER["REQUEST_METHOD"] === 'POST')
        {
            #Form Inputs 
            $userName = clear_input($_POST['name']);
            $email    = clear_input($_POST['email']);
            $pass     = clear_input($_POST['password']);
            $gender;
        
            $errors = [];
        
            #validation using my validate function
            if(validate($userName,'is_empty'))$errors['name'] = "requird";
            elseif(!validate($userName,'is_string'))$errors['name']="must be a valid string";
        
            if(validate($email,'is_empty'))$errors['email'] = "requird";
            elseif(!validate($email,'is_email'))$errors['email']="not valid";
        
            if(validate($pass,'is_empty'))$errors['password'] = "requird";
            elseif(validate($pass,'is_short'))$errors['password']="too short";  
            
            if(isset($_POST['gender']))
                $gender = $_POST['gender'];
            else
                $errors["gender"] = "required";   
        
          
            #if there is any validation error
            if(count($errors)>0)
            {
                
                echo "<div class='alert alert-danger'>";
                foreach($errors as $k=>$v)
                {
                    echo "* $k is $v<br>";
                }
                echo "</div>";
            #if no validation errors    
            } else {
                #check if email is already in use
                $isEmailUsedSql = "SELECT `username` FROM users WHERE email='$email'";
                $isEmailUsedQuery = mysqli_query($conn,$isEmailUsedSql);
                $res = mysqli_num_rows($isEmailUsedQuery);
                if($res > 0) {
                    echo "<div class='alert alert-danger text-center'>The Email is already used!</div>";
                } else {
                
                #password encryption
                $pass = password_hash($pass,PASSWORD_DEFAULT);
                #my sql prepared statement
                $sql = "INSERT INTO `users` (`username`,`email`,`password`,`gender`) VALUES (?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql))echo"Error Occured!".  mysqli_stmt_error($stmt);
                else{
                    mysqli_stmt_bind_param($stmt,"ssss",$userName,$email,$pass,$gender);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success text-center'><h5 class=''>You have successfully registered</h5></div>";
                }
              }
            }
               
        }    
    
    ?>
    <div class='container mt-5 '>
        <div class="form-group">
        <h2 >Registeration Form:</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?do=signup")?>" method="post">

        <div class="form-group">
            <input class="form-control" type="text"placeholder="Enter Name" name="name"
            <?php if(isset($userName))echo "value='$userName'"?>>
            <small>Enter Your Name</small>
     
        </div>

        <div class="form-group">
            <input class="form-control" type="email" placeholder="Enter E-mail" name="email"
            <?php if(isset($email))echo "value='$email'"?>> 
            <small>Enter Your E-mail</small>
        </div>

        <div class="form-group">
            <input class="form-control" type="password" name="password">
            <small>Enter Your PassWord</small>
        </div>

        <div class="form-group">
            <div class=" form-check ">
            <div>
            <label class="form-check-label" for="gender">Gender: </label>
            </div>
            <div>
            <input class="form-check-input" type="radio" id ="male" name="gender" value="male"
            <?php if(isset($gender) && $gender==="male")echo "checked"?>>
            <label class = "form-check-label" for="male">male</label>
            </div>
            <div>
            <input class="form-check-input" type="radio" id="female" name="gender" value="female"
            <?php if(isset($gender) && $gender==="female")echo "checked"?>>
            <label class = "form-check-label" for="female">female</label>
            </div>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" value="Sign Up" class="btn btn-primary">
        </div>

        </form>

    </div>

<?php
    }#end if sign up

    # signin section 
    else if(isset($_GET["do"]) && $_GET["do"] === "signin") {

        $title = "Sign In";
        include_once "partials/header.php";

        if(isset($_POST['sign']))
        {
            $email = clear_input($_POST["email"]);
            $pass  = clear_input($_POST["pass"]);
            #signin form validation
            if(empty($email) || empty($pass) )
                echo "<div class='alert alert-danger text-center'>You Must Enter The Email And PassWord!</div>";
            else if (!validate($email,"is_email"))
                echo "<div class='alert alert-danger text-center'>Invalid Email!</div>";
            #if the data is valid    
            else {
                
                $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
                $res = mysqli_query($conn,$sql);
                $arr = mysqli_fetch_assoc($res);
                #if the email is right then check the password
                if(mysqli_num_rows($res) == 1){
                    if (password_verify($pass,$arr["password"])) {
                        #case right email and password
                        $_SESSION["user"] = $arr;
                        
                        header("Location: index.php?do=show");

                    } else {
                        #in case wrong password
                        echo "<div class='alert alert-danger text-center'>Wrong Password!</div>";
                    }
                } else {
                    #in case the email is not found 
                    echo "<div class='alert alert-danger text-center'>Wrong Email!</div>";
                }
                
                
            }    
        }
    ?>
        <div class="container mt-5 " style='width:320px'>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?do=signin";?>" method="post">

            <div class="form-group">
                <small>Enter Your email</small>
                <input type="email" name="email" class="form-control" 
                <?php if(isset($email))echo "value='$email'"?>>
                
            </div>
            <div class="form-group">
                <small>Enter Your password</small>
                <input type="password" name="pass" class="form-control" >
            </div>
            <div class="form-group">
            
                <input type="submit" class="form-control" value="Sign In" name='sign' >
            </div>

        </form>
        </div>
<?php
   
    } #end sign in
    else if(isset($_GET["do"]) && $_GET["do"] === "show" && isset($_SESSION["user"])){
        
       
            $title="Show Images";
            include_once "partials/header.php";
            $userId = $_SESSION["user"]["id"];
            $sql = "SELECT * FROM images WHERE `user_id`='$userId';";
            $objRes = mysqli_query($conn,$sql);
           
           ?>
    <div class =" col-8 container ">
    <table  class='table' >
    <tr>
        <td>id</td>
        <td>image</td>   
        <td>Delete Image</td>
    
    </tr>
    <?php while($row = mysqli_fetch_assoc($objRes)) {?>
    <tr>
        <?php echo "<td '>".$row['id']."</td>";?>
        <?php echo "<td ><a href='uploads/$row[imagename]'><img width='150px' src='uploads/$row[imagename]'></a></td>";?>     
        <?php echo "<td><a  class='btn btn-outline-primary' href='index.php?do=delete&id=".$row['id']."'>Delete</a></td>";?>
    </tr>
    <?php }?>
    </table>
</div>
<?php
       
    }#upload image section
    else if(isset($_GET["do"]) && $_GET["do"] === "upload" && isset($_SESSION["user"]))
    {
      
        $title = "Upload Image";
        include_once "partials/header.php";

        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            if(!empty($_FILES["image"]["name"]))
            {
                $image = $_FILES["image"];
                $imgTmp = $image["tmp_name"];
                $imageType = explode('/',$image["type"])[1];
                $imageSize = $image["size"];
                $allowedTypes = ["png","jpg","jpeg"];
                if(in_array($imageType,$allowedTypes))
                {
                    if($imageSize <= 5000000){
                        $finalName = rand().time().".".$imageType;
                        $dest = "./uploads/".$finalName;
                        $userId = $_SESSION["user"]["id"];
                        if(move_uploaded_file($imgTmp,$dest)){
                            $sql = "INSERT INTO `images`(`user_id`,`imagename`)VALUES('$userId','$finalName')"; 
                            mysqli_query($conn,$sql);
                            
                            echo "<div class='alert alert-success text-center'>Image uploaded successfully</div>";
                        }; 
                          
                    } else {
                        echo "<div class='alert alert-danger text-center'>Maximum size is 4MB </div>";    
                    }

                } else {
                    echo "<div class='alert alert-danger text-center'>Allowed types are jpg-jpeg-png</div>";
                }
            }
            elseif(empty($_FILES["image"]["name"])) {
                echo "<div class='alert alert-danger text-center'>Please Choose an image!</div>";
            }

        }

?>
    <div class="container upload-form">
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?do=upload"?>" method="post" enctype="multipart/form-data">
            <div class = 'uploaded-image'>
            <input class="" type="file" name="image" id="">
            <input class="btn btn-primary "  type="submit" value="Upload">
            </div>
        </form>
    </div>
<?php        
    }
    
    else if(isset($_GET["do"]) && $_GET["do"] === "signout")
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
    #deletion of images section
    else if(isset($_GET["do"]) && $_GET["do"] === "delete" && is_numeric($_GET["id"]))
    {
        $title = "Home";
        include_once "partials/header.php";
        $imgId = $_GET["id"];
        $sqlImgInfo = "SELECT `imagename` FROM images WHERE id=$imgId";
        $obj = mysqli_query($conn,$sqlImgInfo);
        $res = mysqli_fetch_assoc($obj);
        $imgName = $res["imagename"];
        $sql = "DELETE FROM `images` WHERE id = $imgId";
        if(mysqli_query($conn,$sql)){
            unlink("./uploads/$imgName");
            header("Location: http://localhost/p2/index.php?do=show");
        }
    }

    else {
        #Home section
        $title = "Home";
        include_once "partials/header.php";
        echo "<div class='container mt-5'>
         <pre>
         <h2>                          Images Gallery </h2>
         <img src='main.jpg' width=80%>


         consectetur adipisicing elit.
         Aperiam quam exercitationem neque, voluptate fuga assumenda.
         Officiis, nesciunt! Sunt eveniet harum hic labore laudantium
         illo eligendi autem?
         Qui cupiditate ipsa maxime?
         Cumque, eligendi cupiditate neque vero tenetur dignissimos sint quas,
        </pre></div>";
    }

?>








    <?php
     include_once "partials/footer.php";
     ?>



