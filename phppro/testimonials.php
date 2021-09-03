<?php
$active_tab = 'testimonials';
require_once('header.php');
require_once('menu.php');
$testimonials = $QueryFire->getAllData(' testimonials',' is_show=1 ORDER BY id ');
?>
    <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Testimonials</h2>
                    <ul>
                        <li><a href="<?= base_url ?>">Home</a></li>
                        <li class="active">Testimonials</li>
                    </ul>
                </div>
            </div>
        </div><!-- End Breadcrumbs -->

       <!-- Begin Hiraola's Team Area -->
       <div class="team-area">
            <div class="container">
                <?php if(!empty( $testimonials)) { ?>
                    <div class="row my-auto">
                        <?php foreach( $testimonials as  $testimonials) { ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="team-member">
                                    <div class="team-thumb img-hover_effect">
                                        <a href="#">
                                            <img src="<?= base_url.'images/testimonials/'.$testimonials['image_name']?>" alt="<?=  $testimonials['name']?>">
                                        </a>
                                    </div>
                                    <div class="team-content text-center">
                                        <h3><?=  $testimonials['name']?></h3>
                                        <p> <?=  $testimonials['opinion']?></p>
                                    </div>
                                </div>
                            </div> <!-- end single team member -->
                        <?php } ?>     
                    </div>
                <?php } ?>    
            </div>
        </div>
        <!-- Hiraola's Team Area End Here -->
<?php require_once('footer.php');?>