<?php 
$active_tab='change password';
require_once('header.php');
require_once('menu.php');
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
  $orders = $QueryFire->getAllData('','',"SELECT o.id,o.date,o.delivery_charge, o.delivery_date,o.status,op.grand_total  FROM orders as o JOIN (select order_id, sum( (price*qty) - (price*qty*(discount/100)) ) as grand_total from order_has_products GROUP BY order_id ) as op ON op.order_id=o.id  WHERE user_id=".$_SESSION['user']['id']." ORDER BY o.id desc");
$addresses = $QueryFire->getAllData('user_addresses', ' is_deleted =0 and user_id='.$_SESSION['user']['id']);
?>
     <!-- Begin Hiraola's Breadcrumb Area -->
     <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Change Password</h2>
                    <ul>
                        <li><a href="<?php base_url ?>">Home</a></li>
                        <li class="active"> Change Password</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
        <!-- Begin Hiraola's Login Register Area -->
        <div class="hiraola-login-register_area">
            <div class="container">
                  <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mx-auto">
                        <!-- Login Form s-->
                        <form method="post" action="" id="user">
                            <div class="login-form" >
                                <h4 class="login-title">Change Password</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <label>Current Password</label>
                                        <input type="password" name="current" placeholder="Current Password" required>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <label>New Password</label>
                                        <input type="password" name="pass" placeholder="New Password ">
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <label>Re-Enter Password</label>
                                        <input type="password" id="password1" name="repass" placeholder="Re-Enter Password ">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="change" value="Change"  class="hiraola-login_btn">Change</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Login Register Area  End Here -->
<?php 
require_once('footer.php');
?>