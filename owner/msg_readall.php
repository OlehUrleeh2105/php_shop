<?php

require '../db.php';
require '../enc.php';

$db = new DB();

if ((strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) && (strlen($_GET['msg_id']) < 20 || strlen($_GET['msg_id']) > 100)) {
    header("location: ../index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$user = $db->getOwnerByID($userID);

if (!$db->userExist($user['email'])) {
    header("location: ../index.php");
    exit();
}

$mess = $db->MessageByID(decryptID($_GET['msg_id'], "msg_id"));

if($mess['viewed'] == '0'){
    if (!$db->updateView(decryptID($_GET['msg_id'], "msg_id"))) {
        header("location: messages.php?id=" . $_GET['id']);
        exit();
    }
}

$m_user = $db->getUserByID($db->MessageByID(decryptID($_GET['msg_id'], "user_id"))['user_id']);

if (isset($_POST['submit'])) {
    if ($db->updateUserType($m_user['email'])) {
        header("location: messages.php?id=" . $_GET['id']);
        exit();
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

    <title>ReadAll Message</title>
</head>
<body>

<?php include_once 'header.php'; ?>

<div class="container w-50" style="padding-top: 180px;">
    <div class="card text-center border">
        <div class="card-header p-3 bg-dark text-white">
            <?php $m_user = $db->getUserByID($db->MessageByID(decryptID($_GET['msg_id'], "user_id"))['user_id']); echo $m_user['email']; ?>
        </div>
        <div class="card-body bg-primary text-white">
            <h5 class="card-title">Why I must be an admin?</h5>
            <p class="card-text"> <?php echo str_replace('_', ' ', $db->MessageByID(decryptID($_GET['msg_id'], "user_id"))['message']);?> </p>
            <form action="msg_readall.php?id=<?php echo $_GET['id']; ?>&msg_id=<?php echo $_GET['msg_id']; ?>" method="post">
                <button type="submit" name="submit" class="btn btn-success">Make an admin</button>
            </form>
        </div>
        <div class="card-footer text-white bg-secondary">
            <?php
            $currentDate = new DateTime();
            $messageCreatedAt = new DateTime($db->MessageByID(decryptID($_GET['msg_id'], "user_id"))['created_at']);
            $interval = $currentDate->diff($messageCreatedAt);
            $daysDiff = $interval->days;
            echo "The message was sent {$daysDiff} days ago.";
            ?>
        </div>
    </div>
</div>


</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>