<?php
$active_tab="cart";
require_once("header.php");
require_once("menu.php");
if(isset($_SESSION['cartitems']) && !empty($_SESSION['cartitems'])) {
    $p_ids = array_keys($_SESSION['cartitems']);
    $products = $QueryFire->getAllData('products','qty > 0 and id in ('.implode(',',$p_ids).')');
} else {
    $products = array();
}
if(isset($_POST['user_pincode']) && !empty($_POST['user_pincode']) && $_POST['user_pincode'] !== true ) {
    if(is_numeric($_POST['user_pincode'])) {
        $pin = $QueryFire->getAllData('pincodes',' is_show=1 and pincode="'.$_POST['user_pincode'].'"');
        if(!empty($pin)) {
            $_SESSION['user_pincode'] = $pin[0]['pincode'];
            $msg='<h5 class="text-success">Items deliver on this '.$_POST['user_pincode'].' pincode.</h5>';
        } else {
            $msg='<h5 class="text-danger">Items can not be delivered on '.$_POST['user_pincode'].'.</h5>';
        }
    } else{
        $msg='<h5 class="text-danger">Invalid pincode value</h5>';
    }
}
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
    <!-- Begin Hiraola's Breadcrumb Area -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Cart</h2>
                    <ul>
                        <li><a href="<?= base_url ?>">Home</a></li>
                        <li class="active">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
        <!-- Begin Hiraola's Cart Area -->
        <div class="hiraola-cart-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <?php if(!empty($products)) {?> 
                        <form action="javascript:void(0)">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="hiraola-product-remove">remove</th>
                                            <th class="hiraola-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="hiraola-product-price">Unit Price</th>
                                            <th class="hiraola-product-quantity">Quantity</th>
                                            <th class="hiraola-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total=0;
                                        foreach($products as $key=>$value) { ?>
                                            <tr class="cart-product">
                                                <td class="hiraola-product-remove"><a  href="javascript:void(0)" data-id="<?= $value['id']?>" class="action-remove"><i class="fa fa-trash"
                                                    title="Remove"></i></a></td>
                                                <td class="hiraola-product-thumbnail"><a href="javascript:void(0)"><img src="<?= base_url.'images/products/'.$value['image_name']?>" alt="Hiraola's Cart Thumbnail" style="width:5rem;"></a></td>
                                                <td class="hiraola-product-name"><a href="<?= base_url.'product/'.$value['slug']?>"><?= $value['name']?></a></td>
                                                <td class="hiraola-product-price"><span class="amount pro_price"><span class="fas fa-rupee-sign"><?= $value['price'] - ($value['price']*$value['discount']/100)?></span></td>
                                                
                                                <td class="product-quantity quantity">
                                                  <label>Quantity</label>
                                                <div class=" product-quantity-action quantity-selector cart-plus-minus">
                                                <button type="text" class="show-number btn qty input-qty1  cart-plus-minus-box" data-price="<?= $value['price']-($value['price']*$value['discount']/100)?>" max="<?= $value['qty']?>" data-max="<?= $value['qty']?>" min="1" data-min="1" data-id="<?= $value['id']?>" readonly="" ><?=$_SESSION['cartitems'][$value['id']]['quantity']?></button>
                                                <button type="button" class="prev minus dec qtybutton" value="-"><i class="fa fa-angle-down"></i></button>
                                                <button type="button" class="next plus qtybutton inc" value="+"><i class="fa fa-angle-up"></i></button>
                                                
                                            </div>
                                            </td>
                                                <td class="product-subtotal cart-product-total"><span class="amount  sprice"><span class="fas fa-rupee-sign"><?= $ty= ($value['price']-($value['price']*$value['discount']/100))*$_SESSION['cartitems'][$value['id']]['quantity'];
                                                 $total += $ty; ?></span></td>
                                                 <input type="hidden" class="totalonly" value="<?=$ty?>">
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-product-action">
                                <div class="row">
                                    <div class="col-md-5 ml-auto">
                                        <div class="cart-page-total">
                                            <h2>Cart totals</h2>
                                            <ul>
                                                <li>Subtotal <span class="sub--total"><span class="fas fa-rupee-sign"><?= $total?></span></li>
                                                <li>Discount<span data-discount="<?= !empty($_SESSION['coupon_code'])?$_SESSION['coupon_code']:0?>" class="discount"><?php
                                                echo $discount = isset($_SESSION['coupon_code'])? floor (($total * $_SESSION['coupon_code'] / 100)) :0 ;
                                                ?></span></li>
                                                <li>Total <span class="total"><span class="fas fa-rupee-sign"><?= $total?></span></li>
                                            </ul>
                                            <a href="<?= base_url?>checkout" class="btn-checkout">Proceed to checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } else{ ?>
                        <h4 class="text-center text-info">Your shopping cart is empty. To continue shopping <a href="<?= base_url?>products">click here</a>.</h4>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Cart Area End Here -->
<?php
$appendScript = '<script type="text/javascript">
$(function(event){
    $(".input-qty1").on("change",function(){
        console.log("hei");
      var total = 0;
      var newPrice = parseFloat($(this).data("price"))*$(this).text();
      console.log(newPrice);
      $(this).parents("tr").find(".cart-product-total .sprice").text(newPrice);
      $(this).parents("tr").find(".totalonly").val(newPrice);
      $(".totalonly").each(function(i,val){
      console.log(val);
          total+=parseFloat(val.value);
      });
      console.log(total)
      $(".sub--total").html(total);
      var discount = parseFloat($(".discount").data("discount"));
      if(discount>0) {
          discount = Math.floor(total*discount/100);
          $(".discount").html(discount);
      }
      console.log("discount"+discount)
      $(".total").html(total - discount);
    });
    $(".minus,.plus").on("click",function(event){
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
            $(This).val($(This).data("max"));
            return 0;
        }
    });
    /*$(".user_pincode").on("enter",function(event){
        event.preventDefault();
        if($(this).val().length == 6 ) {
            $(".validatepin").submit();
        }
    });*/
    $(".filter-param").on("click",function(event){
        event.preventDefault();
        var url = "<?=base_url?>addtocart";
        var This = $(this);
        $.ajax({
            url:url,
            data:{id:$(this).data("id"),action:"filter",type:$(this).data("type"),val:$(this).data("value")},
            type:"post",
            success:function(result){
                $(This).parent("li").find(".filter-param").removeClass("active");
                $(This).addClass("active");
                console.log("success");
            },
            error:function(error){
              console.log("Error occured");
            }
        });
    });
});
</script>';
 require_once('footer.php'); ?>
