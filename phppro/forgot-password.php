<?php 
$active_tab='forgot password';
require_once('header.php');
require_once('menu.php');
if(isset($_REQUEST['email'])) {
    $data = $QueryFire->getAllData('users',' email="'.trim(strip_tags($_POST['email'])).'"');
	if(!empty($data[0])) {
	    $data = $data[0];
	    if($data['is_verified'] ==1) {
	        $token = generateRandomString(10);
	        $QueryFire->upDateTable("users",' email="'.trim(strip_tags($_REQUEST['email'])).'"', array('access_token'=>$token));
	        $success = 'Password reset successfully. Check your email to change password.';
	        $to = $data['email'];
	        $subject = 'Forgot password request from IP Address '.get_client_ip();
	        $htmlContent ="
	        <html>
	            <head>
	                <title>Forgot password</title>
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
	                Hi <b>".$data['name']."</b>,<br>
	                Someone just requested forgot password option on your registered mail with  ".get_client_ip()." on <a href=". base_url .">sakshijewels.com</a> <br> If this is not you kindly report us at sakshijewels.com<br><br>
	                <b>To reset your password <a href='".base_url."change-password/".$token."'> click here<a/>.</b>
	            </body>
	        </html>";
	        // Set content-type header for sending HTML email
	        $headers= "MIME-Version: 1.0" . "\r\n";
	        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	        // Additional headers
	        $headers .= 'From: admin <sakshijewels.com>' . "\r\n";
	        if(mail($to,$subject,$htmlContent ,$headers)) {
	            $success = 'Password reset successfully. Check your email to change password.';
	        } else {
	            $error=" You are not verified your email yet. Kindly check your mail and then click to verify.";
	        }
	        //if(mail($to,$subject,$htmlContent ,$headers))
	        //echo "<script>window.location.href='".base_url."';</script>";
	    }
	    else
	        $error=" You are not verified your email yet. Kindly check your mail and then click to verify.";       
	} else {
	    $error = "Incorrect email address.";
	}
}
?>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Forgot Password</h2>
                <ul>
                    <li><a href="<?php base_url ?>">Home</a></li>
                    <li class="active">Forgot Password</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="hiraola-login-register_area">
        <div class="container ">
        <?= isset($success)?'<h3 class="text-center text-primary">'.$success.'</h3>': (isset($error)?'<h3 class="text-center text-warning">'.$error.'</h3>':'')?>
            <div class="row ">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mx-auto">
                    <form method="post" action="" accept-charset="UTF-8">
                        <div class="login-form" >
                            <h4 class="login-title">Forgot Password</h4>
                            <div class="post-comment">
                                <input type="email" name="email" required placeholder="Your Mail *">
                                <button class="hiraola-login_btn mt-1" type="submit">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once('footer.php');?>