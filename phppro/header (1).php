<?php
session_start();
require_once('admin/query.php');
$loggedPages = array('my account','place order');
$nonloggedPages = array('login');
if(in_array(strtolower($active_tab), $loggedPages) && !isset($_SESSION['user'])) {
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header('Location:'.base_url.'login?url='.urlencode($actual_link));
} else if(in_array(strtolower($active_tab), $nonloggedPages) && isset($_SESSION['user'])) {
  header('Location:'.base_url);
}
$categories = $QueryFire->getAllData('categories',' is_show=1 and is_deleted=0 order by reference');
$allcategories = $categories;
if(!empty($categories)) {
  $cat = array_filter($categories,function($a) {
    return $a['level'] ==1;
  });
  foreach($cat as $key=> $maincat) {
    $cat[$key]['subcategory'] = array_filter($categories,function($a) use ($maincat) {
      return ($a['level'] == 2 && $a['parent_id'] == $maincat['id']);
    });
  }
  $categories = array_values($cat);
  unset($cat);
}
if(isset($_REQUEST['slug'])) {
  $product = $QueryFire->getAllData('products',' slug="'.$_REQUEST['slug'].'"');
  $product = $product[0];
  $seo = array();
  $seo['title'] = empty($product['meta_title'])?$product['name']:$product['meta_title'];;
  $seo['description'] = $product['meta_description'];
} else if(isset($_REQUEST['bslug'])) {
  $blog = $QueryFire->getAllData('',' ','SELECT b.*,c.name as category,c.slug as cslug FROM blogs as b LEFT JOIN blog_categories as c ON c.id=b.cat_id WHERE b.slug="'.$_REQUEST['bslug'].'"')[0];
  $seo = array();
  $seo['title'] = empty($blog['meta_title'])?$blog['title']:$blog['meta_title'];;
  $seo['description'] = $blog['meta_description'];
} else {
  $seo = $QueryFire->getAllData('seo',' page_name = "'.strtolower($active_tab).'"');
  if(!empty($seo)) {
    $seo = $seo[0];
  }
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- <title>Home || Sakshi - Jewellery eCommerce Bootstrap 4 Template</title> -->
    <title><?= !empty($seo['title'])? $seo['title'] :((isset($active_tab)?ucwords($active_tab):'Home').' || Sakshi - Jewellery eCommerce Bootstrap 4 Template')?></title>

    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url?>assets/images/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/vendor/bootstrap.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/vendor/font-awesome.css">
    <!-- Fontawesome Star -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/vendor/fontawesome-stars.css">
    <!-- Ion Icon -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/vendor/ion-fonts.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/plugins/slick.css">
    <!-- Animation -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/plugins/animate.css">
    <!-- jQuery Ui -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/plugins/jquery-ui.min.css">
    <!-- Lightgallery -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/plugins/lightgallery.min.css">
    <!-- Nice Select -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/plugins/nice-select.css">
    <!-- Timecircles -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/plugins/timecircles.css">

    <!-- Vendor & Plugins CSS (Please remove the comment from below vendor.min.css & plugins.min.css for better website load performance and remove css files from the above) -->
    <!--
    <script src="assets/js/vendor/vendor.min.js"></script>
    <script src="assets/js/plugins/plugins.min.js"></script>
    -->

    <!-- Main Style CSS (Please use minify version for better website load performance) -->
    <link rel="stylesheet" href="<?= base_url?>assets/css/style.css">
    <!--<link rel="stylesheet" href="assets/css/style.min.css">-->

</head>

<body class="template-color-2">

