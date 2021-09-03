<?php
session_start();
require_once('constant.php');
session_destroy();
header('Location:'.admin_path);
?>