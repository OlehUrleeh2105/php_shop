<nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="adm_page.php">functions</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            <div class="sidebar-header">
                <div class="user-info">
                    <span class="user-name"><?php
                    if(isset($_SESSION['admin_id'])){
                        $user = $db->getAdminByID($_SESSION['admin_id']);
                        echo $user['name'];
                    } else {
                        echo $user['name'];
                    }
                    ?>
                        <strong><?php
                    if(isset($_SESSION['admin_id'])){
                        $user = $db->getAdminByID($_SESSION['admin_id']);
                        echo $user['surname'];
                    } else {
                        echo $user['surname'];
                    }
                    ?></strong>
                    </span>
                    <span class="user-role">Administrator</span>
                    <span class="user-status">
                        <i class="fa fa-circle"></i>
                        <span>Online</span>
                    </span>
                </div>
            </div>

        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>General</span>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span>E-commerce</span>
                    <span class="badge badge-pill badge-danger">3</span>
                    </a>
                    <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="adm_add.php?id=<?php 
                                if(!isset($_GET['id'])){
                                    echo encryptID($_SESSION['admin_id'], "user_id");
                                } else {
                                    echo $_GET['id'];
                                } 
                            ?>">Add Product</a>
                        </li>
                        <li>
                            <a href="products.php?id=<?php
                                if(!isset($_GET['id'])){
                                    echo encryptID($_SESSION['admin_id'], "user_id");
                                } else {
                                    echo $_GET['id'];
                                } 
                            ?>&page=1">Products</a>
                        </li>
                        <li>
                            <a href="orders.php?id=<?php
                            if(!isset($_GET['id'])){
                                echo encryptID($_SESSION['admin_id'], "user_id");
                            } else {
                                echo $_GET['id'];
                            } 
                            ?>">Orders</a>
                        </li>
                    </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="fa fa-chart-line"></i>
                        <span>Charts</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                            <a href="piechart.php?id=<?php
                            if(!isset($_GET['id'])){
                                echo encryptID($_SESSION['admin_id'], "user_id");
                            } else {
                                echo $_GET['id'];
                            } 
                            ?>">Pie chart</a>
                            </li>
                            <li>
                            <a href="linechart.php?id=<?php 
                            if(!isset($_GET['id'])){
                                echo encryptID($_SESSION['admin_id'], "user_id");
                            } else {
                                echo $_GET['id'];
                            } 
                            ?>">Line chart</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            </div>
        </div>

        <div class="sidebar-footer">
        <a href="#">
            <i class="fa fa-cog"></i>
            <span class="badge-sonar"></span>
        </a>
        <a href="adm_logout.php">
            <i class="fa fa-power-off"></i>
        </a>
        </div>
</nav>