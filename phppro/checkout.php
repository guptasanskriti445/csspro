<?php
$active_tab = 'checkout';
require_once('header.php');
require_once('menu.php');
if(!isset($_SESSION['user'])) {
    if(isset($_REQUEST['slug'])) {
        echo "<script>window.location.href='".base_url."login?url=".urlencode(base_url.'buy/'.$_REQUEST['slug'])."'</script>";
    } else {
        echo "<script>window.location.href='".base_url."login?url=".urlencode(base_url.'checkout')."'</script>";
    }
}
if(isset($_SESSION['cartitems']) && !empty($_SESSION['cartitems'])) {
    $p_ids = array_keys($_SESSION['cartitems']);
    $products = $QueryFire->getAllData('products','qty > 0 and id in ('.implode(',',$p_ids).')'); 
} else if(isset($_REQUEST['slug'])) {
    $products = $QueryFire->getAllData('products','qty > 0 and slug="'.$_REQUEST['slug'].'"');
    $pr_id = $products[0]['id'];
    if(isset($_SESSION['cartitems'])) {
		if (!array_key_exists($pr_id,$_SESSION['cartitems'])) {
			$_SESSION['cartitems'][$pr_id]['id'] = $pr_id;
			$_SESSION['cartitems'][$pr_id]['quantity'] = 1;
			$added=true;
		}
	} else {
		$_SESSION['cartitems'][$pr_id]['id'] = $pr_id;
		$_SESSION['cartitems'][$pr_id]['quantity'] = 1;
		$added=true;
	}
} else {
    echo "<script>window.location.href='".base_url."'</script>";
}
if(isset($_POST['method'])) {
    if($_POST['method'] == 'online') {
        $new_address = array('name'=>strip_tags($_POST['name']),'mobile_no'=>strip_tags($_POST['mobile_no']),'address'=>strip_tags($_POST['address']));
        //         $new_address = array('name'=>strip_tags($_POST['name']),'user_id'=>$_SESSION['user']['id'],'mobile_no'=>strip_tags($_POST['mobile_no']),'address'=>strip_tags($_POST['address']),'pincode'=>strip_tags($_POST['pincode']),'state'=>strip_tags($_POST['state']),'city'=>strip_tags($_POST['city-town']),'street'=>'');
        // $addresses = $QueryFire->getAllData('user_addresses', ' is_deleted=0 and user_id='.$_SESSION['user']['id']);
    }
    $address = $_POST['address'] = $_POST['name'].'<br>'.$_POST['address'].'-'.$_POST['pincode'].'<br>'.$_POST['mobile_no'];
    $_POST['address'] = htmlentities($_POST['address']);
    $order = array('user_id'=>$_SESSION['user']['id'],'address'=>$_POST['address'], 'method' =>strip_tags($_POST['method']), 'total_price' =>strip_tags($_POST['total_price'])
    , 'discount' =>strip_tags($_POST['discount']));
    // pr($order);
    if($QueryFire->insertData('orders',$order)) {
         $$order = array('yes');
        $order_id = $QueryFire->getLastInsertId();
        if(!empty($products)) {
            $inventry = $QueryFire->getAllData('','','SELECT ppv.param_value as param_meter,php.name as param, p.* FROM products as p JOIN product_params_values as ppv ON ppv.id=p.param_value_id JOIN product_has_params as php ON php.id=ppv.param_id WHERE p.id in ('.implode(',',array_column($products,'id')).')');
            foreach($products as $key=>$product) {
                $products[$key]['params'] = array_values(array_filter($inventry,function($a) use($product) {
                    return $product['id']==$a['product_id'];
                }));
            }
        }
        /*$order_id = $QueryFire->getLastInsertId();
        $order_products = array('order_id'=>$order_id,'products' => $products);
        $items = array_values(array_map(function($a) use($order_products) {
            $key = array_search($a['id'], array_column($order_products['products'], 'id'));
            return array('order_id'=>$order_products['order_id'],'param_value_id'=> implode(',',array_values($a['filter'])),'product_id'=>$a['id'],'qty'=>$a['quantity'],'price'=>$order_products['products'][$key]['price'],'discount'=>$order_products['products'][$key]['discount']);
        }, $_SESSION['cartitems']));
        unset($_SESSION['cartitems']);
        $QueryFire->insertBatchData('order_has_products',$items);*/
        $msg ="Thank you for ordering with us. Your order status will be updated soon as order has been shipped.";
        $total = 0;
        $cat = array();
        $prrr = "<table class='order_stat'><tr> <td colspan='6' style='text-align: center;'> <h3> Item Details </h3></td></tr><tr><th> Image</th><th>Item Name</th><th>Quantity</th><th>Price</th><th>Discount(%)</th><th>Sub Total</th></tr>";
        foreach($products as $key=>$value) {
            $cat['order_id'] = $order_id;
            $cat['qty'] = $_SESSION['cartitems'][$value['id']]['quantity'];
            $cat['product_id'] = $value['id'];
            $oqty = 0;
            $value['price'] = $cat['price'] = $value['price'];
            $price = $value['price']-($value['discount']*$value['price']/100);
            $value['discount'] = $cat['discount'] = $value['discount'];
            $cat['param_value_id'] = $value['param_value_id'];
            //now insert into table
            $QueryFire->insertData('order_has_products',$cat);
            $total+=($price*$_SESSION['cartitems'][$value['id']]['quantity']);
            $prrr .='<tr>
                        <td>
                            <a href="'.base_url.'product/'.$value['slug'].'" target="_blank" >
                                <img src="'.base_url.'images/products/'.$value['image_name'].'" alt="'.ucwords($value['name']).'" title="'.ucwords($value['name']).'" width="110" heigh="90"  class="img-thumbnail" >
                            </a>
                        </td>
                        <td>'.ucwords($value['name']).'</td>
                        <td>'.$_SESSION['cartitems'][$value['id']]['quantity'].'</td>
                        <td>&#8377; '.$value['price'].'</td>
                        <td>'.$value['discount'].'</td>
                        <td>&#8377; '.($_SESSION['cartitems'][$value['id']]['quantity']*$price).'</td>
                    </tr>';
        }
        $delivery = 0;
        $prrr .="
                <tr>
                    <th colspan='5' style='text-align:right;'>Delivery Charge :</th>
                    <td><b>&#8377; ".$delivery."</b></td>
                </tr>
                <tr>
                    <th colspan='5' style='text-align:right;'>Coupon Discount :</th>
                    <td><b>&#8377; ".($total*$_SESSION['coupon_code']/100)."</b></td>
                </tr>
                <tr>
                    <th colspan='5' style='text-align:right;'>Grand Total :</th>
                    <td><b>&#8377; ".$total."</b></td>
                </tr>
            </table>";
        //$to = "info@sakshijewels.com";
        $to="lathe.nilesh@gmail.com";
        $subject = ' New Order Request FROM '.$_SESSION['user']['name'];
        $htmlContent ="
        <html>
            <head>
                <title>Order Details</title>
                <style>
                    tr,td,th{
                        border:1px solid gray;
                        padding:10px;
                    }
                    th{
                        text-align:right;
                    }
                    td{
                        text-align:center;
                    }
                </style>
            </head>
            <body>
                <div width='100%' style='text-align:center;'>
                    <img src='".base_url."images/logo.png' style='margin:auto;text-align:center;margin-bottom:5px;width:200px;' /> 
                </div>
                <h3> Order Details </h3>
                <p>Shipping Details:<br>
                    <address>".$address."</address>
                </p>
                    ".$prrr."
            </body>
        </html>";
        // Set content-type header for sending HTML email
        $headers= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // Additional headers
        $headers .= 'From: '.$_SESSION['user']['name'].'<'.trim($_SESSION['user']['email']).'>' . "\r\n";
        $headers .= 'Bcc: nilesh@akshadainfosystem.com' . "\r\n";
        mail($to,$subject,$htmlContent ,$headers);
        //auto responder
        $to = $_SESSION['user']['email'];
        $subject = 'Order Details';
        // Set content-type header for sending HTML email
        $headers= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // Additional headers
        $headers .= 'From: Customer Support <info@sakshijewels.com>' . "\r\n";
        //send invoice through mail
        //add payment link to it
        //$prrr .= '<p style="margin-top:20px;font-size:16px;">If you have not paid amount then <a href="'.base_url.'razorpay/pay/'.$cat['order_id'].'">click here</a> to pay.</p>';
        $template = file_get_contents('invoice.php');
        $template = str_replace('%username%', $_SESSION['user']['name'], $template);
        $template = str_replace('%data%', $prrr, $template);
        $template = str_replace('%shippingaddr%', $address, $template);
        mail($to,$subject,$template ,$headers);
        unset($_SESSION['cartitems']);
        unset($_SESSION['coupon_code']);
        if($_POST['method'] =='online'){
            echo "<script> alert('Order placed successfully');window.location.href='".base_url.'pay/order/'.$order_id."';</script>";
    } else {
        $error = 'Please select deliverable address';
    }
        unset($_POST['method']);
    }
}

