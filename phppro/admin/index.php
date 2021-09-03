<?php 
session_start();
require('query.php');
if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
  header("location:".admin_path.'dashboard');
} 
if(isset($_POST['username'])) {
  $where = ' username = "'.strip_tags(trim($_POST['username'])).'" and password = "'.md5(strip_tags(trim($_POST['password']))).'"';
  $data = $QueryFire->getAllData('admins',$where);
  if(!empty($data[0])) {
    $_SESSION['admin'] = $data[0];
    if($data[0]['user_type'] == 'admin') {
      header("location:".admin_path.'dashboard');
    } else {
      header("location:".admin_path.'');
    }
  } else {
    $error = "<h5 class='text-danger text-center'>Invalid username or password</h5>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | <?= admin?></title>
  <link rel="shortcut icon" href="<?= image_path?>favicon-icon/favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <img class="img-fluid d-block m-auto" style="max-height: 125px;" src="<?= image_path?>logo.png">
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in</p>
        <?= isset($error)?$error:''?>
        <form action="" method="post" class="login-form">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control password" name="password" placeholder="Password">
            <div class="input-group-append">
              <button class="btn border border-gray view-password" type="button"><i class="far fa-eye"></i></button>
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="<?= admin_path?>forgot-password">I forgot my password</a>
        </p>

      </div>
    </div>
  </div>
  <script src="<?= base_url?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url?>dist/js/adminlte.min.js"></script>
  <script src="<?= base_url?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url?>plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript">
    $(function(){
      $(document).on("click",".view-password",function(event){
        event.preventDefault();
        $(".password").attr("type","text");
        $(this).addClass("hide-password").removeClass("view-password").html('<i class="far fa-eye-slash"></i>');
      });
      $(document).on("click",".hide-password",function(event){
        event.preventDefault();
        $(".password").attr("type","password");
        $(this).removeClass("hide-password").addClass("view-password").html('<i class="far fa-eye"></i>');
      });
      jQuery(".login-form").validate({
        rules: {
          username: "required",
          password: "required",
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
    });
  </script>
</body>
</html>
