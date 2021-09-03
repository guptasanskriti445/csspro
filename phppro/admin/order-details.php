<?php
session_start();
$jscss='both';
if(!empty($_POST['order_id'])) {
  require_once("query.php");
  $products = $QueryFire->getAllData('','','SELECT ohp.qty as quantity,ohp.param_value_id, ohp.discount,ohp.price,p.id,p.slug,p.name FROM order_has_products as ohp JOIN products as p ON p.id=ohp.product_id WHERE ohp.order_id='.$_POST['order_id']);
  $order = $QueryFire->getAllData('orders',' id= "'.$_POST['order_id'].'"')[0];
  $user = $QueryFire->getAllData('users',' id= "'.$order['user_id'].'"')[0];
  $address = array('address'=>$user['address'],'pincode'=>$user['pincode'],'name'=>$user['name'],'mobile_no'=>$user['mobile_no'],'street'=>'','city'=>'','state'=>'');
  if($order['address_id'] != 0) {
    $address = $QueryFire->getAllData('user_addresses',' id= "'.$order['address_id'].'"')[0];
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
  <div class="card">
    <div class="card-header">
      <strong>Order Details- #<?php echo $order['id'];?></strong> 
    </div>
    <div class="card-body card-block">
      <h4 class="text-center"><strong>Customer Details</strong></h4>
      <div class="row mt-3">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class="label">Customer Name</label>
            <input type="text" class="form-control" readonly name="name" value="<?php echo trim($address['name']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Customer Mobile</label>
            <input type="text"  class="form-control" readonly name="customer_mobile" value="<?php echo trim($address['mobile_no']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Customer Address</label>
            <input type="text"  class="form-control" readonly name="customer_address" value="<?php echo trim($address['address']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">City</label>
            <input type="text"  class="form-control" readonly name="customer_address" value="<?php echo trim($address['state']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Street</label>
            <input type="text"  class="form-control" readonly name="street" value="<?php echo trim($address['street']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">State</label>
            <input type="text"  class="form-control" readonly name="customer_address" value="<?php echo trim($address['state']);?>">
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label class=" form-control-label">Pincode</label>
            <input type="text"  class="form-control" readonly name="pincode" value="<?php echo trim($address['pincode']);?>">
          </div>
        </div>
      </div>
      <h4 class="text-center"><strong>Products</strong></h4><br>
      <div class="table-responsive">
        <table class="datatable-1 datatable  table table-hover table-condensed table-bordered table-product dt-responsive nowrap" style="overflow: auto;">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Qty</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $grandTotal=0;
            foreach($products as $product) { ?>
                <tr>
                  <td>
                    <?php echo ucwords($product['name']) ?>
                    <?php if(!empty($filters)) { ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach($filters as $key=> $filter) {
                                $pval = explode(',', $product['param_value_id']);
                                $is_present = false;
                                foreach($pval as $pv) {
                                    if(in_array($pv, array_column($filter, 'id'))) {
                                        $is_present = true;
                                        break;
                                    }
                                }
                                if($is_present === true) {
                                    echo '<li><span>'.ucwords($key).':</span>';
                                    foreach ($filter as $fil) {
                                      if(in_array($fil['id'], $pval)) {
                                        echo '<span class="filter-param" > '.$fil['param_value'].'</span>';
                                      }
                                    }
                                    echo "</li>";
                                }
                            } ?>
                        </ul>
                    <?php } ?>
                  </td>
                  <td>
                    <?php echo $product['quantity'];?>
                  </td>
                  <td><?php echo $product['price'];?></td>
                  <td><?php echo $product['discount'];?></td>
                  <td><?php echo $subtotal = ($product['quantity'] * ( $product['price'] - ($product['price']*$product['discount']/100)) ) ;$grandTotal+= $subtotal;?> </td>
                </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-right"><strong>Grand Total : </strong></td>
              <td><?php echo $grandTotal;?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="form-group">
        <button class="btn btn-primary dev-btn-back">Back</button>
      </div>
    </div>
  </div>
<?php } ?>