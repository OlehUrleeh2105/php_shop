<?php
require "db.php";

$message = array();

if(isset($_POST['submit'])){
    $db = new DB();

    if($db->userExist($_POST['email'])){
        $message[] = 'User already exists!';
    }else{
        if($_POST['pass'] != $_POST['conf_pass']){
            $message[] = 'Confirm password does not match!';
        }else{
            if($db->addUser($_POST['email'], $_POST['pass'], $_POST['name'], $_POST['surname'])){
                $message[] = 'Registered successfully!';
                header('location:index.php');
                exit();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/register.css">

    <title>Register</title>
</head>
<body style="background-color: #508bfc;">
    <button class="btn-back btn btn-dark mt-1 ml-1">
        <a href="index.php">← Back</a>
    </button>
    <div class="reg-form">
        <h1 class="text-center mb-4">Register Form</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-outline mb-2">
            <div class="form-outline mb-4">
                <label class="form-label" for="user_name">Name</label>
                <input type="text" name="name" maxlength="35" class="form-control" required>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="user_last">Surname</label>
                <input type="text" name="surname" maxlength="35" class="form-control" required>
            </div>
                <label class="form-label" for="email" >Email address</label>
                <input type="email" name="email" maxlength="40" class="form-control" required>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="password" >Password</label>
                <input type="password" name="pass" maxlength="15" class="form-control" required>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="password" >Confirm password</label>
                <input type="password" name="conf_pass" maxlength="15" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mb-3">SIGN UP</button>
        </form>
    </div>
</body>

<?php
if(isset($message)){
    foreach($message as $message){
        echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        ';
    }
}
?>

</html>
