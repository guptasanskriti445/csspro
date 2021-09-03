<?php
$active_tab="login register";
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
if(isset($_POST['register'])) {
    if($_POST['pass'] == $_POST['repass']) {
        $where = ' email = "'.strip_tags(trim($_POST['email'])).'"';
        $data = $QueryFire->getAllData('users',$where);
        if(empty($data)) {
            $arr = array();
            $arr['name'] = strip_tags($_POST['name']);
            $arr['email'] = strip_tags($_POST['email']);
            $arr['address'] = strip_tags($_POST['address']);
            $arr['pincode'] = strip_tags($_POST['pincode']);
            $arr['mobile_no'] = strip_tags($_POST['mobile_no']);
            $arr['password'] = md5(trim($_POST['pass']));
            $arr['access_token'] = generateRandomString(10);
            $arr['is_verified'] = 0;
            
            $headers= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // Additional headers
            $headers .= 'From: Admin <arsalaanbusiness@gmail.com>' . "\r\n";
            //mail($to,$subject,$htmlContent ,$headers);
            $template = file_get_contents('verify_template.php');
            $template = str_replace('%name%', $arr['name'] , $template);
            $template = str_replace('%link2text%', 'Yalla Nstre' , $template);
            $template = str_replace('%link2%', base_url , $template);
            $template = str_replace('%link%', base_url.'verify/'.$arr['access_token'] , $template);
            mail($arr['email'],"Verify Account",$template ,$headers);
            if($QueryFire->insertData('users',$arr))
                $error = "<div class='col-md-12 col-sm-12 col-xs-12'><h4 class='text-success text-center'>You have successfully created your account.</h4></div>";
            else
                $error = "<div class='col-md-12 col-sm-12 col-xs-12'><h4 class='text-danger text-center'>Unable to create new account</h4></div>";
        } else {
          $error = "<div class='col-md-12 col-sm-12 col-xs-12'><h4 class='text-danger text-center'>Email already exists!</h4></div>";
        }
    } else {
        $error = "<div class='col-md-12 col-sm-12 col-xs-12'><h4 class='text-danger text-center'>Password and Re-Enter password does not match.</h4></div>";
    }
}
?>

        <!-- Begin Hiraola's Breadcrumb Area -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Login & Regiter</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Login & Register</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->
        <!-- Begin Hiraola's Login Register Area -->
        <div class="hiraola-login-register_area">
            <div class="container">
            
            <div><?= isset($error)?$error:''?></div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6">
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
                                            <a href="<?= base_url?>forget-password"> Forgotten pasward?</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="login" class="hiraola-login_btn">Login</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                        <form action="" method="post">
                            <div class="login-form">
                                <h4 class="login-title">Register</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb--20">
                                        <label>Name</label>
                                        <input type="text" required name="name" placeholder="User Name">
                                    </div>
                                    <div class="col-md-6 col-12 mb--20">
                                        <label>Email Address*</label>
                                        <input type="email" required name="email" placeholder="Email Address">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Address*</label>
                                        <input type="text" required name="address" placeholder="Address">
                                    </div>
                                    <div class="col-md-6 col-12 mb--20">
                                        <label>PinCode</label>
                                        <input type="text"required name="pincode" placeholder="Pincode" placeholder="First Name">
                                    </div>
                                    <div class="col-md-6 col-12 mb--20">
                                        <label>Mobile Number</label>
                                        <input type="text"  required name="mobile_no" placeholder="Mobile Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Password</label>
                                        <input type="password"  required name="pass" placeholder="Password">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Confirm Password</label>
                                        <input type="password" required name="repass" placeholder="Confirm Password">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" name="register" class="hiraola-register_btn">Register</button>
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