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

if (!$db->userExist($user['email']) && !$db->productExists(decryptID($_GET['pr_id'], "pr_id"))) {
    header("location: index.php");
    exit();
}

$product = $db->getProductByID(decryptID($_GET['pr_id'], "pr_id"));

if (!$db->isProductViewedToday(decryptID($_GET['pr_id'], "pr_id"), $userID)) {
    if (!$db->setProductView(decryptID($_GET['pr_id'], "pr_id"), $userID)) {
        header("location: home.php");
        exit();
    }
} else {
    if (!$db->updateViewTime(decryptID($_GET['pr_id'], "pr_id"), $userID)) {
        header("location: home.php");
        exit();
    }
}

if (isset($_POST['submit'])) {
    if (empty($_POST['msg'])) {
        header("location: view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id'] . "#users_comments");
        exit();
    }

    if (!$db->insertComment($userID, decryptID($_GET['pr_id'], "pr_id"), $_POST['msg'])) {
        header("location: view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id'] . "#users_comments");
        exit();
    }

    header("location: view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
    exit();
}

$limit = 3; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/comm.css">

    <title>View More</title>
</head>
<body>
    
    <?php @include 'header.php'; ?>

    <div class="container">
        <?php 
            $product = $db->getProductByID(decryptID($_GET['pr_id'], "pr_id"));
            echo "
            <div class='text-left font-weight-normal display-4 mt-3'>
                " . $product['title'] . "
            </div>
            ";
        ?>
        <div id="carouselExampleControls" class="carousel slide mt-3" data-ride="carousel">
            <div class="carousel-inner">
                <?php 
                    $pr_id = decryptID($_GET['pr_id'], "pr_id");
                    $arr = scandir("uploaded_img/" . $pr_id);
                    $count = count($arr) - 2;
                    if ($count > 1){
                        for($i = 0; $i < $count; $i++){
                            echo "
                            <div class='carousel-item " . ($i == 0 ? "active" : "") . "'>
                                <img class='d-block mx-auto' style='height: 450px;' src='uploaded_img/" . $pr_id . "/" . $arr[$i + 2] . "'>
                            </div>
                            ";
                        }
                        echo "
                            </div>
                            <a class='carousel-control-prev bg-dark' href='#carouselExampleControls' role='button' data-slide='prev'>
                                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                <span class='sr-only'>Previous</span>
                            </a>
                            <a class='carousel-control-next bg-dark' href='#carouselExampleControls' role='button' data-slide='next'>
                                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                <span class='sr-only'>Next</span>
                            </a>
                        ";
                    } else {
                        echo "
                        <img class='d-block mx-auto' style='height: 450px;' src='uploaded_img/" . $pr_id . "/" . $arr[2] . "'>

                        ";
                    }
                //     <div class='carousel-caption d-none d-md-block'>
                //     <h5 class='text-info'>". explode('.', $arr[$i+2])[0] . "</h5>
                // </div>
                ?>
            </div>
        <div class="text-center">
            <p class="mt-2 display-4 font-weight-bold">Description</p>
        </div>
        <p>
            <?php echo "
                <div class='h5'>
                    " . $product['description'] ."
                </div>
                <div class='h5'>
                    <span class='font-weight-bold'>Price:</span> <span class='text-primary'><u>" . $product['price'] . " $</u></span>
                </div>
                <div class='h5'>
                    <span class='font-weight-bold'>Category:</span> <span class='text-primary'><u>" . $product['category'] . "</u></span>
                </div>
                "; 
            ?>
        </p>

        <div class="d-flex align-items-left  justify-content-start">
            <p class="h5 mt-1">Like: <?php echo $db->getLikeCount(decryptID($_GET['pr_id'], "pr_id")); ?></p>
            <div class="<?php if($db->isLiked($userID, decryptID($_GET['pr_id'], "pr_id"))) { echo 'bg-danger'; }?> rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-2 ml-1" style="width: 35px; height: 35px;">
                <a href="like.php?id=<?php echo $_GET['id']; ?>&pr_id=<?php echo $_GET['pr_id']; ?>" class="text-dark mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center">
            <form action="ins_card.php?id=<?php echo $_GET['id'] ?>&pr_id=<?php echo $_GET['pr_id']; ?>" method="post">
                <div class="form-outline text-center">
                    <input type="number" name="count" min="1" value="1" id="typeNumber" style="border-radius: 25px; width: 250px;" class="form-control" />
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="ml-2 mt-2 btn btn-primary" style="border-radius: 25px;">
                        Add to Card <i class = "fas fa-shopping-cart"> </i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                    <h1 class="mt-4" id="users_comments">Comments (<?php echo $db->getCommentCount(decryptID($_GET['pr_id'], "pr_id")); ?>)</h1>
                    <?php
                        $comments = $db->getComments(decryptID($_GET['pr_id'], "pr_id"), $limit, $offset);
                        
                        foreach ($comments as $comment) {
                            echo "
                            <div class='card mt-3' style='border: 1px solid rgba(16, 46, 46, 1); background-color: rgba(16, 46, 46, 0.973);'>
                                <div class='card-header'>
                                    <div class='d-flex align-items-center'>";
                            
                            $comment_user = $db->getUserByID($comment['user_id']);
                            echo "
                                        <div class='h4 text-white'>" . $comment_user['name'] . " " . $comment_user['surname'] . "</div>
                                        <div class='text-secondary ml-2'> - " . DateTime::createFromFormat('Y-m-d H:i:s', $comment['created_at'])->format('d F, Y') . "</div>
                                    </div>
                                </div>
                                <div class='card-body'>
                                    <blockquote class='blockquote mb-0 text-white'>
                                        <p>" . $comment['content'] . "</p>
                                    </blockquote>
                                </div>
                            </div>
                            ";
                        }

                        $totalComments = count($db->getComments(decryptID($_GET['pr_id'], "pr_id")));
                        $hiddenComments = $totalComments - ($page * $limit);
                        
                        if ($hiddenComments > 0) {
                            echo "
                            <div class='mt-3'>
                                <a class='btn btn-secondary btn-block btn-lg font-weight-bold' href='view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id'] . "&page=" . ($page + 1) . "#users_comments'>View More ($hiddenComments)</a>
                            </div>
                            ";
                        }
                    ?>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-5">
                <form class="fform" id="algin-form" action="view_more.php?id=<?php echo $_GET['id']; ?>&pr_id=<?php echo $_GET['pr_id']; ?>#users_comments" method="post">
                    <div class="form-group">
                        <h4 class="text-white">Leave a comment</h4>
                        <label for="message" class="text-white">Message</label>
                        <textarea name="msg" id="msg" cols="30" rows="5" class="form-control" style="background-color: gray; color: white;"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" name="submit" id="post" class="btn btn-light font-weight-bold">Post Comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php @include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>