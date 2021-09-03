<?php
$active_tab="home";
require_once("header.php");
require_once("menu.php");
$sliders = $QueryFire->getAllData('sliders',' is_show=1');
$adds = $QueryFire->getAllData('adds',' is_show=1');
$banners = $QueryFire->getAllData('banners',' is_show=1');
$recent_products = $QueryFire->getAllData('products',' is_deleted=0 ORDER BY id desc');
$products = array();
    foreach($categories as $cat) {
    $idps = array();
    if(!empty($cat['subcategory'])) {
        $idps = array_column($cat['subcategory'], 'id');
    }
    array_push($idps, $cat['id']);
    $all_product = $QueryFire->getAllData('products',' cat_id in ('.implode(',', $idps).') and is_deleted=0 ');
    if(!empty($all_product)) {
        array_push($products, array('name'=>$cat['name'],'id'=>$cat['id'],'products'=>$all_product));
    }
    unset($all_product);
    }
$popular = array();
    foreach($categories as $cat) {
    $ids = array();
    if(!empty($cat['subcategory'])) {
        $ids = array_column($cat['subcategory'], 'id');
    }
    array_push($ids, $cat['id']);
    $popular_product = $QueryFire->getAllData('products',' cat_id in ('.implode(',', $ids).') and trendings=1 and is_deleted=0 ');
    if(!empty($popular_product)) {
        array_push($popular, array('name'=>$cat['name'],'id'=>$cat['id'],'products'=>$popular_product));
    }
    unset($popular_product);
    }
$newproduct = array();
    foreach($categories as $cat) {
    $idns = array();
    if(!empty($cat['subcategory'])) {
        $idns = array_column($cat['subcategory'], 'id');
    }
    array_push($idns, $cat['id']);
    $new_product = $QueryFire->getAllData('products',' cat_id in ('.implode(',', $idns).') and is_deleted=0 ');
    if(!empty($new_product)) {
        array_push($newproduct, array('name'=>$cat['name'],'id'=>$cat['id'],'products'=>$new_product));
    }
    unset($new_product);
    }    
