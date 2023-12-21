<?php

require 'db.php';
require 'enc.php';

$db = new DB();


if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
    header("location: index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$user = $db->getUserByID($userID);

if (!$db->userExist($user['email'])) {
    header("location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $row = $db->getUserByID(decryptID($_GET['id'], "user_id"));

    if ($db->getUserMessages($row['email'])) {
        header("location: send.php?id=" . $_GET['id']);
        exit();
    }

    if (!empty($_POST['message'])) {
        $message = str_replace(' ', '_', $_POST['message']);
        if ($db->sendMessage($row['id'], $row['email'], $row['name'], $message)) {
            header("location: home.php");
            exit();
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
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Send Message</title>
</head>
<body>


<?php

if($db->isViewed($user['id'])){
    echo "
    <div class='alert alert-info alert-dismissible fade show' role='alert'>
        Your message has been viewed but as you can see you haven't been promoted.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>
    ";
} else {
    if ($db->getUserMessages($user['email'])){
        echo "
        <div class='alert alert-primary alert-dismissible fade show' role='alert'>
            Stay along your message is checking right now you will see a new design when you will promote.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
    }
}

?>
    <?php @include 'header.php'; ?>

<div style="padding-top: 120px;" class="container mt-5">
    <form action="send.php?id=<?php echo $_GET['id']; ?>" method="post">
        <div class="mb-5 d-flex justify-content-center">
            <div class="text-center"><label for="message" class="font-weight-bold font-italic h2">Write why you suppose to be an admin:</label></div>
        </div>
        <div class="mb-5 d-flex justify-content-center">
            <textarea style="resize:none;" class="form-control w-50 p-3" id="message" name="message" rows="5"></textarea>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary btn-lg w-50 p-3">Send</button>
        </div>
    </form>
</div>


</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>
