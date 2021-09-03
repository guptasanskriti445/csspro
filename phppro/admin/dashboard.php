<?php
$active_tab='dashboard';
require_once('templates/header.php');
require_once('templates/sidebar.php');
$requests = $QueryFire->getAllData('contact_enquiry',' 1');

$new_orders = $QueryFire->getAllCount('orders WHERE status="in-prodcess"');
$users = $QueryFire->getAllCount('users WHERE is_deleted=0');
$products = $QueryFire->getAllCount('products WHERE is_deleted=0');
$requests = $QueryFire->getAllCount('contact_enquiry WHERE 1');
?>
	<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row row-cols-1 row-cols-sm-6 row-cols-md-3 row-cols-lg-4 justify-content-center">
        <div class="col">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-bag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">New Orders</span>
              <span class="info-box-number"><?= $new_orders?></span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Users</span>
              <span class="info-box-number"><?= $users?></span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-fuchsia elevation-1"><i class="fas fa-phone-volume"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Contact Requests</span>
              <span class="info-box-number"><?= $requests?></span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-fuchsia elevation-1"><i class="fas fa-product-hunt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Products</span>
              <span class="info-box-number"><?= $products?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php require_once('templates/footer.php');?>