<?php
set_time_limit(0);
require_once('constant.php');
class QueryFire {
	function __construct($dt=array()) {
		$this->connection = new mysqli(dbserver,dbuser, dbpass,dbname);
		$this->data = array();
		$this->data[0] = 5;
		$this->data[1] = 40;
		$this->data[2] = 20;
		$this->data['amount'] = 100;
		$this->dt = $dt;
	}

	public function getAllData($table_name,$where,$cust=null) {	
		if($cust!=null)
			$sql= $cust;
		else	
			$sql = "SELECT * FROM ".$table_name." WHERE ".$where;
		//echo $sql;
		$p = mysqli_query($this->connection,$sql);
		if(mysqli_error($this->connection)) {
		    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		    error_log($sql.' -- --'.$actual_link);
		    echo $sql;
		}
		while($data = mysqli_fetch_array($p,MYSQLI_ASSOC))
		{
			$q[] = $data;
		}
		if(!empty($q))
			return $q;
		else
			return array();
	}

	//this is for uploding files
	function fileUpload($data,$path='../assets/images/',$cstm=false,$ff=0) {
		//check path exists or not
		if(!is_dir($path)) {
			mkdir($path);
		}
		$ret = false;
		$arr = array();
		//set actual path for image
		$target_dir = '';
		$image_type = strtolower(pathinfo($data['name'],PATHINFO_EXTENSION));
		$image_name = rand(99,10).date('Ymdhis').'.'.$image_type;
		if($image_type =='jpg'|| $image_type =='jpeg' || $image_type =='png' || $image_type =='gif' || $image_type =='bmp')
		  $ret =true;

		if($cstm)
			if(in_array($image_type, $ff))
				$ret = true;
		/*if($data['size']> 2000000)
		  $ret = false;*/
		if($ret)
		  if(move_uploaded_file($data['tmp_name'],$path.$image_name))
		  {
		    $arr['image_name'] = $image_name;
		    $success = " New record added successfully.";
		  }
		  else
		    $success = "Can not upload file.";
		else
		  $success = "Unable to add record.";
		$arr['status'] = $ret;
		$arr['message'] = $success;
		return $arr;
	}

	function multipleFileUpload($data,$path='../assets/images/') {
		if(!is_dir($path))
		{
			mkdir($path);
		}
		$ret = false;
		$arr = array();
		for($i=0;$i<count($data['name']);$i++)
		{
			$image_type = strtolower(pathinfo($data['name'][$i],PATHINFO_EXTENSION));
			$image_name = rand(99,10).date('Ymdhis').'.'.$image_type;
			if($image_type =='jpg'|| $image_type =='jpeg' || $image_type =='png' || $image_type =='gif' || $image_type =='bmp')
			  $ret =true;
			/*if($data['size']> 2000000)
			  $ret = false;*/
			  if(!file_exists($path))
			  	mkdir($path);
			if($ret)
			  if(move_uploaded_file($data['tmp_name'][$i],$path.$image_name))
			  {
			    $arr['image_name'][$i] = $image_name;
			    $success = " New record added successfully.";
			   /* if($BaseClassObject->insertData('galleries',$data,$fields))
			      $success = " New record added successfully.";
			    else
			      $success = " System error while adding record.";*/
			  }
			  else
			    $success[$i] = "Can not upload file.";
			else
			  $success[$i] = "Unable to add record.";
		}
		$arr['status'] = $ret;
		$arr['message'] = $success;
		return $arr;
	}

	public function insertData($table_name,$data) {
		//using InserArray function
		/*$da = $this->insertArray($data);
		$sql = 'INSERT INTO '.$table_name.'('.$da['fields'].') VALUES ('.$da['values'].')';*/
		$da = $this->changeArrayToString($data);
		$sql = 'INSERT INTO '.$table_name.'('.implode(",",array_keys($data)).') VALUES ('.$da.')';
		return mysqli_query($this->connection,$sql);
	}

	public function upDateTable($table_name,$where,$data) {
		$da = $this->changeArrayToKeyValue($data);
		$sql = 'UPDATE '.$table_name.' SET '.$da.' WHERE '.$where;
		return mysqli_query($this->connection,$sql);
	}

	function updateTableAsIt($sql) {
		return mysqli_query($this->connection,$sql);
	}

	public function deleteDataFromTable($table_name,$where) {
		$sql = 'DELETE FROM '.$table_name.' WHERE '.$where;
		return mysqli_query($this->connection,$sql);
	}

	function changeArrayToKeyValue($data) {
		$str ='';
		foreach($data as $key=>$value)
		{
			if(empty($str))
				$str = $key.' ="'.strip_tags(trim($value)).'"';
			else
				$str .= ' ,'.$key.' ="'.strip_tags(trim($value)).'"';
		}
		return $str;
	}

	function getLastInsertId() {
		return mysqli_insert_id($this->connection);
	}

	//this is unused now but can be used when need to make string from array
	function changeArrayToString($data) {
		$str = '';
		foreach($data as $value)
		{
			if(empty($str))
				$str = '"'.trim(strip_tags($value)).'"';
			else
				$str .=' ,"'.trim(strip_tags($value)).'"';
		}
		return $str;
	}