?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <h2>checkout</h2>
            <ul>
                <li><a href="<?= base_url ?>">Home</a></li>
                <li class="active">checkout</li>
            </ul>
        </div>
    </div>
</div>
      
<section id="checkout" class="shop shop-cart checkout pt-30">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="" method="post" action="">
                    <?php if(!isset($msg)) { ?>
                            
                            <div class="cart-page-total">
                                <div class="row">
                                    <!-- .col-lg-12 end -->
                                     <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                        <h4>Shipping Address</h4>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="first-name"> NAME</label>
                                            <input type="text" class="form-control" required value="<?= $_SESSION['user']['name']?>" name="name">
                                        </div>
                                    </div>
                                    <!-- .col-lg-12 end -->
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="address">ADDRESS</label>
                                            <input type="text" class="form-control" value="<?= $_SESSION['user']['address']?>" name="address">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="pincode">PINCODE</label>
                                            <input type="text" required value="" class="form-control" name="pincode">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">PHONE</label>
                                            <input type="text" required value="<?= $_SESSION['user']['mobile_no']?>" class="form-control" name="mobile_no">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="table-content table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
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
                                                        <td class="hiraola-product-thumbnail"><a href="javascript:void(0)"><img src="<?= base_url.'images/products/'.$value['image_name']?>" alt="Rica's Cart Thumbnail" style="width:8rem;"></a></td>
                                                        <td class="hiraola-product-name"><a href="<?= base_url.'product/'.$value['slug']?>"><?= $value['name']?></a></td>
                                                        <td class="hiraola-product-price"><span class="amount pro_price"><span class="fas fa-rupee-sign"><?= $value['price'] - ($value['price']*$value['discount']/100)?></span></td>
                                                        <td class=" product-quantity">
                                                            <div class="cart-plus-minus product-quantity-action quantity-selector  cart-plus-minus">
                                                                <!-- <input  type="text" class="input-qty1 cart-plus-minus-box qty "  value="<?=$_SESSION['cartitems'][$value['id']]['quantity']?>" max="<?= $value['qty']?>" data-max="<?= $value['qty']?>" min="1" data-min="1" data-id="<?= $value['id']?>" readonly=""> -->
                                                                <button type="button"  class=" cart-plus-minus-box show-number btn qty input-qty1" data-price="<?= $value['price']-($value['price']*$value['discount']/100)?>" max="<?= $value['qty']?>" data-max="<?= $value['qty']?>" min="1" data-min="1" data-id="<?= $value['id']?>" readonly="" ><?=$_SESSION['cartitems'][$value['id']]['quantity']?></button>
                                                            <!--    <button type="button" class="minus inc qtybutton " value="-"><i class="fa fa-angle-up"></i></button>-->
                                                            <!--    <button type="button" class="plus dec qtybutton" value="+"><i class="fa fa-angle-down"></i></button>-->
                                                            <!--</div>-->
                                                        </td>
                                                        <td class="product-subtotal cart-product-total"><span class="amount  sprice"><span class="fas fa-rupee-sign"><?= $ty= ($value['price']-($value['price']*$value['discount']/100))*$_SESSION['cartitems'][$value['id']]['quantity'];
                                                        $total += $ty; ?></span></td>
                                                        <input type="hidden" class="totalonly" value="<?=$ty?>">
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-5 ml-auto">
                                            <div class="cart-page-total">
                                                <h2>Cart totals</h2>
                                                <ul>
                                                    <li>Subtotal <span class="price"><span class="fas fa-rupee-sign"><?= $total?></span></li>
                                                    <li>Discount <span class=""><span class="fas fa-rupee-sign"><?php
                                                    echo $discount = isset($_SESSION['coupon_code'])? floor (($total * $_SESSION['coupon_code'] / 100)) :0 ;?></span></li>
                                                    <li>Total <span class="price"><span class="fas fa-rupee-sign"><?= $total - $discount?></span></li>
                                                    <input type="text" hidden name="discount" value="<?php
                                                    echo $discount = isset($_SESSION['coupon_code'])? floor (($total * $_SESSION['coupon_code'] / 100)) :0 ;
                                                    ?>"/>
                                                    <input type="text" hidden name="total_price" value="<?= $total - $discount?>"/>
                                                </ul>
                                                <fieldset class="mb-30">
                                                    <div class="input-radio">
                                                        <label class="label-radio">COD
                                                            <input type="radio" checked name="method" value="cod">
                                                            <span class="radio-indicator"></span>
                                                            <label class="label-radio">Online</label>
                                                            <input type="radio" name="method" value="online">
                                                        </label>
                                                    </div>
                                                </fieldset>
                                                <?php if(isset($added)) { unset($_SESSION['cartitems'][$pr_id]);}?>
                                                <button type="submit" class="btn btn-primary mb-3">PLACE ORDER</button>
                                            </div>
                                        </div>
                                    </div>
                    <?php } else {?>
                        <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 text-center mt-5 mb-5"><h4 class="text-center text-success">Order placed successfully. You will get update once order is dispatched.</h4></div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>    
    </div>
</section>
<?php require_once('footer.php'); ?>