?>
    <div class="main-wrapper">
        <?php if(!empty($sliders)) { ?>
        <div class="hiraola-slider_area-2">
                <div class="main-slider">
                    <!-- Begin Single Slide Area -->
                    <?php foreach($sliders as $slider) { ?>
                        <div class="single-slide animation-style-01 bg-4" style="background-image: url(<?= base_url.'images/sliders/'.$slider['image_name'] ?>) top center;">
                            <div class="container">
                                <div class="slider-content">
                                    <?php if(!empty($slider['heading'])) { ?>
                                        <h5><span><?= html_entity_decode($slider['heading']) ?></span> This Week </h5>
                                    <?php } ?>    
                                    <h2><?= html_entity_decode($slider['subheading']) ?></h2>
                                    <h3><?= html_entity_decode($slider['description']) ?></h3>
                                    <?php if(!empty($slider['price'])) { ?>
                                       <h4>Starting at <span><span class="fas fa-rupee-sign"><?= html_entity_decode($slider['price']) ?></span></h4>
                                    <?php } ?>
                                    <?php if(!empty($slider['link'])) { ?>
                                        <div class="hiraola-btn-ps_center slide-btn">
                                            <a class="hiraola-btn" href="<?= $slider['link']?>">Shopping Now</a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="slider-progress"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>    
        <div class="hiraola-shipping_area hiraola-shipping_area-2">
            <div class="container">
                <div class="shipping-nav">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="shipping-item">
                                <div class="shipping-icon">
                                    <img src="assets/images/shipping-icon/1.png" alt="Sakshi's Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h6>Free Uk Standard Delivery</h6>
                                    <p>Designated day delivery</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="shipping-item">
                                <div class="shipping-icon">
                                    <img src="assets/images/shipping-icon/2.png" alt="Sakshi's Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h6>Freshyly Prepared Ingredients</h6>
                                    <p>Made for your delivery date</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="shipping-item">
                                <div class="shipping-icon">
                                    <img src="assets/images/shipping-icon/3.png" alt="Sakshi's Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h6>98% Of Anta Clients</h6>
                                    <p>Reach their personal goals set</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="shipping-item">
                                <div class="shipping-icon">
                                    <img src="assets/images/shipping-icon/4.png" alt="Sakshi's Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h6>Winner Of 15 Awards</h6>
                                    <p>Healthy food and drink 2019</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!empty($recent_products)) { ?>
            <div class="hiraola-product_area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hiraola-section_title">
                                <h4>New Arrival</h4>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hiraola-product_slider">
                                <!-- Begin Hiraola's Slide Item Area -->
                                <?php foreach($recent_products as $product) { ?>
                                    <div class="slide-item">
                                        <div class="single_product">
                                            <div class="product-img">
                                                <a href="<?= base_url.'product/'.$product['slug']?>">
                                                    <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                    <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                </a>
                                                <span class="sticker">New</span>
                                                <?php if($product['discount']>0) {?>
                                               <span class="sticker"><?= $product['discount']?> %</span>
                                                <?php } ?>
                                                <div class="add-actions">
                                                    <ul>
                                                        <li><a class="hiraola-add_cart btn-cart"  href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a></li>
                                                        <!-- <li><a class="hiraola-add_compare" href="compare" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i class="ion-ios-shuffle-strong"></i></a></li> -->
                                                        <!-- <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="ion-eye"></i></a></li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="hiraola-product_content">
                                                <div class="product-desc_info">
                                                    <h6><a class="product-name" href="<?= base_url.'product/'.$product['slug']?>"><?= $product['name']?></a></h6>
                                                    <div class="price-box">
                                                        <span class="new-price"><span class="fas fa-rupee-sign"><?= $product['price'] - ($product['price']*$product['discount']/100)?></span>
                                                    </div>
                                                    <div class="additional-add_action">
                                                        <ul>
                                                            <li><a class="hiraola-add_compare btn-wishlist" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- <div class="rating-box">
                                                        <ul>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li class="silver-color"><i class="fa fa-star-of-david"></i></li>
                                                        </ul>
                                                        
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- Hiraola's Slide Item Area End Here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Hiraola's Product Area End Here -->

        <div class="static-banner_area">
            <?php if(!empty($banners)) { ?>
                <div class="container">
                    <div class="row">
                    <?php foreach($banners as $banner) { ?>
                        <div class="col-lg-12">
                            <div class="static-banner-image" style="background-image: url(<?= base_url.'images/banners/'.$banner['image_name'] ?>);"></div>
                            <div class="static-banner-content" style="background-image: url(<?= base_url.'images/banners/'.$banner['image_name'] ?>);">
                                <?php if(!empty($banner['heading'])) { ?>
                                    <p><span><?= html_entity_decode($banner['heading']) ?></span>This Week</p>
                                <?php } ?>    
                                <h2><?= html_entity_decode($banner['subheading']) ?></h2>
                                <h3><?= html_entity_decode($banner['description']) ?></h3>
                                <?php if(!empty($banner['price'])) { ?>
                                    <p class="schedule">
                                        Starting at
                                        <span> <span class="fas fa-rupee-sign"><?= html_entity_decode($banner['price']) ?></span>
                                    </p>
                                <?php } ?>
                                <?php if(!empty($banner['link'])) { ?>
                                    <div class="hiraola-btn-ps_left">
                                        <a href="<?= $banner['link']?>" class="hiraola-btn">Shopping Now</a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>    
                    </div>
                </div>
            <?php } ?> 
        </div>

        <!-- Begin Hiraola's Product Tab Area -->
        <?php if(!empty($newproduct)) { ?>
            <div class="hiraola-product-tab_area-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-tab">
                                <div class="hiraola-tab_title">
                                    <h4>New Products</h4>
                                </div>
                                <ul class="nav product-menu">
                                    <?php $i=0; foreach($newproduct as $cat) { ?>
                                        <li><a class="<?= $i++ == 0?'active':''?>" data-toggle="tab" href="#ncat-<?= $cat['id']?>"><span><?= ucwords($cat['name'])?></span></a></li>
                                        <!-- <li><a data-toggle="tab" href="#earrings-2"><span>Earrings</span></a></li>
                                        <li><a data-toggle="tab" href="#bracelet-2"><span>Bracelet</span></a></li>
                                        <li><a data-toggle="tab" href="#anklet-2"><span>Anklet</span></a></li> -->
                                    <?php } ?>    
                                </ul>
                            </div>
                            <div class="tab-content hiraola-tab_content">
                                <?php $i=0; foreach($newproduct as $cat) { ?>
                                    <div id="ncat-<?= $cat['id']?>" class="tab-pane  <?= $i++ == 0?'active':''?> show" role="tabpanel">
                                        <div class="hiraola-product-tab_slider-2">
                                            <!-- Begin Hiraola's Slide Item Area -->
                                            <?php foreach($cat['products'] as $product) { ?>
                                                <div class="slide-item">
                                                    <div class="single_product">
                                                        <div class="product-img">
                                                            <a href="<?= base_url.'product/'.$product['slug']?>">
                                                                <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                                <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                            </a>
                                                            <div class="add-actions">
                                                                <ul>
                                                                    <li><a class="hiraola-add_cart btn-cart" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a>
                                                                    </li>
                                                                    <!-- <li><a class="hiraola-add_compare" href="compare" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i
                                                                            class="ion-ios-shuffle-strong"></i></a>
                                                                    </li>
                                                                    <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="ion-eye"></i></a></li> -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hiraola-product_content">
                                                            <div class="product-desc_info">
                                                                <h6><a class="product-name" href="<?= base_url.'product/'.$product['slug']?>"><?= $product['name']?></a></h6>
                                                                <div class="price-box">
                                                                    <span class="new-price"><span class="fas fa-rupee-sign"><?= $product['price'] - ($product['price']*$product['discount']/100)?></span>
                                                                </div>
                                                                <div class="additional-add_action">
                                                                    <ul>
                                                                        <li><a class="hiraola-add_compare btn-wishlist" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i
                                                                                class="ion-android-favorite-outline"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- <div class="rating-box">
                                                                    <ul>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                    </ul>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- Hiraola's Slide Item Area End Here -->
                                        </div>
                                    </div>
                                <?php } ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if(!empty($products)) { ?>
            <div class="hiraola-product-tab_area-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-tab">
                                <ul class="nav product-menu">
                                    <?php $i=0; foreach($products as $cat) { ?>
                                        <li><a class="<?= $i++ == 0?'active':''?>" data-toggle="tab" href="#pcat-<?= $cat['id']?>"><span><?= ucwords($cat['name'])?></span></a></li>
                                        <!-- <li><a data-toggle="tab" href="#earrings-2"><span>Earrings</span></a></li>
                                        <li><a data-toggle="tab" href="#bracelet-2"><span>Bracelet</span></a></li>
                                        <li><a data-toggle="tab" href="#anklet-2"><span>Anklet</span></a></li> -->
                                    <?php } ?>    
                                </ul>
                            </div>
                            <div class="tab-content hiraola-tab_content">
                                <?php $i=0; foreach($products as $cat) { ?>
                                    <div id="pcat-<?= $cat['id']?>" class="tab-pane  <?= $i++ == 0?'active':''?> show" role="tabpanel">
                                        <div class="hiraola-product-tab_slider-2">
                                            <!-- Begin Hiraola's Slide Item Area -->
                                            <?php foreach($cat['products'] as $product) { ?>
                                                <div class="slide-item">
                                                    <div class="single_product">
                                                        <div class="product-img">
                                                            <a href="<?= base_url.'product/'.$product['slug']?>">
                                                                <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                                <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                            </a>
                                                            <div class="add-actions">
                                                                <ul>
                                                                    <li><a class="hiraola-add_cart btn-cart" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a>
                                                                    </li>
                                                                    <!-- <li><a class="hiraola-add_compare" href="compare" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i
                                                                            class="ion-ios-shuffle-strong"></i></a>
                                                                    </li>
                                                                    <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="ion-eye"></i></a></li> -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hiraola-product_content">
                                                            <div class="product-desc_info">
                                                                <h6><a class="product-name" href="<?= base_url.'product/'.$product['slug']?>"><?= $product['name']?></a></h6>
                                                                <div class="price-box">
                                                                    <span class="new-price"><span class="fas fa-rupee-sign"> <?= $product['price'] - ($product['price']*$product['discount']/100)?></span>
                                                                </div>
                                                                <div class="additional-add_action">
                                                                    <ul>
                                                                        <li><a class="hiraola-add_compare btn-wishlist" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i
                                                                                class="ion-android-favorite-outline"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- <div class="rating-box">
                                                                    <ul>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                    </ul>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- Hiraola's Slide Item Area End Here -->
                                        </div>
                                    </div>
                                <?php } ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Hiraola's Product Tab Area TwoEnd Here -->

        <div class="hiraola-banner_area-3">
        <?php if(!empty($adds)) { ?>
            <div class="container">
                <div class="row">
                    <?php foreach($adds as $add) { ?>
                        <div class="col-lg-4">
                            <div class="banner-item img-hover_effect">
                                <a href="<?= $add['link']?>">
                                    <img class="img-full" src="<?= base_url.'images/adds/'.$add['image_name'] ?>" alt="Sakshi's Banner">
                                </a>
                            </div>
                        </div>
                    <?php }?>    
                </div>
            </div>
        <?php } ?>    
        </div>

        <!-- Begin Hiraola's Product Tab Area Three -->
        <?php if(!empty($popular)) { ?>
            <div class="hiraola-product-tab_area-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-tab">
                                <div class="hiraola-tab_title">
                                    <h4>Trending Products</h4>
                                </div>
                                <ul class="nav product-menu">
                                    <?php $i=0; foreach($popular as $cat) { ?>
                                        <li><a class="<?= $i++ == 0?'active':''?>" data-toggle="tab" href="#cat-<?= $cat['id']?>"><span><?= ucwords($cat['name'])?></span></a></li>
                                        <!-- <li><a data-toggle="tab" href="#earrings-2"><span>Earrings</span></a></li>
                                        <li><a data-toggle="tab" href="#bracelet-2"><span>Bracelet</span></a></li>
                                        <li><a data-toggle="tab" href="#anklet-2"><span>Anklet</span></a></li> -->
                                    <?php } ?>    
                                </ul>
                            </div>
                            <div class="tab-content hiraola-tab_content">
                                <?php $i=0; foreach($popular as $cat) { ?>
                                    <div id="cat-<?= $cat['id']?>" class="tab-pane  <?= $i++ == 0?'active':''?> show" role="tabpanel">
                                        <div class="hiraola-product-tab_slider-2">
                                            <!-- Begin Hiraola's Slide Item Area -->
                                            <?php foreach($cat['products'] as $product) { ?>
                                                <div class="slide-item">
                                                    <div class="single_product">
                                                        <div class="product-img">
                                                            <a href="<?= base_url.'product/'.$product['slug']?>">
                                                                <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                                <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                            </a>
                                                            <div class="add-actions">
                                                                <ul>
                                                                    <li><a class="hiraola-add_cart btn-cart" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a>
                                                                    </li>
                                                                    <!-- <li><a class="hiraola-add_compare" href="compare" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i
                                                                            class="ion-ios-shuffle-strong"></i></a>
                                                                    </li>
                                                                    <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="ion-eye"></i></a></li> -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hiraola-product_content">
                                                            <div class="product-desc_info">
                                                                <h6><a class="product-name" href="<?= base_url.'product/'.$product['slug']?>"><?= $product['name']?></a></h6>
                                                                <div class="price-box">
                                                                    <span class="new-price"><span class="fas fa-rupee-sign"><?= $product['price'] - ($product['price']*$product['discount']/100)?></span>
                                                                </div>
                                                                <div class="additional-add_action">
                                                                    <ul>
                                                                        <li><a class="hiraola-add_compare btn-wishlist" href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i
                                                                                class="ion-android-favorite-outline"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- <div class="rating-box">
                                                                    <ul>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                        <li><i class="fa fa-star-of-david"></i></li>
                                                                    </ul>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- Hiraola's Slide Item Area End Here -->
                                        </div>
                                    </div>
                                <?php } ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Hiraola's Product Tab Area Three End Here -->


        <?php require_once('footer.php');?>