	//makes cols n different just like list ** not using implode function as implode do not give prover result 
	function insertArray($data) {
		$ar  = array();
		$str = '';
		$str1 = '';
		foreach($data as $key=>$value)
		{
			if(empty($str))
			{
				$str1 = $key;
				$str = '"'.strip_tags(trim($value)).'"';
			}
			else
			{
				$str1 = ','.$key;
				$str .=' ,"'.strip_tags(trim($value)).'"';
			}
		}
		$ar['fields'] = $str1;
		$ar['values'] = $str;
		return $ar;
	}

	function getAllCount($tablename) {
		$sql = 'SELECT * FROM '.$tablename;
		return mysqli_num_rows(mysqli_query($this->connection,$sql));
	}

	function tableFields($sql) {
		return mysqli_query($this->connection,$sql);
		//return mysqli_num_fields(mysqli_query($this->connection,$sql));
	}

	//send sms 
	function sendSms($sms='',$phones) {
		$sms=urlencode($sms);
		$url="http://sms.weras.in/pushsms.php";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=vaijapurcongress&password=weras147&sender=werass&numbers=$phones&message=$sms");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$response = curl_exec($ch);
		return $response;
	}

	//find children
	public function getChildren($parent_id,$dt=array()) {
		$info = $this->getAllData('users',' parent_id='.$parent_id);
		if(!empty($info)) {
			//$dt = array_merge($dt, $info);
			foreach($info as $inf) {
				if($inf['id'] !== $inf['parent_id']) {
					array_push($dt, $inf);
					$dt = $this->getChildren($inf['id'],$dt);
				}
			}
		}
		return $dt;
	}
}

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//from here custom functions starts
function pr(&$data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function sendEmail($data) {
	$headers = "From:" . $data['from'];
	return mail($data['to'],$data['subject'],$data['message'],$headers);
}

//generating random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function makeShortString($string, $length=15, $dots = "...") {
	$string = trim(strip_tags(html_entity_decode($string)));
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function to_prety_url($str) {
	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = trim(preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str));
	$str = strtolower( trim($str, '-') );
	return $str;
}

function validateyoutubelink($id) {
	$valid = file_get_contents('https://img.youtube.com/vi/'.$id.'/mqdefault.jpg');
	if(!empty($valid)) {
		return 1;
	}
	return 0;
}

function unlinkImage($file) {
	if(file_exists($file))
		return unlink($file);
	else
		return true;
}
$videoFormats = array('mp4','webm','3gp','flv','avi');
$imageFormats = array('png','webm','jpg','jpeg','avi');
$audioFormats = array('wav','mpeg','mp4','aac','ogg');
$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
//creat quey object
$QueryFire = new QueryFire();
if(isset($_REQUEST)&& !empty($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 'get-seo-details':
			$users = array();
			if(!empty($_REQUEST['id'])) {
				$users = $QueryFire->getAllData('seo','id='.$_REQUEST['id'],'SELECT id,page_id,title,description,image_name FROM seo  WHERE id='.$_REQUEST['id'])[0];
			}
			echo json_encode($users);
			break;
		case 'delete-product':
			$where = 'id ='.$_REQUEST['id'];
			$QueryFire->deleteDataFromTable("products",$where,array('is_deleted'=>1));
			echo "success";
			break;
		case 'delete-blog':
			$where = 'id ='.$_REQUEST['id'];
			$QueryFire->deleteDataFromTable("blogs",$where,array('is_deleted'=>1));
			echo "success";
			break;
		case 'getsubcat':
			$res = '';
			$categories = $QueryFire->getAllData('categories',' is_deleted=0 and is_show=1 and level=2 and parent_id ='.$_REQUEST['id']);
			if(!empty($categories)) {
				$res = '<option value=""> -- Select Sub Category -- </option>';
				foreach($categories as $cat) {
					$res.='<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
				}
			}
			echo $res;
			break;
		case 'getparamvalues':
			$data = array();
			if(!empty($_REQUEST['id'])) {
				$states = $QueryFire->getAllData('product_params_values',' is_deleted=0 and param_id in ('. implode(',', $_REQUEST['id']) .')');
				$selected = !empty($_REQUEST['selected'])?explode(',', $_REQUEST['selected']):array();
				if(!empty($states)) {
					foreach($states as $state) {
						if(in_array($state['id'], $selected))
							array_push($data, array('id'=> $state['id'],'text'=>$state['param_value'],"selected" => true));
						else
							array_push($data, array('id'=> $state['id'],'text'=>$state['param_value']));
					}
				}
			}
			echo json_encode($data);
			break;
		case 'useraddress':
			$where = ' id ='.$_REQUEST['id'];
			$data = $QueryFire->getAllData('user_addresses',$where);
			$ar = array();
			if(!empty($data[0]))
			{
				$ar['status'] = true;
				$ar['data'] = $data;
			}
			else
			{
				$ar['status'] = false;
				$ar['error'] = "Data not found";
			}
			echo json_encode($ar);
			break;
		case 'del_user_add':
			$where = 'id ='.$_REQUEST['id'];
			$QueryFire->upDateTable("user_addresses",$where,array('is_deleted'=>1));
			//$QueryFire->deleteDataFromTable('user_addresses',$where);
			header('Location:'.$_SERVER['HTTP_REFERER']);
			break;
		default:
			echo "No action Found";
			break;
	}
}