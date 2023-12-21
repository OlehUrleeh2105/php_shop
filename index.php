<?php
require 'db.php';
session_start();
$message = array();

if(isset($_POST['submit'])){
    $db = new DB();

    $email = $_POST['email'];
    $password = $_POST['pass'];

    if (!empty($email) && !empty($password)) {
        $row = $db->LoginAuto($email, $password);

        if($row && strtolower($row['user_type']) == 'owner'){
            $_SESSION['owner_name'] = $row['name'];
            $_SESSION['owner_email'] = $row['email'];
            $_SESSION['owner_id'] = $row['id'];
            header('location: owner/own_page.php');
            exit();
        } elseif($row && strtolower($row['user_type']) == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location: admin/adm_page.php');
            exit();
        } elseif($row && strtolower($row['user_type']) == 'user'){
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location: home.php');
            exit();
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'Please enter email and password!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <link rel="stylesheet" href="css/login.css">

    <title>Login</title>
</head>
<body>
    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <h1 class="card-title text-center">LOGIN</h1>
                    <div class="card-text">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" name="pass" id="password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <div class="signup mt-4 text-center">
                                Don't have an account yet? <a href="register.php">Create One</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
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