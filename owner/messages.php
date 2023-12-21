<?php
require '../db.php';
require '../enc.php';

$db = new DB();

if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
    header("location: ../index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$user = $db->getOwnerByID($userID);

if (!$db->userExist($user['email'])) {
    header("location: ../index.php");
    exit();
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

    <title>Messages</title>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <p class="text-center display-4 mb-4 mt-4">Messages data table</p>
        <div class="row">
            <div class="col-sm-4 mb-2">
                <div class="text-left">
                    <a href="messages.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-success <?php if($_GET['action'] == "" || !isset($_GET['action'])) { echo 'active'; } ?>" style="border-radius: 20px; width: 90px;">All</a>
                    <a href="messages.php?id=<?php echo $_GET['id']; ?>&action=viewed" class="btn btn-outline-primary <?php if($_GET['action'] == "viewed") { echo 'active'; }?>" style="border-radius: 20px; width: 90px;">Readed</a>
                    <a href="messages.php?id=<?php echo $_GET['id']; ?>&action=not_viewed" class="btn btn-outline-secondary <?php if($_GET['action'] == "not_viewed") { echo 'active'; }?>" style="border-radius: 20px; width: 90px;">Not</a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Name</th>
                    <th class="text-center" scope="col">Email</th>
                    <th class="text-center" scope="col">Message</th>
                    <th class="text-center" scope="col">Sent</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($_GET['action']) && $_GET['action'] == 'not_viewed') {
                    $data = $db->notViewed();
                } elseif (isset($_GET['action']) && $_GET['action'] == 'viewed') {
                    $data = $db->viewed();
                } else {
                    $data = $db->getMessages();
                }
                foreach ($data as $row) {
                    $msg = str_replace('_', ' ', $row['message']);
                    if (strlen($row['message']) > 15) {
                        $msg = substr($row['message'], 0, 15) . '...';
                    }
                    echo "
                        <tr class='text-center'>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $msg . "</td>
                            <td>" . DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y') . "</td>
                            <td><a class='btn btn-outline-light' href='msg_readall.php?id=" . encryptID(decryptID($_GET['id'], "user_id"), "user_id") . "&msg_id=" . encryptID($row['id'], "msg_id") . "'>ReadAll</a></td>
                        </tr>
                    ";
                }
            ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
