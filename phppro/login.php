<?php
$active_tab="login";
require_once("header.php");
require_once("menu.php");
if(isset($_SESSION['user'])) {
    if(isset($_REQUEST['url']))
        echo "<script>window.location.href='".$_REQUEST['url']."';</script>";
    else
        echo "<script>window.location.href='".base_url."';</script>";
}
if(isset($_POST['login'])) {
    $data = $QueryFire->getAllData('users',' email="'.trim(strip_tags($_POST['email'])).'" and password ="'.md5(trim(strip_tags($_POST['password']))).'"');
    if(!empty($data[0])) {
        $data = $data[0];
        if($data['is_verified'] ==1) {
            $success = 'Logged in successfully.';
            $dummy = '';
            if(isset($_SESSION['cartitems'])) {
              $dummy = $_SESSION['cartitems'];
            }
            $_SESSION['user'] = $data;
            if(!empty($dummy)) {
                $_SESSION['cartitems']= $dummy;
            }
            if(isset($_REQUEST['url']))
                echo "<script>window.location.href='".urldecode($_REQUEST['url'])."';</script>";
            elseif(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
                echo '<script> window.location.href="'.$_SERVER['HTTP_REFERER'].'";</script>';
            else
                echo '<script> window.location.href="'.base_url.'";</script>';
        } else {
            $error=" You are not verified your email yet. Kindly check your mail/message and then click to verify.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

        <!-- Begin Hiraola's Breadcrumb Area -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Login</h2>
                    <ul>
                        <li><a href="<?php base_url ?>">Home</a></li>
                        <li class="active">Login</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
        <!-- Begin Hiraola's Login Register Area -->
        <div class="hiraola-login-register_area">
            <div class="container ">
            
            <div class="text-center"><h6><?= isset($error)?$error:''?></h6></div>
                <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mx-auto">
                        <!-- Login Form s-->
                        <form action="" method="post">
                            <div class="login-form" >
                                <h4 class="login-title">Login</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <label>Email Address*</label>
                                        <input type="email"  name="email" required placeholder="Email Address">
                                    </div>
                                    <div class="col-12 mb--20">
                                        <label>Password</label>
                                        <input type="password" name="password" required placeholder="Password">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="check-box">
                                            <input type="checkbox" id="remember_me">
                                            <label for="remember_me">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="forgotton-password_info">
                                            <a href="forget-password"> Forgotten pasward?</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="login" class="hiraola-login_btn">Login</button>
                                    </div>
                                    <div class="col-md-12">
                                         <a href="<?= base_url?>register" class=" text-dark">Create account</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Login Register Area  End Here -->
<?php require_once('footer.php');?>