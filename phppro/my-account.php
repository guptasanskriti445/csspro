<?php
$active_tab="my account";
require_once("header.php");
require_once("menu.php");
//cancel order
if(isset($_POST['cancel_order'])) {
    //now get vendor details
    $od = $order_requests[array_search($_POST['id'], array_column($order_requests, 'id'))];
    unset($order_requests[array_search($_POST['id'], array_column($order_requests, 'id'))]);
    //now send mail to user who has serving this order
    $success = 'Order cancelled.';
    $subject = 'Order Cancellation';
    $htmlContent ="
    <html>
        <head>
            <title>Order Cancelled</title>
            <style>
                tr{
                border:1px solid gray;
                padding:5px;
                }
                th{
                text-align:right;
                }
            </style>
        </head>
        <body> <h2> Dear Vendor, </h2><br>".ucwords($_SESSION['user']['name'])." has cancelled order.<br>
            Order Details<br>
            <table>
                <tr> <td colspan='2'> <h3> Cancellation Details </h3></td></tr>
                <tr>
                    <th>Order No. : </th>
                    <td> #OP".$od['id']."</td>
                </tr>
                <tr>
                    <th>Product Name :</th>
                    <td>".$od['name']."</td>
                </tr>
                <tr>
                    <td colspan='2'> <img src='".base_url.'assets/images/products/'.$od['image_name']."' /> </td>
                </tr>
                <tr>
                    <th>Product Price :</th>
                    <td>".$od['price']." INR </td>
                </tr>
                <tr>
                    <th>Order Date :</th>
                    <td>".$od['date']."</td>
                </tr>
                <tr>
                    <th>Reason For Cancellation :</th>
                    <td>".trim($_POST['reason'])."</td>
                </tr>
            </table>
        </body>
    </html>";
    // Set content-type header for sending HTML email
    $headers= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // Additional headers
    $headers .= 'From: admin<lathe.nilesh@gmail.com>' . "\r\n";
    //mail($vd['b_email'],$subject,$htmlContent ,$headers);
    //auto responder to user about cancellation of order
    $htmlContent ="
    <html>
        <head>
            <title>Order Cancelled</title>
            <style>
                tr{
                border:1px solid gray;
                padding:5px;
                }
                th{
                text-align:right;
                }
            </style>
        </head>
        <body> <h2> Dear ".ucwords($_SESSION['user']['name'])." , </h2> Your order is cancelled as per your request.<br>
            Order Details<br>
            <table>
                <tr> <td colspan='2'> <h3> Cancellation Details </h3></td></tr>
                <tr>
                    <th>Order No. : </th>
                    <td> #OP".$od['id']."</td>
                </tr>
                <tr>
                    <th>Product Name :</th>
                    <td>".$od['name']."</td>
                </tr>
                <tr>
                    <td colspan='2'> <img src='".base_url.'assets/images/products/'.$od['image_name']."' /> </td>
                </tr>
                <tr>
                    <th>Product Price :</th>
                    <td>".$od['price']." INR </td>
                </tr>
                <tr>
                    <th>Order Date :</th>
                    <td>".$od['date']."</td>
                </tr>
                <tr>
                    <th>Reason For Cancellation :</th>
                    <td>".$_POST['reason']."</td>
                </tr>
            </table>
        </body>
    </html>";
    // Set content-type header for sending HTML email
    $headers= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // Additional headers
    $headers .= 'From: admin<lathe.nilesh@gmail.com>' . "\r\n";
    //mail($_SESSION['user']['email'],$subject,$htmlContent ,$headers);
    //update data into table
    if($QueryFire->upDateTable("orders",'id='.$od['id'],array('status'=>'cancelled')))
    {
        $success = "Order cancelled.";
    }
    else
    {
        $error = "System is busy. Try after some time.";
    }
}
//add new address
if(isset($_POST['add'])) {
  unset($_POST['add']);
  $_POST['user_id'] = $_SESSION['user']['id'];
  //check wheather mobile No exists or not
  $du= $QueryFire->getAllData('user_addresses',' mobile_no = "'.$_POST['mobile_no'].'" and user_id="'.$_SESSION['user']['id'].'"');
  if(empty($du)) {
    if($QueryFire->insertData('user_addresses',$_POST)) {
      $success = 'Address added successfully.';
      $subject = ' New Address Added ';
      $htmlContent ="
      <html>
          <head>
              <title>New Address Details</title>
              <style>
                  tr{
                  border:1px solid gray;
                  padding:5px;
                  }
                  th{
                  text-align:right;
                  }
              </style>
          </head>
          <body>
              <table>
                  <tr> <td colspan='2'> <h3> New Registration </h3></td></tr>
                  <tr>
                      <th>Name : </th>
                      <td>".$_POST['name']."</td>
                  </tr>
                  <tr>
                      <th>Mobile :</th>
                      <td>".$_POST['mobile_no']."</td>
                  </tr>
                  <tr>
                      <th>Address :</th>
                      <td>".$_POST['address'].', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['state'].' - '.$_POST['pincode']."</td>
                  </tr>
              </table>
          </body>
      </html>";
      // Set content-type header for sending HTML email
      $headers= "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      // Additional headers
      $headers .= 'From: admin<lathe.nilesh@gmail.com>' . "\r\n";
      //mail($_SESSION['user']['email'],$subject,$htmlContent ,$headers);
    }
    else {
      $error = " Unable to add new address at this moment.";
    }
  }
  else
  {
    $error = " Address already Exists. To change address details click to change icon.";
  }
}
//edit address
if(isset($_POST['actvtr'])) {
  unset($_POST['Edit']);
  unset($_POST['actvtr']);
  if($QueryFire->upDateTable('user_addresses','id='.$_POST['id'],$_POST))
  {
      $success = 'Address changed successfully.';
  }
  else
  {
      $error = " Unable to change address at this moment.";
  }
}
//Change Password
if(isset($_POST['change'])) {
  if($_POST['pass'] == $_POST['repass']) {
    //check wheather mobile No exists or not
    $du= $QueryFire->getAllData('users',' password = "'.md5(strip_tags($_POST['current'])).'" and id="'.$_SESSION['user']['id'].'"');
    if(!empty($du)) {
      if($QueryFire->upDateTable("users",'id='.$_SESSION['user']['id'],array('password'=>md5(strip_tags($_POST['pass']))))) {
        $success = 'Password changed successfully.';
        $subject = ' Password change';
        $htmlContent ="
        <html>
            <head>
                <title>Password change</title>
                <style>
                    tr{
                    border:1px solid gray;
                    padding:5px;
                    }
                    th{
                    text-align:right;
                    }
                </style>
            </head>
            <body> <h2> Hi ".ucwords($_SESSION['user']['name'])."</h2>
                Someone recently changed your password. If this is not you kindly mail the issue us on <a href='mailto:lathe.nilesh@gmail.com'> lathe.nilesh@gmail.com</a>.
            </body>
        </html>";
        // Set content-type header for sending HTML email
        $headers= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // Additional headers
        $headers .= 'From: admin<lathe.nilesh@gmail.com>' . "\r\n";
        //mail($_SESSION['user']['email'],$subject,$htmlContent ,$headers);
      } else {
        $error = " Unable to add new address at this moment.";
      }
    } else {
      $error = "Invalid Current Password";
    }
  } else {
    $error = "Password & Re-Enter Password mismatch.";
  }
}
//Update User Details
if(isset($_POST['update'])) {
  unset($_POST['update']);
  unset($_POST['email']);
  if($QueryFire->upDateTable("users",'id='.$_SESSION['user']['id'],$_POST)) {
      $_SESSION['user']['name'] = $_POST['name'];
      $_SESSION['user']['mobile_no'] = $_POST['mobile_no'];
      $_SESSION['user']['address'] = $_POST['address'];
      $_SESSION['user']['pincode'] = $_POST['pincode'];
      $success = 'Profile details changed successfully.';
      $subject = 'Profile details changed';
      $htmlContent ="
      <html>
          <head>
              <title>Details change</title>
              <style>
                  tr{
                  border:1px solid gray;
                  padding:5px;
                  }
                  th{
                  text-align:right;
                  }
              </style>
          </head>
          <body> <h2> Hi ".ucwords($_SESSION['user']['name'])."</h2>
              Someone recently changed your Details. If this is not you kindly mail the issue us on <a href='mailto:lathe.nilesh@gmail.com'> lathe.nilesh@gmail.com</a>.<br>
              Changed Details<br>
              <table>
                  <tr> <td colspan='2'> <h3> New Registration </h3></td></tr>
                  <tr>
                      <th>Name : </th>
                      <td>".$_POST['name']."</td>
                  </tr>
                  <tr>
                      <th>Mobile :</th>
                      <td>".$_POST['mobile_no']."</td>
                  </tr>
                  <tr>
                      <th>Address :</th>
                      <td>".$_POST['address']."</td>
                  </tr>
              </table>
          </body>
      </html>";
      // Set content-type header for sending HTML email
      $headers= "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      // Additional headers
      $headers .= 'From: admin<lathe.nilesh@gmail.com>' . "\r\n";
      //mail($_SESSION['user']['email'],$subject,$htmlContent ,$headers);
  } else {
    $error = " Unable to update details.";
  }
}
$orders = $QueryFire->getAllData('','',"SELECT o.id,o.date,o.delivery_charge, o.delivery_date,o.status,op.grand_total  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  WHERE user_id=".$_SESSION['user']['id']." ORDER BY o.id desc");
$addresses = $QueryFire->getAllData('user_addresses', ' is_deleted =0 and user_id='.$_SESSION['user']['id']);
?>
<style>
    .hide {
        display:none;
    }
