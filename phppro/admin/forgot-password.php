<?php 
session_start();
require('../admin/query.php');
if(isset($_SESSION['student']) && !empty($_SESSION['student'])) {
  header("Location:".admin_path);
} 
if(isset($_POST['username'])) {
  $where = ' username = "'.strip_tags(trim($_POST['username'])).'"';
  $data = $QueryFire->getAllData('users',$where);
  if(!empty($data[0])) {
    if(!$data[0]['is_active']) {
      $error = "Your account is not active. Please contact admin/class";
    } else if(!$data[0]['is_verified']) {
      $error = "Your account is not verified. Please your account.<a href='".admin_path."verify'>verify me</a>";
    } else {
      $user_id = $data[0]['id'];
      $otp = rand(100000,999999);
      $error="We have sent OTP on your mobile no/email";
      //$res = $QueryFire->sendSms('Forgot Password','OTP is '.$otp.' for reset account password and is valid for 1 hr. For details '.base_url,$data[0]['mobile_no']);
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= 'From: Admin <lathe.nilesh@gmail.com>' . "\r\n";
      mail($data[0]['email'],'Forgot Password','OTP is '.$otp.' for reset account password',$headers);
      $QueryFire->upDateTable("users",$where,array('verification_otp'=> $otp));
    }
  } else {
    $error = "Invalid user id";
  }
}
if(isset($_POST['password'])) {
  if($_REQUEST['password'] == $_REQUEST['repassword']) {
    $user_id = $_POST['user'];
    $where = ' id='.$user_id.' and verification_otp ="'.$_REQUEST['otp'].'"';
    $data = $QueryFire->getAllData('users',$where);
    if(!empty($data)) {
      $QueryFire->upDateTable("users",$where,array('verification_otp'=>'','password'=>md5(trim(strip_tags($_REQUEST['password'])))));
      $msg="You have successfully changed your password.";
    } else {
      $error = 'Invalid OTP';
    }
  } else {
    $error = 'Password and confirm password does not match.';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Forgot Password | <?= admin ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= base_url?>images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="<?= base_url?>images/favicon.ico" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    .login-page{
      background: url('<?= base_url?>dist/img/boxed-bg.jpg');
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <?=isset($error)?'<h4 class="text-danger text-center">'.$error.'</h4>':''?>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img class="img-fluid d-block m-auto" style="max-height: 125px;" src="<?= image_path?>logo.png">
    </div>
    <div class="card-body login-card-body">
      <?php if(isset($msg)) {?>
        <p class="login-box-msg mt-4 bt-4 text-success"><?= $msg ?></p>
        <p class="text-center"><a href="<?= admin_path?>login" class="text-center">Return to login</a></p>
      <?php } else if(!isset($user_id)) { ?>
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
        <form action=""class="login-form" method="post" autocomplete="off">
          <div class="form-group">
            <div class="input-group">
              <input type="text" autocomplete="off" name="username" class="form-control" placeholder="Your ID/Username" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-6 ">
              <button type="submit" class="btn btn-primary btn-block">Request OTP</button>
            </div>
          </div>
        </form>
        <a href="<?= admin_path?>login" class="float-left mt-2">Login</a>
      <?php } else { ?>
        <p class="login-box-msg">Change Password</p>
        <form action=""class="changepasswd-form" method="post" autocomplete="off">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="otp" autocomplete="off" class="form-control" placeholder="Enter OTP ">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="user" value="<?= $user_id?>" />
          <div class="form-group">
            <div class="input-group">
              <input type="password" class="form-control" name="repassword" placeholder="Retype password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-6 ">
              <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
          </div>
        </form>
      <?php } ?>
    </div>
  </div>
</div>
<script src="<?= base_url?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url?>dist/js/adminlte.min.js"></script>
<script src="<?= base_url?>plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url?>plugins/jquery-validation/additional-methods.min.js"></script>
<script>
  $(document).ready(function() {
    <?php if(!isset($user_id)) { ?>
      jQuery(".login-form").validate({
        rules: {
          username: {
            required:true,
            /*number:true,*/
            minlength:10,
            maxlength:10
          }
        },
        messages: {
          username: {
            required:"Enter User ID",
            /*number:"Enter valid User ID",*/
            minlength:"Enter valid User ID",
            maxlength:"Enter valid User ID"
          }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
    <?php } else { ?>
      jQuery(".changepasswd-form").validate({
        rules: {
          password: {
            required:true,
            minlength:8,
            maxlength:20
          },
          otp: {
            required:true,
            number:true,
            minlength:6,
            maxlength:6
          },
          repassword : {
            equalTo : "#password"
          }
        },
        messages: {
          password: {
            required:"Enter Password",
            minlength:"Password must be more than 8 characters",
            maxlength:"Password must not be more than 20 characters",
          },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
    <?php } ?>
  });
</script>
</body>
</html>
