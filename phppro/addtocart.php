<?php
session_start();
$pr_id = $_REQUEST['id'];
$quantity = isset($_REQUEST['quantity'])?$_REQUEST['quantity']:1;
if(isset($_REQUEST['action']) && $_REQUEST['action']=='add')
{
	if(isset($_SESSION['cartitems']))
	{
		//find index of an array if it exits then do not add else add to cart and then
		if (!array_key_exists($pr_id,$_SESSION['cartitems']))
		{
			$_SESSION['cartitems'][$pr_id]['id'] = $pr_id;
			$_SESSION['cartitems'][$pr_id]['quantity'] = $quantity;
		}
	}
	else
	{
		$_SESSION['cartitems'][$pr_id]['id'] = $pr_id;
		$_SESSION['cartitems'][$pr_id]['quantity'] = $quantity;		
	}
	$arr = array();
	$arr['count'] = count($_SESSION['cartitems']);
	$arr['message'] = 'Item successfully added';
	echo json_encode($arr);
} else if(isset($_REQUEST['action']) && $_REQUEST['action']=='remove')
{
	if (array_key_exists($pr_id,$_SESSION['cartitems']))
	{
		$_SESSION['cartitems'][$pr_id]='';
		unset($_SESSION['cartitems'][$pr_id]);
	}
	$arr['count'] = count($_SESSION['cartitems']);
	$arr['message'] = 'Item successfully removed from cart';
	$arr['status']  = true;
	echo json_encode($arr);
} else if(isset($_REQUEST['action']) && $_REQUEST['action']=='quantity')
{
	if (array_key_exists($pr_id,$_SESSION['cartitems']))
	{
		$_SESSION['cartitems'][$pr_id]['quantity']=$quantity;
	}
	else
	{
		$_SESSION['cartitems'][$pr_id]['id'] = $pr_id;
		$_SESSION['cartitems'][$pr_id]['quantity'] = $quantity;
	}
	$arr['count'] = count($_SESSION['cartitems']);
	$arr['message'] = 'Quantity changed successfully. ';
	$arr['status']  = true;
	echo json_encode($arr);
} else if(isset($_REQUEST['action']) && $_REQUEST['action']=='add_wish_list')
{
	if(isset($_SESSION['wishlist']))
	{
		//find index of an array if it exits then do not add else add to cart and then
		if (!array_key_exists($pr_id,$_SESSION['wishlist']))
		{
			$_SESSION['wishlist'][$pr_id]['id'] = $pr_id;
			$_SESSION['wishlist'][$pr_id]['quantity'] = $quantity;
		}
	}
	else
	{
		$_SESSION['wishlist'][$pr_id]['id'] = $pr_id;
		$_SESSION['wishlist'][$pr_id]['quantity'] = $quantity;		
	}
	$arr = array();
	$arr['count'] = count($_SESSION['wishlist']);
	$arr['message'] = 'Item successfully added to wishlist';
	echo json_encode($arr);
} else if(isset($_REQUEST['action']) && $_REQUEST['action']=='remove1')
{
	if (array_key_exists($pr_id,$_SESSION['wishlist']))
	{
		$_SESSION['wishlist'][$pr_id]='';
		unset($_SESSION['wishlist'][$pr_id]);
	}
	$arr['count'] = count($_SESSION['wishlist']);
	$arr['message'] = 'Item successfully removed from wishlist';
	$arr['status']  = true;
	echo json_encode($arr);
} else if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'coupon')
{
	$arr = array();
	//now get whether coupon exists or not
	require_once('secure-admin-panel/query.php');
	$coupon = $QueryFire->getAllData('coupons', ' status="active" and is_deleted=0 and code="'.strip_tags(trim($pr_id)).'"')[0];
	if(!empty($coupon))
	{
		$_SESSION['coupon'] = $coupon;
		$arr['message'] = 'Code applied successfully.';
		$arr['status']  = true;
	}
	else
	{
		$arr['message'] = 'Invalid coupon/promocode';
		$arr['status']  = false;
	}
	echo json_encode($arr);
} else if(isset($_REQUEST['action']) && $_REQUEST['action']=='filter')
{
	if (array_key_exists($pr_id,$_SESSION['cartitems'])) {
		$_SESSION['cartitems'][$pr_id]['filter'][$_REQUEST['type']] = $_REQUEST['val'];
	} else {
		$_SESSION['cartitems'][$pr_id]['id'] = $pr_id;
		$_SESSION['cartitems'][$pr_id]['quantity'] = $quantity;
		$_SESSION['cartitems'][$pr_id]['filter'][$_REQUEST['type']] = $_REQUEST['val'];
	}
	$arr['count'] = count($_SESSION['cartitems']);
	$arr['message'] = ucfirst($_REQUEST['type']).' successfully. ';
	$arr['status']  = true;
	echo json_encode($arr);
}