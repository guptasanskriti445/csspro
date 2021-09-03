<?php
$active_tab="product";
require_once("header.php");
require_once("menu.php");
$slug = '';
$breadcrumb = array();
$where = " is_show=1 and is_deleted=0 and qty>0 ";
$order_by = ' order by name asc';

if(isset($_REQUEST['cslug2'])) {
  $cat_details = $allcategories[array_search($_REQUEST['cslug'], array_column($allcategories, 'slug'))];
  $level1cat = $allcategories[array_search($_REQUEST['cslug2'], array_column($allcategories, 'slug'))];
  $slug = $cat_details['slug'];
  $where .= ' and cat_id ='.$level1cat['id'];
  $breadcrumb[1] = array('url'=> base_url.'products','name'=>'products');
  $breadcrumb[2] = array('url'=> base_url.'category/'.$_REQUEST['cslug'],'name'=>$cat_details['name']);
  $breadcrumb[3] = array('url'=> base_url.'category/'.$_REQUEST['cslug'].'/'.$_REQUEST['cslug2'],'name'=>$level1cat['name']);
} else if(isset($_REQUEST['cslug'])) {
  $slug = $_REQUEST['cslug'];
  $cat_details = $categories[array_search($_REQUEST['cslug'], array_column($categories, 'slug'))];
  if(!empty($cat_details['subcategory'])) {
    $where .= ' and cat_id in ('.implode(',', array_column($cat_details['subcategory'], 'id')).')';
  } else {
    $where .= ' and cat_id='.$cat_details['id'];
  }
  $breadcrumb[1] = array('url'=> base_url.'category/'.$_REQUEST['cslug'],'name'=>$cat_details['name']);
} else {
  $breadcrumb[1] = array('url'=> base_url.'products','name'=>'Products');
}
$startPage = 1;
if(isset($_REQUEST['page'])) {
  $startPage = $_REQUEST['page'];
  $cwhere = $where;
  $where = $where.$order_by.' limit '.(($startPage-1)*10).',9 ';
} else {
  $cwhere = $where;
  $where = $where.$order_by.' limit '.($startPage-1).',9';
}
$products = $QueryFire->getAllData('products',$where);
$prouduct_count = $count = $QueryFire->getAllCount('products WHERE '.$cwhere);
$brands = $QueryFire->getAllData('brands',1);
$count = ceil($count/10);
$filters = $params = array();
if(!empty($products)) {
    $filters = array_values(array_unique(array_column($products, 'param_value_id')));
    $params = $QueryFire->getAllData('','',"SELECT pv.*,php.name FROM product_params_values as pv LEFT JOIN product_has_params as php ON php.id=pv.param_id WHERE pv.id in (".implode(',', $filters).")");
    $filters = array();
    foreach($params as $param) {
        $filters[strtolower($param['name'])][]= $param;
    }
}
?>
   <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Shop</h2>
                    <ul>
                        <li><a href="<?= base_url ?>">Home</a></li>
                        <li class="active">Shop </li>
                        <?php
                            $count1 = count($breadcrumb);
                            for($i=1;$i<=$count1;$i++) {
                                if($i === $count1)
                                    echo '<li class="active"><span>'.ucwords(strtolower($breadcrumb[$i]['name'])).'</span></li>';
                                else
                                    echo '<li><a href="'.$breadcrumb[$i]['url'].'">'.ucwords(strtolower($breadcrumb[$i]['name'])).'</a></li>';
                            } 
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hiraola-content_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        <div class="hiraola-sidebar-catagories_area">
                            <?php if(!empty($brands)) { ?>
                                <div class="hiraola-sidebar_categories">
                                    <div class="hiraola-categories_title">
                                        <h5>Brand</h5>
                                    </div>
                                    <ul class="sidebar-checkbox_list">
                                        <?php foreach($brands as $brand) { ?>
                                        <li>
                                            <a href="javascript:void(0)"><?= ucwords($brand['name'])?>(15)</a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            <?php } ?> 
                            <!-- <div class="hiraola-sidebar_categories">
                                <div class="hiraola-categories_title">
                                    <h5>Size</h5>
                                </div>
                                <ul class="sidebar-checkbox_list">
                                    <li>
                                        <a href="javascript:void(0)">Size 1(17)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Size 2(16)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Size 3(17)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Size 4(17)</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="hiraola-sidebar_categories">
                                <div class="hiraola-categories_title">
                                    <h5>Weight</h5>
                                </div>
                                <ul class="sidebar-checkbox_list">
                                    <li>
                                        <a href="javascript:void(0)">Weight 1(16)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Weight 2(17)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Weight 3(17)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Weight 4(17)</a>
                                    </li>
                                </ul>
                            </div> -->
                            <?php if(!empty($categories)) { ?>
                                <div class="category-module hiraola-sidebar_categories">
                                    <div class="category-module_heading">
                                        <h5>Categories</h5>
                                    </div>
                                    <div class="module-body">
                                        <ul class="module-list_item">
                                            <?php foreach($categories as $bcat) { ?>
                                                <li <?= $slug==$bcat['slug']?'class="active"':'' ?>>
                                                    <a href="<?= base_url.'category/'.$bcat['slug']?>"><?= $bcat['name']?>(18)</a>
                                                    <?php if(!empty($bcat['subcategory'])) {?>
                                                        <ul class="module-sub-list_item">
                                                            <li>
                                                                <?php foreach($bcat['subcategory'] as $scat) { ?>
                                                                    <a href="<?= base_url.'category/'.$bcat['slug'].'/'.$scat['slug']?>"><?= $scat['name']?>(18)</a>
                                                                <?php } ?>    
                                                            </li>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>    
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="shop-toolbar">
                            <div class="product-view-mode">
                                <a class="active grid-3" data-target="gridview-3" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="fa fa-th"></i></a>
                                <a class="list" data-target="listview" data-toggle="tooltip" data-placement="top" title="List View"><i class="fa fa-th-list"></i></a>
                            </div>
                            <div class="product-item-selection_area">
                                <div class="product-short">
                                    <label class="select-label">Short By:</label>
                                    <select class="nice-select">
                                        <option value="1">Relevance</option>
                                        <option value="2">Name, A to Z</option>
                                        <option value="3">Name, Z to A</option>
                                        <option value="4">Price, low to high</option>
                                        <option value="5">Price, high to low</option>
                                        <option value="5">Rating (Highest)</option>
                                        <option value="5">Rating (Lowest)</option>
                                        <!-- <option value="5">Model (A - Z)</option>
                                        <option value="5">Model (Z - A)</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="shop-product-wrap grid gridview-3 row">
                            <?php if(!empty($products)) {
                            foreach($products as $product) { ?>
                                <div class="col-lg-4">
                                    <div class="slide-item">
                                        <div class="single_product">
                                            <div class="product-img">
                                                <a href="<?= base_url.'product/'.$product['slug']?>">
                                                    <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                    <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                </a>
                                                <div class="add-actions">
                                                    <ul>
                                                        <li><a  href="javascript:void(0)"  data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart" class="hiraola-add_cart btn-cart"><i class="ion-bag"></i></a>
                                                        </li>
                                                        <!-- <li><a class="hiraola-add_compare" href="compare.php" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i
                                                                class="ion-ios-shuffle-strong"></i></a>
                                                        </li>
                                                        <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)"  data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Quick View"><i
                                                                class="ion-eye"></i></a></li> -->
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
                                                            <li><a  href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist" class="hiraola-add_compare btn-wishlist"><i
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
                                                            <li class="silver-color"><i class="fa fa-star-of-david"></i></li>
                                                        </ul>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-slide_item">
                                        <div class="single_product">
                                            <div class="product-img">
                                                <a href="<?= base_url.'product/'.$product['slug']?>">
                                                    <img class="primary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                    <img class="secondary-img" src="<?= base_url.'images/products/'.$product['image_name']?>" alt="<?= $product['name']?>">
                                                </a>
                                            </div>
                                            <div class="hiraola-product_content">
                                                <div class="product-desc_info">
                                                    <h6><a class="product-name" href="<?= base_url.'product/'.$product['slug']?>"><?= $product['name']?></a></h6>
                                                    <div class="rating-box">
                                                        <ul>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li><i class="fa fa-star-of-david"></i></li>
                                                            <li class="silver-color"><i class="fa fa-star-of-david"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="price-box">
                                                        <span class="new-price"><span class="fas fa-rupee-sign"><?= $product['price'] - ($product['price']*$product['discount']/100)?></span>
                                                    </div>
                                                    <div class="product-short_desc">
                                                        <p><?= $product['details']?></p>
                                                    </div>
                                                </div>
                                                <div class="add-actions">
                                                    <ul>
                                                        <li><a  href="javascript:void(0)"  data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart" class="hiraola-add_cart btn-cart">Add To Cart</a></li>
                                                        <li><a class="hiraola-add_compare" href="compare.php" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i
                                                                class="ion-ios-shuffle-strong"></i></a></li>
                                                        <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i
                                                                class="ion-eye"></i></a></li>
                                                        <li><a href="javascript:void(0)" data-id="<?= $product['id']?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"  class="hiraola-add_compare btn-wishlist"><i
                                                                class="ion-android-favorite-outline"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } 
                            } else { ?>
                                <div class="col-sm-12 col-md-12 col-xs-12 text--center text-danger">
                                    <h3 class="text-danger text-danger">No product found.</h3>
                                </div> 
                            <?php } ?>    
                        </div>
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="hiraola-paginatoin-area">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <ul class="hiraola-pagination-box">
                                                <li class="active"><a href="javascript:void(0)">1</a></li>
                                                <li><a href="javascript:void(0)">2</a></li>
                                                <li><a href="javascript:void(0)">3</a></li>
                                                <li><a class="Next" href="javascript:void(0)"><i
                                                        class="ion-ios-arrow-right"></i></a></li>
                                                <li><a class="Next" href="javascript:void(0)">>|</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="product-select-box">
                                                <div class="product-short">
                                                    <p>Showing 1 to 12 of 18 (2 Pages)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Content Wrapper Area End Here -->
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
});
</script>';
require_once('footer.php');?>