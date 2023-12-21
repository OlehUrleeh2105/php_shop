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

if(isset($_POST['submit'])){
    if(!isset($_POST['rating']) && !isset($_POST['message'])){
        header("location:feedback.php?id=" . $_GET['id']);
    }

    $message = str_replace(' ', '_', $_POST['message']);
    if ($db->insertFeedback(decryptID($_GET['id'], "user_id"), $user['name'], $message, $_POST['rating'])){
        header("location: about.php?id=" . $_GET['id'] . "#feedbacks");
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
    <link rel="stylesheet" href="css/feedback.css">

    <title>Leave a feedback</title>
</head>
<body>
    
    <?php @include 'header.php'; ?>

    <div class="container w-50" style="padding-top: 120px;">
        <form class="border border-primary" style="padding: 10px;" style action="feedback.php?id=<?php echo $_GET['id']; ?>" method="post">
            <div class="text-center font-weight-bold h3 mt-2">
                <em>Write a feedback</em>
            </div>
            <div class="form-group">
                <textarea style="resize:none;" class="form-control p-3" id="message" name="message" rows="6"></textarea>
            </div>
            <div class="form-group">
                <div class="font-weight-bold h4">Rate Us</div>
                <div class="rating">
                    <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                    <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                    <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                    <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                    <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block font-weight-bold">Submit</button>
        </form>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>