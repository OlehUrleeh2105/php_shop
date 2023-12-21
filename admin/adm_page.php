<?php
session_start();
require '../db.php';
require '../enc.php';

if (!isset($_SESSION['admin_id'])) {
    header('location: ../index.php');
    exit();
}

$db = new DB();
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
    <title>Admin panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm_style.css">
</head>

<body>
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>

    <?php @include 'header.php'; ?>

    <main class="page-content">
        <div class="container">
            
        </div>
    </main>
    <!-- sidebar-wrapper  -->
    <!-- <main class="page-content">
        <div class="container-fluid">
        <h2>Pro Sidebar</h2>
        <hr>
        <div class="row">
            <div class="form-group col-md-12">
            <p>This is a responsive sidebar template with dropdown menu based on bootstrap 4 framework.</p>
            <p> You can find the complete code on <a href="https://github.com/azouaoui-med/pro-sidebar-template" target="_blank">
                Github</a>, it contains more themes and background image option</p>
            </div>
            <div class="form-group col-md-12">
            <iframe src="https://ghbtns.com/github-btn.html?user=azouaoui-med&repo=pro-sidebar-template&type=star&count=true&size=small" frameborder="0" scrolling="0" width="90px" height="30px"></iframe>
            <iframe src="https://ghbtns.com/github-btn.html?user=azouaoui-med&repo=pro-sidebar-template&type=fork&count=true&size=small" frameborder="0" scrolling="0" width="90px" height="30px"></iframe>
            </div>
            <div class="form-group col-md-12">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">New !</h4>
                <p>New react pro sidebar library is now available on <a href="https://www.npmjs.com/package/react-pro-sidebar" target="_blank">npm</a> <a href="https://github.com/azouaoui-med/react-pro-sidebar" target="_blank">
                    <img alt="GitHub stars" src="https://img.shields.io/github/stars/azouaoui-med/react-pro-sidebar?style=social" />
                </a></p>
                <a href="https://github.com/azouaoui-med/react-pro-sidebar" target="_blank" class="btn btn-sm btn-primary mr-2">
                Github</a>
                <a href="https://azouaoui-med.github.io/react-pro-sidebar" target="_blank" class="btn btn-sm btn-success">
                Demo</a>

            </div>

            </div>
        </div>
        <h5>More templates</h5>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="card rounded-0 p-0 shadow-sm">
                <img src="https://user-images.githubusercontent.com/25878302/58369568-a49b2480-7efc-11e9-9ca9-2be44afacda1.png" class="card-img-top rounded-0" alt="Angular pro sidebar">
                <div class="card-body text-center">
                <h6 class="card-title">Angular Pro Sidebar</h6>
                <a href="https://github.com/azouaoui-med/angular-pro-sidebar" target="_blank" class="btn btn-primary btn-sm">Github</a>
                <a href="https://azouaoui-med.github.io/angular-pro-sidebar/demo/" target="_blank" class="btn btn-success btn-sm">Preview</a>
                </div>
            </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="card rounded-0 p-0 shadow-sm">
                <img src="https://user-images.githubusercontent.com/25878302/58369258-33f20900-7ef8-11e9-8ff3-b277cb7ed7b4.PNG" class="card-img-top rounded-0" alt="Angular pro sidebar">
                <div class="card-body text-center">
                <h6 class="card-title">Angular Dashboard</h6>
                <a href="https://github.com/azouaoui-med/lightning-admin-angular" target="_blank" class="btn btn-primary btn-sm">Github</a>
                <a href="https://azouaoui-med.github.io/lightning-admin-angular/demo/" target="_blank" class="btn btn-success btn-sm">Preview</a>
                </div>
            </div>
            </div>
        </div>
        <hr>

        <footer class="text-center">
            <div class="mb-2">
            <small>
                © 2020 made with <i class="fa fa-heart" style="color:red"></i> by - <a target="_blank" rel="noopener noreferrer" href="https://azouaoui.netlify.com">
                Mohamed Azouaoui
                </a>
            </small>
            </div>
            <div>
            <a href="https://github.com/azouaoui-med" target="_blank">
                <img alt="GitHub followers" src="https://img.shields.io/github/followers/azouaoui-med?label=github&style=social" />
            </a>
            <a href="https://twitter.com/azouaoui_med" target="_blank">
                <img alt="Twitter Follow" src="https://img.shields.io/twitter/follow/azouaoui_med?label=twitter&style=social" />
            </a>
            </div>
        </footer>
        </div>
    </main> -->

    </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
        <script src="../js/adm.js"></script>
</body>

</html>
