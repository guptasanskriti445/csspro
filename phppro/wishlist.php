<?php
$active_tab="wishlist";
require_once("header.php");
require_once("menu.php");
if(isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
    $p_ids = array_keys($_SESSION['wishlist']);
    $products = $QueryFire->getAllData('products','qty > 0 and id in ('.implode(',',$p_ids).')');
  }
?>
    <!-- Begin Hiraola's Breadcrumb Area -->
    <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Wishlist</h2>
                    <ul>
                        <li><a href="<?= base_url ?>">Home</a></li>
                        <li class="active">Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
 <!--Begin Hiraola's Wishlist Area -->
 
 <div class="hiraola-wishlist_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <?php if(!empty($products)) {?> 
                        <!-- <form action="javascript:void(0)"> -->
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="hiraola-product_remove">remove</th>
                                            <th class="hiraola-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="hiraola-product-price">Unit Price</th>
                                            <th class="hiraola-product-stock-status">Stock Status</th>
                                            <th class="hiraola-cart_btn">add to cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($products as $key => $value) { ?>
                                            <tr>
                                                <td class="hiraola-product_remove"><a href="javascript:void(0)" data-id="<?= $value['id']?>" class="action-remove1"><i class="fa fa-trash"
                                                    title="Remove"></i></a></td>
                                                <td class="hiraola-product-thumbnail"><a href="javascript:void(0)"><img class="img-responsive " src="<?= base_url.'images/products/'.$value['image_name']?>" alt="Hiraola's Wishlist Thumbnail" style="width: 8rem; " ></a>
                                                </td>
                                                <td class="hiraola-product-name"><a href="<?= base_url.'product/'.$value['slug']?>"><?= $value['name']?></a></td>
                                                <td class="hiraola-product-price"><span class="amount">$<?= $value['price'] - ($value['price']*$value['discount']/100)?></span></td>
                                                <td class="hiraola-product-stock-status"><span class="in-stock"><a href="javascript:void(0)"><?= $product['qty']>0?'In Stock':'Out of Stock'?></a></span></td>
                                                <td class="hiraola-cart_btn"><a href="javascript:void(0)" data-id="<?= $value['id']?>" class="btn-cart">add to cart</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <!-- </form> -->
                    <?php } else{ ?>
                         <h4 class="text-center text-info">Your wishlist is empty. To continue shopping <a href="<?= base_url?>products">click here</a>.</h4>
                    <?php } ?>    
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Wishlist Area End Here -->
        <?php require_once('footer.php');?>