</style>
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>My Account</h2>
                    <ul>
                        <li><a href="<?php base_url ?>">Home</a></li>
                        <li class="active">My Account</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
        <!-- Begin Hiraola's Page Content Area -->
        <main class="page-content">
            <!-- Begin Hiraola's Account Page Area -->
            <div class="account-page-area">
                <div class="dev-primary">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <ul class="nav myaccount-tab-trigger" id="account-page-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="account-dashboard-tab" data-toggle="tab" href="#account-dashboard" role="tab" aria-controls="account-dashboard" aria-selected="true">Change Password</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-orders-tab" data-toggle="tab" href="#account-orders" role="tab" aria-controls="account-orders" aria-selected="false">Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-address-tab" data-toggle="tab" href="#account-address" role="tab" aria-controls="account-address" aria-selected="false">Addresses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-details-tab" data-toggle="tab" href="#account-details" role="tab" aria-controls="account-details" aria-selected="false">Account Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-logout-tab" href="<?= base_url ?>logout" role="tab" aria-selected="false">Logout</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-9">
                                <div class="tab-content myaccount-tab-content" id="account-page-tab-content">
                                    <div class="tab-pane fade show active" id="account-dashboard" role="tabpanel" aria-labelledby="account-dashboard-tab">
                                        <div class="myaccount-details">
                                            <form method="post" action="" id="user" class="hiraola-form">
                                            <div class="hiraola-form-inner">
                                                <div class="single-input">
                                                            <label>Current Password<span>*</span></label>
                                                            <input type="password" name="current" placeholder="Current Password *" required>
                                                            </div>
                                                            <div class="single-input">
                                                            <label>New Password<span>*</span></label>
                                                            <input type="password" name="pass" placeholder="New Password *">
                                                            </div>
                                                            <div class="single-input">
                                                            <label>Re-Enter Password<span>*</span></label>
                                                            <input type="password" id="password1" name="repass" placeholder="Re-Enter Password *">
                                                            </div>
                                                            <div class="single-input">
                                                            <button class="hiraola-btn hiraola-btn_dark" type="submit" name="change" value="Change" >Change</button>
                                                            </div>
                                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-orders" role="tabpanel" aria-labelledby="account-orders-tab">
                                        <div class="myaccount-orders">
                                            <h4 class="small-title">MY ORDERS</h4>
                                            <div class="table-responsive">
                                                <?php if(!empty($orders)) { ?>
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th>ORDER</th>
                                                                <th>ORDER DATE</th>
                                                                <th>DELIVERY DATE</th>
                                                                <th>STATUS</th>
                                                                <th>TOTAL</th>
                                                                <th></th>
                                                            </tr>
                                                            <?php 
                                                                foreach($orders as $order) { ?>
                                                                <tr>
                                                                    <td><a class="account-order-id" href="javascript:void(0)"><?php echo $order['id'];?></a></td>
                                                                    <td><?php echo date('d-m-Y',strtotime($order['date']));?></td>
                                                                    <td><?php echo $order['delivery_date']?date('d-m-Y',strtotime($order['delivery_date'])):'-';?></td>
                                                                    <td>On Hold</td>
                                                                    <td><span class="fas fa-rupee-sign"></span><?php echo ($order['grand_total']+$order['delivery_charge']);?></td>
                                                                    <td>
                                                                        <!--<a href="my-order-details?order_id=<?php echo $order['id'];?>" class="hiraola-btn hiraola-btn_dark hiraola-btn_sm view-order-details"><span>View</span></a>-->
                                                                         <button class="btn btn-info btn-xs view-order-details" data-id="<?php echo $order['id'];?>"> View Details</button> 
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                <?php } else { ?>
                                                    <h5 class="text-info"> You have not made any order.</h5>
                                                <?php } ?>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-address" role="tabpanel" aria-labelledby="account-address-tab">
                                        <div class="myaccount-address">
                                            <p>The following addresses will be used on the checkout page by default.</p>
                                            <div class="row">
                                                <div class="col">
                                                <button class="btn btn-default" data-toggle="modal" data-target="#add"> Add New Address <i class="fa fa-chevron-right"></i></button>
                                                    <h4 class="small-title">BILLING ADDRESS</h4>
                                                    <address>
                                                      <?= ucwords($_SESSION['user']['address'])?>
                                                    </address>
                                                </div>
                                                <div class="col">
                                                    <!-- <h4 class="small-title">SHIPPING ADDRESS</h4>
                                                    <address>
                                                        1234 Heaven Stress, Beverly Hill OldYork UnitedState of Lorem
                                                    </address> -->
                                                    <?php if(!empty($addresses))
                                                    { echo '<h4 class="small-title">Other Address:</h4>';
                                                    foreach($addresses as $address){?>
                                                        <address>
                                                            <button class="btn-primary btn-sm edit_btn " data-id="<?= $address['id']?>"> Edit</button>
                                                            <button class="btn-danger btn-sm del_ad" data-id="<?= $address['id']?>" > Delete</button>
                                                            <i class="fa fa-map-marker"></i> 
                                                            <?= ucwords($address['name'].', '.$address['address'].', '.$address['street'].', '.$address['city'].' - '.$address['pincode'].', '.$address['state'].', Mobile No. '.$address['mobile_no']) ?>
                                                        </address>
                                                    <?php } } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-details" role="tabpanel" aria-labelledby="account-details-tab">
                                        <div class="myaccount-details">
                                            <form  method="post" action=""class="hiraola-form">
                                                <div class="hiraola-form-inner">
                                                    <!-- <div class="single-input single-input-half">
                                                        <label for="account-details-firstname">Name*</label>
                                                        <input type="text"  name="name" placeholder="Name" value="<?= $_SESSION['user']['name']?>">
                                                    </div> -->
                                                    <div class="single-input">
                                                        <label for="name">Name*</label>
                                                        <input type="text"  name="name" placeholder="Name" value="<?= $_SESSION['user']['name']?>">
                                                    </div>
                                                    <div class="single-input">
                                                        <label for="email">Email*</label>
                                                        <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['user']['email']?>" readonly>
                                                    </div>
                                                    <div class="single-input">
                                                        <label for="mobile_no">Mobile No. : </label>
                                                        <input type="tel" name="mobile_no" placeholder="Mobile No" value="<?= $_SESSION['user']['mobile_no']?>"  onkeypress="return isNumberKey(event);" >
                                                    </div>
                                                    <div class="single-input">
                                                        <label for="pincode">Pincode : </label>
                                                        <input type="tel" name="pincode" placeholder="Pincode" value="<?= $_SESSION['user']['pincode']?>"  onkeypress="return isNumberKey(event);" >
                                                    </div>
                                                    <div class="single-input">
                                                        <label for="address">Address : </label>
                                                        <textarea name="address"><?= $_SESSION['user']['address']?></textarea>
                                                    </div>
                                                    <div class="single-input">
                                                        <button class="hiraola-btn hiraola-btn_dark" type="submit" name="update" value="update"><span>SAVE
                                                        CHANGES</span></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dev-secondary hide"></div>
            </div>
        </main>
<div id="del_add" class="modal fade" role="dialog" style="margin-top: 6%;">
  <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Delete Address</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>Do you want to delete this address?</p>
          </div>
          <div class="modal-footer">
            <a href="#" class="yes_del"><button type="button" class="btn btn-danger" >Yes</button></a>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
    </form>
  </div>
</div>
<!-- Add New Address -->
<div id="add" class="modal fade" role="dialog" style="margin-top: 6%;">
  <div class="modal-dialog">
    <form method="post" action="" class="address_book">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Address </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="pincode" class="form-control"  onkeypress="return isNumberKey(event);"  placeholder="Pincode">
            </div>
            <div class="form-group">
                <input type="text" name="mobile_no" class="form-control" placeholder="Enter Mobile No"  onkeypress="return isNumberKey(event);"  >
            </div>
            <div class="form-group">
                <input type="text" name="address" class="form-control" placeholder="Enter Flat / House / Floor / Building ">
            </div>
            <div class="form-group">
                <input type="text" name="street" class="form-control" placeholder="Enter Street / Colony / Locality">
            </div>
            <div class="form-group">
                <input type="text" name="city" class="form-control" placeholder="Enter City">
            </div>
            <div class="form-group">
                <input type="text" name="state" class="form-control" placeholder="Enter State">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="add" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    </form>
  </div>
</div>
<!-- Edit Address -->
<div id="edit_add" class="modal fade" role="dialog" style="margin-top: 6%;">
  <div class="modal-dialog">
    <form method="post" action="" id="address_book1">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Address Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <input type="text" name="name" class="form-control a_name" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <input type="text" name="pincode" class="form-control a_pincode"  onkeypress="return isNumberKey(event);"  placeholder="Pincode">
            </div>
            <div class="form-group">
                <input type="text" name="mobile_no" class="form-control a_mobile_no" placeholder="Enter Mobile No"  onkeypress="return isNumberKey(event);"  >
            </div>
            <div class="form-group">
                <input type="text" name="address" class="form-control a_address" placeholder="Enter Flat / House / Floor / Building ">
            </div>
            <div class="form-group">
                <input type="text" name="street" class="form-control a_street" placeholder="Enter Street / Colony / Locality">
            </div>
            <div class="form-group">
                <input type="text" name="city" class="form-control a_city" placeholder="Enter City">
            </div>
            <div class="form-group">
                <input type="text" name="state" class="form-control a_state" placeholder="Enter State">
                <input type="hidden" name="id" class="form-control a_id">
                <input type="hidden" name="actvtr" value="act">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="Edit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    </form>
  </div>
</div>
<!-- Cancel Order -->
<div id="cancel_order" class="modal fade" role="dialog" style="margin-top: 6%;">
  <div class="modal-dialog">
    <form method="post" action="">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Cancel Order </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="reason"> Please let us know the reason for the cancellation of order : </label>
                <input type="text" name="reason" class="form-control" placeholder="Enter Reason to cancel this order E.g Placed by mistake, etc." required>
            </div>
            <input type="hidden" name="id" class="form-control c_id">
          </div>
          <div class="modal-footer">
            <button type="submit" name="cancel_order" class="btn btn-danger">Cancel Order</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    </form>
  </div>
</div>       
<?php require_once('footer.php');?>
<script type="text/javascript">
    $(function(){
        $(document).on('click','.cancel_order',function(){
          $('.c_id').val($(this).data('id'));
          $('#cancel_order').modal('show');
        });
        //this is for delete menu
        $(document).on('click','.del_ad',function(){
          $('.yes_del').attr('href','myajaxrequest/deletemyaddress/'+$(this).data('id'));
          $('#del_add').modal('show');
        });
        jQuery(document).on("click",".dev-btn-back",function(e){
          jQuery(".dev-primary").removeClass("hide");
          jQuery(".dev-secondary").addClass("hide").html("");
        });
        $(document).on('click','.edit_btn',function(){
            var id = $(this).data('id');
            $.ajax({
                url:'myajax',
                type:'post',
                data:{id:id,action:'useraddress'},
                success:function(result){
                    var r = $.parseJSON(result);
                    if(r.status)
                    {
                        $.each(r.data,function(i,val){
                            $('.a_address').val(val.address);
                            $('.a_name').val(val.name);
                            $('.a_city').val(val.city);
                            $('.a_mobile_no').val(val.mobile_no);
                            $('.a_pincode').val(val.pincode);
                            $('.a_street').val(val.street);
                            $('.a_state').val(val.state);
                            $('.a_id').val(val.id);
                        });
                    }
                    else
                    {
                        alert('Sorry! Unable to process. Please try after sometime.');
                    }
                },
                error:function(error){
                    alert('Something went wrong!');
                }
            })
          $('#edit_add').modal('show');
        });
        jQuery(document).on("click",".view-order-details",function(e){
          if(jQuery(this).data("id") != "") {
            jQuery.ajax({
              url : "my-order-details",
              type : "POST",
              data: {order_id:jQuery(this).data("id")},
              success : function(response) {
                if(response.trim() !="") {
                  jQuery(".dev-primary").addClass("hide");
                  jQuery(".dev-secondary").removeClass("hide").html(response);
                }
              }
            });
          }
      });
    });
</script>