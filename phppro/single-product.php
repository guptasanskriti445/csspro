<?php
$active_tab="single product";
require_once("header.php");
require_once("menu.php");
if(isset($_POST['star'])) {
    if(isset($_SESSION['user'])) {
        $dummy = $QueryFire->getAllData('product_reviews','product_id="'.$product['id'].'" and user_id='.$_SESSION['user']['id']);
        if(!empty($dummy)) {
            $_POST['product_id'] = $product['id'];
            $_POST['user_id'] = $_SESSION['user']['id'];
            if($QueryFire->insertData('product_reviews',$_POST)) {
                $msg = "<h4 class='text-center text-info'>Your review is under checking. Review will be shown after admin approval.</h4>";
            } else {
                $msg = "<h4 class='text-center text-danger'> Sorry! System is busy. Try after some time.</h4>";
            }
        } else {
            $msg = "<h4 class='text-center text-danger'>You have already given review to this product.</h4>";
        }
    } else {
        $msg = "<h4 class='text-center text-danger'>You must login first to review this product.</h4>";
    }
}
$reviews = $QueryFire->getAllData('','','SELECT r.*,u.name as user FROM product_reviews as r LEFT JOIN products as p ON p.id=r.product_id LEFT JOIN users as u ON u.id=r.user_id WHERE r.is_approved=1 and r.product_id='.$product['id'] .' ORDER BY r.id desc');
$recent_products = $QueryFire->getAllData('products',' is_deleted=0 ORDER BY id desc');
$product_images = $QueryFire->getAllData('products_has_images','product_id="'.$product['id'].'"');
array_push($product_images, array('image_name'=>$product['image_name']));
//get products params
$params = $QueryFire->getAllData('','',"SELECT pv.*,php.name FROM product_params_values as pv LEFT JOIN product_has_params as php ON php.id=pv.param_id WHERE pv.id in (".$product['param_value_id'].")");
$filters = array();
foreach($params as $param) {
    $filters[strtolower($param['name'])][]= $param;
}
?>
<style>
    /* .fa-star{
    color: #e9cb63a6;
} */
.active{
    color: #cda557;
}


