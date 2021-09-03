<?php
$active_tab="about us";
require_once("header.php");
require_once("menu.php");
$page = $QueryFire->getAllData('pageandcontents',' id=1')[0];
?>
       <!-- Begin Hiraola's Breadcrumb Area -->
       <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>About Us</h2>
                    <ul>
                        <li><a href="<?= base_url ?>">Home</a></li>
                        <li class="active">About Us</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
        <!-- Begin Hiraola's About Us Area -->
        <div class="about-us-area">
            <div class="container">
               <?= html_entity_decode($page['text']) ?>
            </div>
        </div>
        <!-- Hiraola's About Us Area End Here -->

        <!-- Begin Hiraola's Project Countdown Area -->
        <div class="project-count-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-count text-center">
                            <div class="count-icon">
                                <span class="ion-ios-briefcase-outline"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count">2169</h2>
                                <span>Project Done</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-count text-center">
                            <div class="count-icon">
                                <span class="ion-ios-wineglass-outline"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count">869</h2>
                                <span>Awards Winned</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-count text-center">
                            <div class="count-icon">
                                <span class="ion-ios-lightbulb-outline"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count">689</h2>
                                <span>Hours Worked</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-count text-center">
                            <div class="count-icon">
                                <span class="ion-happy-outline"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count">2169</h2>
                                <span>Happy Customer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Project Countdown Area End Here -->

        <!-- Begin Hiraola's Team Area -->
        <div class="team-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_title-2">
                            <h4>Our Team</h4>
                        </div>
                    </div>
                </div> <!-- section title end -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="team-member">
                            <div class="team-thumb img-hover_effect">
                                <a href="#">
                                    <img src="assets/images/about-us/team/1.jpg" alt="Our Team Member">
                                </a>
                            </div>
                            <div class="team-content text-center">
                                <h3>Timothy Beck</h3>
                                <p>IT Expert</p>
                                <a href="#">info@example.com</a>
                                <div class="hiraola-social_link">
                                    <ul>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li class="youtube">
                                            <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                        <li class="google-plus">
                                            <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                                <i class="fab fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end single team member -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="team-member">
                            <div class="team-thumb img-hover_effect">
                                <a href="#">
                                    <img src="assets/images/about-us/team/2.jpg" alt="Our Team Member">
                                </a>
                            </div>
                            <div class="team-content text-center">
                                <h3>Sarah Sanchez</h3>
                                <p>Web Designer</p>
                                <a href="#">info@example.com</a>
                                <div class="hiraola-social_link">
                                    <ul>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li class="youtube">
                                            <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                        <li class="google-plus">
                                            <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                                <i class="fab fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end single team member -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="team-member">
                            <div class="team-thumb img-hover_effect">
                                <a href="#">
                                    <img src="assets/images/about-us/team/3.jpg" alt="Our Team Member">
                                </a>
                            </div>
                            <div class="team-content text-center">
                                <h3>Edwin Adams</h3>
                                <p>Content Writer</p>
                                <a href="javascript:void(0)">info@example.com</a>
                                <div class="hiraola-social_link">
                                    <ul>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li class="youtube">
                                            <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                        <li class="google-plus">
                                            <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                                <i class="fab fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end single team member -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="team-member">
                            <div class="team-thumb img-hover_effect">
                                <a href="#">
                                    <img src="assets/images/about-us/team/4.jpg" alt="Our Team Member">
                                </a>
                            </div>
                            <div class="team-content text-center">
                                <h3>Anny Adams</h3>
                                <p>Marketing officer</p>
                                <a href="#">info@example.com</a>
                                <div class="hiraola-social_link">
                                    <ul>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li class="youtube">
                                            <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                        <li class="google-plus">
                                            <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                                <i class="fab fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end single team member -->
                </div>
            </div>
        </div>
        <!-- Hiraola's Team Area End Here -->
<?php require_once('footer.php');?>