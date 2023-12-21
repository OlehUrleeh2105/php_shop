<?php
session_start();
require '../db.php';
require '../enc.php';

$db = new DB();
if (!isset($_SESSION['owner_id'])) {
    header('location: ../index.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Owner Panel</title>
</head>
<body>

<?php include_once 'header.php'; ?>

<div class="container mt-5">
    <div class="container-fluid">
        <div class="row mb-3 ml-1">
            <div class="col-sm-3 mt-3">
                <div class="card" style="width: 220px;">
                    <div class="card-body">
                        <div class="text-center"><h5 class="card-title"><?php echo $db->getUserCount(); ?></h5></div>
                        <a href="table_type.php?id=<?php echo encryptID($_SESSION['owner_id'], "user_id"); ?>&type=user" class="btn btn-primary btn-block">Normal users</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3">
                <div class="card" style="width: 220px;">
                    <div class="card-body">
                        <div class="text-center"><h5 class="card-title"><?php echo $db->getAdmCount(); ?></h5></div>
                        <a href="table_type.php?id=<?php echo encryptID($_SESSION['owner_id'], "user_id"); ?>&type=admin" class="btn btn-primary btn-block">Admin users</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3">
                <div class="card" style="width: 220px;">
                    <div class="card-body">
                        <div class="text-center"><h5 class="card-title"><?php echo $db->getCount(); ?></h5></div>
                        <a href="table_type.php?id=<?php echo encryptID($_SESSION['owner_id'], "user_id"); ?>" class="btn btn-primary btn-block">Total accounts</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3">
                <div class="card" style="width: 220px;">
                    <div class="card-body">
                        <div class="text-center"><h5 class="card-title"><?php echo $db->getMessagesCount(); ?></h5></div>
                        <a href="messages.php?id=<?php echo encryptID($_SESSION['owner_id'], "user_id"); ?>&action=not_viewed" class="btn btn-primary btn-block">New messages</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>