</style>
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2><?= $product['title']?></h2>
                    <ul>
                        <li><a href="<?= base_url?>">Home</a></li>
                        <li><a href="<?= base_url?>products">Products</a></li>
                        <li class="active"><?= $product['title']?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sp-area">
            <div class="container">
                <div class="sp-nav">
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <div class="sp-img_area">
                                <?php  $i=0; foreach($product_images as $image) {?>
                                    <div class="zoompro-border ">
                                        <img class="zoompro" src="<?= base_url.'images/products/'.$image['image_name']?>" data-zoom-image="<?= base_url.'images/products/'.$image['image_name']?>" alt="Rica's Product Image" />
                                    </div>
                                    
                                <?php if($i=1){ break; }?>
                                <?php } ?>    
                                <div id="gallery" class="sp-img_slider">
                                    <?php  $i=0; foreach($product_images as $image) {?>

                                    <a class="<?= $i++ == 0?'active':''?>" data-image="<?= base_url.'images/products/'.$image['image_name']?>" data-zoom-image="<?= base_url.'images/products/'.$image['image_name']?>">
                                        <img src="<?= base_url.'images/products/'.$image['image_name']?>" alt="Rica's Product Image" style="width:4rem;">
                                    </a>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="sp-content">
                                <div class="sp-heading">
                                    <h5><a href="#"><?= $product['name']?></a></h5>
                                </div>
                                <div class="rating-box product--rating">
                                    <?php 
                                    $average = 0;
                                    $a = array_filter($reviews);
                                    if(count($a)) {
                                        $average = ceil(array_sum(array_column($reviews, 'star'))/count($a));
                                    }
                                    unset($a);
                                    for($i=1;$i<=5;$i++) {
                                        echo '<i class="fa fa-star '.($i <= $average ?'active':'').'"></i>';
                                    } ?>
                                    
                                </div>
                                <div class="sp-essential_stuff">
                                    <ul>
                                        <li>Price: <a href="javascript:void(0)"><span><span class="fas fa-rupee-sign"><?= $product['price'] - ($product['price']*$product['discount']/100)?></span></a></li>
                                        <li>Availability: <a href="javascript:void(0)"><?= $product['qty']>0?'In Stock':'Out of Stock'?></a></li>
                                    </ul>
                                </div>
                                <div class="product-size_box">
                                       <?php foreach($filters as $fkey=>$filter) { ?>
                            <h6><?= ucwords($fkey).' : '.$product['param_value'].$filter[0]['param_value']?> </h6>
                        <?php } ?>
                                </div>
                                <div class="product-quantity quantity">
                                    <label>Quantity</label>
                                        <div class="btn-group product-quantity">
                                            <button type="button" class="prev btn minus"  value="-" style="border:solid 1px gray;border-right:0px;">-</button>
                                            <button class="show-number qty input-qty1 px-2" style="border:solid 1px gray;" id="pro1-qunt" max="<?= $product['qty']?>" data-max="<?= $product['qty']?>" min="1" data-min="1" data-id="<?= $product['id']?>" ><?= isset($_SESSION['cartitems'][$product['id']]['quantity'])?$_SESSION['cartitems'][$product['id']]['quantity']:1?></button>
                                            <button type="button" class="next btn plus" style="border:solid 1px gray;border-left:0px;" value="+">+</button>
                                        </div>
                                                            
                                            
                                </div>
                                <div class="qty-btn_area">
                                    <ul>
                                        <li><a class="qty-cart_btn btn-cart" href="javascript:void(0)"  data-id="<?= $product['id']?>">Add To Cart</a></li>
                                        <li><a class="qty-cart_btn" href="<?= base_url.'buy/'.$product['slug']?>" data-toggle="tooltip" title="Buy This Product">BUY</a></li>
                                        <li><a class="qty-wishlist_btn btn-wishlist" href="javascript:void(0)"  data-id="<?= $product['id']?>" data-toggle="tooltip" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i></a></li>
                                    </ul>
                                </div>
                                <div class="hiraola-social_link">
                                    <ul>
                                        <li class="facebook">
                                            <a href="http://www.facebook.com/sharer.php?u=<?= base_url.'product/'.$product['slug'] ?>" data-toggle="tooltip" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                             <a href="https://www.twitter.com/sharer.php?u=<?= base_url.'product/'.$product['slug'] ?>" data-toggle="tooltip" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://www.instagram.com/sharer.php?u=<?= base_url.'product/'.$product['slug'] ?>" data-toggle="tooltip" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hiraola-product-tab_area-2 sp-product-tab_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sp-product-tab_nav ">
                            <div class="product-tab">
                                <ul class="nav product-menu">
                                    <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a>
                                    </li>
                                    <li><a data-toggle="tab" href="#reviews"><span>Reviews <?= !empty($reviews) ? '('. count($reviews) .')' : '' ?></span></a></li>
                                </ul>
                            </div>
                            <div class="tab-content hiraola-tab_content">
                                <div id="description" class="tab-pane active show" role="tabpanel">
                                    <div class="product-description">
                                         <?= html_entity_decode($product['details']) ?>
                                    </div>
                                </div>
                                <div id="reviews" class="tab-pane" role="tabpanel">
                                    <div class="tab-pane active" id="tab-review">
                                            <?php if(!empty($reviews)) { ?>
                                                <div id="review">
                                                    <table class="table table-striped table-bordered">
                                                        <tbody class="product--review-comments">
                                                            <?php foreach($reviews as $review) { ?>
                                                                <tr>
                                                                    <td style="width: 50%;"><strong><?= ucwords(strtolower($review['user']))?></strong></td>
                                                                    <td class="text-right"><?= $review['date']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <h6><?= $review['heading']?></h6>
                                                                        <p><?= $review['review']?></p>
                                                                        <div class="rating-box product--rating">
                                                                            <!-- <ul>
                                                                                <li><i class="fa fa-star-of-david"></i></li>
                                                                                <li><i class="fa fa-star-of-david"></i></li>
                                                                                <li><i class="fa fa-star-of-david"></i></li>
                                                                                <li><i class="fa fa-star-of-david"></i></li>
                                                                                <li><i class="fa fa-star-of-david"></i></li>
                                                                            </ul> -->
                                                                            <?php for($i=1;$i<=5;$i++) {
                                                                                echo '<i class="fa fa-star '.($i <= $review['star'] ?'active':'').'"></i>';
                                                                            } ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>  
                                            
                                            <div class="form--review-rating ">
                                                <h2>Write a review</h2>
                                                <div class="form--review-rating-content form-group last-child required">
                                                    <span>Your Rating</span>
                                                    <div class="product--rating star">
                                                        <a href="javascript:void(0)" data-rating="1"><i class="fa fa-star"></i></a>
                                                    </div>
                                                    <div class="product--rating star">
                                                        <a href="javascript:void(0)" data-rating="2">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </a>
                                                    </div>
                                                    <div class="product--rating star">
                                                        <a href="javascript:void(0)" data-rating="3" >
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </a>
                                                    </div>
                                                    <div class="product--rating star">
                                                        <a href="javascript:void(0)" data-rating="4">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </a>
                                                    </div>
                                                    <div class="product--rating star">
                                                        <a href="javascript:void(0)" data-rating="5">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form--review">
                                                <form method="post" class="rating-form form-horizontal">
                                                    <div class="form-group required">
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" required class="review-input" name="heading" placeholder="Enter review title" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group required second-child">
                                                        <div class="col-sm-12 p-0">
                                                            <label class="">Share your opinion</label>
                                                            <textarea class="review-textarea" required name="review" rows="2" placeholder="Comment review"></textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="star" class="star">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 text--center">
                                                        <?php if(isset($_SESSION['user'])) { ?>
                                                            <button type="submit" class=" hiraola-btn hiraola-btn_dark btn-review btn--primary">Submit<i class="lnr lnr-arrow-right"></i></button>
                                                        <?php } else { ?>
                                                            <h6 class="text-info text-center">You must login to comment on this. <a href="<?= base_url.'login?url='.urlencode(base_url.'product/'.$product['slug'])?>">Click here</a> to login.</h6>
                                                        <?php } ?>
                                                    </div>
                                                </form>
                                            </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!empty($recent_products)) { ?>
            <div class="hiraola-product_area hiraola-product_area-2 ">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hiraola-section_title">
                                <h4>Recent Products</h4>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hiraola-product_slider-3">
                                <?php foreach($recent_products as $product) { ?>
                                        <div class="slide-item">
                                            <div class="single_product">
                                                <div class="product-img">
                                                    <a href="<?= base_url.'product/'.$product['slug']?>">
                                                        <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                        <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                    </a>
                                                    <?php if($product['discount']>0) {?>
                                                       <span class="sticker"><?= $product['discount']?> %</span>
                                                    <?php } ?>
                                                    <div class="add-actions">
                                                        <ul>
                                                            <li><a class="hiraola-add_cart btn-cart"  href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="hiraola-product_content pt-2">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Hiraola's Product Area Two End Here -->

    
<?php

$appendScript = '<script>
    $(function(event){
        $("select[name=sort_by]").on("change",function(event) {
            event.preventDefault();
            $(".sort-form").submit();
        });
        $(".filter-form input,#amount").on("change",function(event) {
            event.preventDefault();
            $(".filter-form").submit();
        });
          $(".minus,.plus").on("click",function(event){
        console.log("hei");
        event.preventDefault();
        var This = $(this).parent(".product-quantity").find(".input-qty1");
        if($(This).data("max") >= $(This).val() && $(This).val()> 0 ) {
            $(This).trigger("change");
            var id = $(This).data("id");
            var quantity = $(This).val();
            if($(this).hasClass("minus")) {
                quantity--;
            } else {
                quantity++;
            }
            var url = "<?=base_url?>addtocart";
            $.ajax({
                url:url,
                data:{id:id,action:"quantity",quantity:quantity},
                type:"post",
                success:function(result){
                  var s =$.parseJSON(result);
                  $(".bigcounter").html(s.count);
                },
                error:function(error){
                  console.log("Error occured");
                }
            });
        } else {
            alert("Quantity can not be more than "+$(This).data("max"));
            $(This).val($(This).data("max"));
            return 0;
        }
    });
        $(".product--rating a").on("click",function(event) {
            $(".star").val($(this).data("rating"));
            $(this).find("i").addClass("active");
            $(".product--rating a i").removeClass("active");
            $(this).find("i").addClass("active");
        });
        $(".btn-review").on("click",function(event) {
            event.preventDefault();
            if($(".star").val() == "") {
                alert("Rating is missing");
                return ;
            } else {
                $(".rating-form").submit();
            }
        });
        $("input[type=radio]").on("change",function(event){
            event.preventDefault();
            var url = "'.base_url.'addtocart";
            $.ajax({
                url:url,
                data:{id:$(this).data("id"),action:"filter",type:$(this).data("type"),val:$(this).val()},
                type:"post",
                success:function(result){
                    console.log("success");
                },
                error:function(error){
                  console.log("Error occured");
                }
            });
        });
    });
</script>'; 
require_once('footer.php');?>