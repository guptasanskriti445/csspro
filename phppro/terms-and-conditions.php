<?php
$active_tab = 'terms and conditions';
require_once('header.php');
require_once('menu.php');
$page = $QueryFire->getAllData('pageandcontents',' id=6')[0];
?>
    <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Terms & Conditions</h2>
                    <ul>
                        <li><a href="<?= base_url ?>">Home</a></li>
                        <li class="active">Terms & Conditions</li>
                    </ul>
                </div>
            </div>
        </div><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <p>
        <?= html_entity_decode($page['text']) ?>
        </p>
      </div>
    </section>
<?php require_once('footer.php');?>