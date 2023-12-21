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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/feedbacks_about.css">


    <title>About</title>
</head>
<body>

    <?php @include 'header.php'; ?>

    <div class="container">
        <div class="title text-center">
            <h1 class="text-uppercase my-5">About</h1>
        </div>
        <div class="card border-white mb-4">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid rounded" src="https://ichef.bbci.co.uk/news/999/cpsprodpb/15951/production/_117310488_16.jpg" alt="">
                </div>
                <div class="col-md-6">
                    <div class="card-body mt-5">
                        <div class="mt-2 card-title text-center h2 font-weight-bold mb-4">Why to choose us?</div>
                        <p class="text-center">At our company, we strive to provide exceptional products/services and deliver outstanding customer satisfaction. With years of industry experience and a dedicated team, we are committed to excellence and reliability. Our core values include professionalism, innovation, and integrity.</p>
                        <div class="text-center">
                            <a href="home.php" class="btn btn-outline-info" style="width: 160px;">Our Shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-white mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body mt-5">
                        <div class="mt-4 card-title text-center h2 font-weight-bold mb-4">What we provide?</div>
                        <p class="text-center">At our company, we take pride in providing a comprehensive range of services tailored to meet your needs. You can easilly become an admin and post your own products. Whether you require professional consultations, efficient project management, reliable maintenance.</p>
                        <div class="text-center">
                            <a href="send.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-info" style="width: 160px;">Send Message</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid rounded" src="https://cdn.pixabay.com/photo/2012/06/19/10/32/owl-50267_960_720.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="card border-white mb-4">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid rounded" src="https://cdn.pixabay.com/photo/2015/10/30/20/13/sunrise-1014712_960_720.jpg" alt="">
                </div>
                <div class="col-md-6">
                    <div class="card-body mt-5">
                        <div class="mt-4 card-title text-center h2 font-weight-bold mb-4">Who we are?</div>
                        <p class="text-center">We are a passionate team of professionals dedicated to making a difference. With years of experience in the industry, we have built a strong reputation for our expertise and commitment to excellence. Our core values of integrity, innovation, and customer satisfaction guide.</p>
                        <div class="text-center">
                            <a href="#feedbacks" class="btn btn-outline-info" style="width: 160px;">Clients feedbacks</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center display-4 font-weight-bold" id="feedbacks">
            Clients feedbacks
        </div>
        <div class='row row-cols-3 g-4 mt-5'>
            <?php
                $page = $_GET['page'];
                if(!isset($_GET['page']) || $page == 1){
                    $page = 0;
                } else {
                    $page = ($page * 8) - 8;
                }

                $backs = $db->getFeedbacks($page);
                $index = 0;
                foreach ($backs as $row) {
                    echo "
                        <div class='col mb-3'>
                            <div class='card d-flex align-items-stretch'>
                                <div class='card-body'>
                                    <div class='rating'>
                                ";
                                
                    for ($i = 5; $i > 0; $i--) {
                        $inputId = 'input_' . $index . '_' . $i;
                        $inputName = 'rating_' . $index;
                        echo "<input type='radio' name='" . $inputName . "' value='" . $i . "' id='" . $inputId . "' disabled";
                        if ($i == $row['rate']) {
                            echo " checked";
                        }
                        echo "><label for='" . $inputId . "'>☆</label>";
                    }
                
                    $feedback = str_replace('_', ' ', $row['content']);
                    if (strlen($row['content']) > 25) {
                        $feedback = substr($feedback, 0, 25) . '...';
                    }
                    
                    echo "
                                    </div>
                                    <div class='text-center font-weight-bold h4'>
                                        " . $row['user_name'] . "
                                    </div>
                                    <p class='card-text'>" . $feedback . "</p>
                                    <button type='button' class='btn btn-outline-primary btn-block font-weight-bold' data-toggle='modal' data-target='#exampleModalLong_" . $index . "'>Read All</button>
                                    <div class='text-right'>
                                        <p class='card-text text-muted'>";
                    
                    $currentDate = new DateTime();
                    $interval = $currentDate->diff(new DateTime($row['created_at']));
                    $daysDiff = $interval->days;
                    echo "Posted {$daysDiff} days ago.";
                    
                    echo "
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                
                    echo "
                    <div class='modal fade' id='exampleModalLong_" . $index . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle_" . $index . "' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLongTitle_" . $index . "'>" . $row['user_name'] . "</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    " . str_replace('_', ' ', $row['content']) . "
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary btn-block' data-dismiss='modal'>Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
                    $index++;
                }                                               
            ?>
        </div>
        <?php
            $count = $db->getFeedBacksCount();
            $some = $count / 8;
            $some = ceil($some);

            echo "<div class='text-center'>";
                for($i = 1; $i <= $some; $i++){
                    if ($_GET['page'] == $i){
                        echo "
                            <a class='btn btn-outline-primary font-weight-bold mb-2 active' href='about.php?id=" . $_GET['id'] . "&page=" . $i . "#feedbacks'>$i</a>
                        ";
                    } else {
                        echo "
                            <a class='btn btn-outline-primary font-weight-bold mb-2' href='about.php?id=" . $_GET['id'] . "&page=" . $i . "#feedbacks'>$i</a>
                        ";
                    }
                }
            echo "</div>"
            ?>         
    </div>

    <?php @include 'footer.php'; ?>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/main.js"></script>

</html>