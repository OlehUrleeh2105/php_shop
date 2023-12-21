<?php
    require '../db.php';
    require '../enc.php';

    $db = new DB();

    if ((strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) && (strlen($_GET['user_id']) < 4 || strlen($_GET['user_id']) > 50)) {
        header("Location: ../index.php");
        exit();
    }

    $ownerID = decryptID($_GET['id'], "user_id");
    $owner = $db->getOwnerByID($ownerID);
    $userID = decryptID($_GET['user_id'], "user_id");
    $user = $db->getUserByID($userID);

    if (!$db->userExist($owner['email']) && !$db->userExist($user['email'])) {
        header("Location: ../index.php");
        exit();
    }

    if(isset($_POST['submit'])){
        if(empty($_POST['name']) && empty($_POST['surname']) && empty($_POST['password'])){
            header("Location: table_type.php?id=" . $_GET['id']);
            exit();
        }

        $type = $user['user_type'];
        if(isset($_GET['type']) && $_GET['type'] != " "){
            $type = $_GET['type'];
        }

        if($db->updateUser(decryptID($_GET['user_id'], "user_type"), $_POST['name'], $_POST['surname'], $_POST['password'], $type)){
            header("Location: table_type.php?id=" . $_GET['id'] . "&type=" . $type);
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

    <title>Update</title>
</head>
<body>

    <?php @include 'header.php'; ?>

    <div class="container w-50" style="padding-top: 120px;">
    <form action="edit.php?id=<?php echo $_GET['id']; ?>&user_id=<?php echo $_GET['user_id']; ?><?php if(isset($_GET['type']) && $_GET['type'] != "") {echo '&type=' . $_GET['type']; } ?>" method="post" class="border border-primary rounded" style="padding: 10px;">
        <div class="text-center display-4 font-weight-bold mb-4">
            UPDATE USERS INFO
        </div>
        <div class="form-outline mb-4">
            <label class="form-label font-weight-bold" for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $user['name']; ?>" />
        </div>
        <div class="form-outline mb-4">
            <label class="form-label font-weight-bold" for="surname">Surname</label>
            <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $user['surname']; ?>" />
        </div>
        <div class="form-outline mb-4">
            <label class="form-label font-weight-bold" for="password">Password</label>
            <input type="text" id="password" name="password" class="form-control" value="<?php echo $user['password']; ?>" />
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary btn-block mb-4 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                User type
            </button>
            <div class="dropdown-menu btn-block" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item <?php if($user['user_type'] == "admin") { echo 'active'; } ?>" href="edit.php?id=<?php echo $_GET['id']; ?>&user_id=<?php echo $_GET['user_id']; ?>&type=<?php echo 'admin'; ?>">Admin</a>
                <a class="dropdown-item <?php if($user['user_type'] == "user") { echo "active"; } ?>"  href="edit.php?id=<?php echo $_GET['id']; ?>&user_id=<?php echo $_GET['user_id']; ?>&type=<?php echo 'user'; ?>">User</a>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block  font-weight-bold">UPDATE</button>
    </form>
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>