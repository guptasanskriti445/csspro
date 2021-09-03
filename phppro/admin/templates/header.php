<?php 
session_start();
require_once('query.php');
if(!isset($_SESSION['admin'])){
  //header('Location:'.admin_path);
  echo '<script>window.location.href="'.admin_path.'";</script>';die;
}
$loadJSCSS = array('form','datatable','both');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0a8044">
  <title><?= isset($active_tab)?(isset($active_sub_tab)?ucwords($active_sub_tab):ucwords($active_tab)):'Dashboard'?> | <?= admin?></title>
  <link rel="shortcut icon" href="<?= image_path?>favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <?php if(isset($jscss) && in_array($jscss, $loadJSCSS)) { if($jscss=='both' || $jscss=='form') { ?>
      <!-- Daterange picker -->
      <link rel="stylesheet" href="<?= base_url?>plugins/daterangepicker/daterangepicker.css">
      <!-- iCheck for checkboxes and radio inputs -->
      <link rel="stylesheet" href="<?= base_url?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="<?= base_url?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- Select2 -->
      <link rel="stylesheet" href="<?= base_url?>plugins/select2/css/select2.min.css">
      <link rel="stylesheet" href="<?= base_url?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
      <!-- Bootstrap4 Duallistbox -->
      <link rel="stylesheet" href="<?= base_url?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
      <!-- BS Stepper -->
      <link rel="stylesheet" href="<?= base_url?>plugins/bs-stepper/css/bs-stepper.min.css">
      <!-- dropzonejs -->
      <link rel="stylesheet" href="<?= base_url?>plugins/dropzone/min/dropzone.min.css">
      <!-- summernote -->
      <link rel="stylesheet" href="<?= base_url?>plugins/summernote/summernote-bs4.min.css">
    <?php } if ($jscss=='datatable' || $jscss=='both' ) { ?>
      <!-- DataTables -->
      <link rel="stylesheet" href="<?= base_url?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="<?= base_url?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="<?= base_url?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php } } ?>

  <link rel="stylesheet" href="<?= base_url?>dist/css/adminlte.min.css">
  <style type="text/css">
  	.nav-treeview{margin-left: 5px;}
  	.hide{display: none;}
  	table.dataTable>tbody>tr.child ul.dtr-details{white-space:normal}
  </style>
  <?= isset($prependScript)?$prependScript:""?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	      </li>
	    </ul>
	    <ul class="navbar-nav ml-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="<?= admin_path?>logout" role="button">
	          <i class="fas fa-power-off"></i> Logout
	        </a>
	      </li>
	    </ul>
	</nav>