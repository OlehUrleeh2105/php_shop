<footer class="bg-dark text-center text-white mt-5">
    <div class="container p-4">
        <section class="mb-4" id="contacts">
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="bx bxl-facebook"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="bx bxl-twitter"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="bx bxl-google"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="bx bxl-instagram"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="bx bxl-linkedin"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="bx bxl-github"></i>
            </a>
        </section>
        <section class="mb-4">
            <p>
            We extend our heartfelt gratitude to you for choosing our shop. 
            Your visit has made a significant impact, and we are genuinely appreciative of your support.
            Thank you for being a part of our journey.
            </p>
        </section>
        <section class="">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Source</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">PHP</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Bootstrap</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Pages</h5>
                        <li>
                            <a href="#!" class="text-white">About</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Card</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Support</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Monobank</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Private 24</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Countries</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Ukraine</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">China</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="text-center">
            <p class="font-weight-bold">
                Wanna leave a feedback? <a href="feedback.php?id=<?php 
                if (isset($_SESSION['user_id'])){
                    echo encryptID($_SESSION['user_id'], "user_id"); 
                } else {
                    echo $_GET['id'];
                }
                ?>" class="link-light text-white">Leave a feedback →</a>
            </p>
        </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2023 Copyright:
        <a class="text-white" href="https://mdbootstrap.com/">PHP SHOP</a>
    </div>
</footer>