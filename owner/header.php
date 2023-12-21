<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container">
        <a class="navbar-brand text-light" href="own_page.php">OwnerPanel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-light font-weight-bold" href="table_type.php?id=<?php 
                    if(isset($_SESSION['owner_id'])){
                        echo encryptID($_SESSION['owner_id'], 'user_id');
                    } else {
                        echo decryptID(encryptID($_GET['id'], "user_id"), "user_id");
                    }
                    ?>">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light font-weight-bold" href="messages.php?id=<?php 
                        if(isset($_SESSION['owner_id'])){
                            echo encryptID($_SESSION['owner_id'], 'user_id');
                        } else {
                            echo decryptID(encryptID($_GET['id'], "user_id"), "user_id");
                        }
                    ?>&action=not_viewed">
                        Messages
                    </a>
                </li>
            </ul>
        </div>
        <a href="own_logout.php" class="btn btn-outline-light">Logout</a>
    </div>
</nav>