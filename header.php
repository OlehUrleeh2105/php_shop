<nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
    <a class="navbar-brand text-light" href="home.php">PHP SHOP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light" data-toggle="dropdown">
                    Pages+
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.php?id=<?php 
                    if (isset($_SESSION['user_id'])){
                        echo encryptID($_SESSION['user_id'], "user_id"); 
                    } else {
                        echo $_GET['id'];
                    } ?>&page=1">About</a>
                    <a class="dropdown-item" href="#contacts">Contact</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="home.php">Shop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="orders.php?id=<?php
                if (isset($_SESSION['user_id'])){
                    echo encryptID($_SESSION['user_id'], "user_id"); 
                } else {
                    echo $_GET['id'];
                }
                ?>">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="send.php?id=<?php 
                if (isset($_SESSION['user_id'])){
                    echo encryptID($_SESSION['user_id'], "user_id"); 
                } else {
                    echo $_GET['id'];
                }
                ?>">Account+</a>
            </li>
        </ul>
        <div class="shopping mr-2">
            <a href="card.php?id=<?php
            if (isset($_SESSION['user_id'])){
                echo encryptID($_SESSION['user_id'], "user_id"); 
            } else {
                echo $_GET['id'];
            }
            ?>"><img src="img/basket.png" alt="basket"></a>
            <a href="whishlist.php?id=<?php 
                if (isset($_SESSION['user_id'])){
                    echo encryptID($_SESSION['user_id'], "user_id"); 
                } else {
                    echo $_GET['id'];
                }
                ?>"><img src="img/heart.png" alt="whishlist" style="width: 30px; height: 30px;"></a>
        </div>
        <a href="logout.php" class="btn btn-light btn-outline-light">Logout</a>
    </div>
</nav>