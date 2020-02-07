<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['delete_id']) && $_POST['delete_id'] > 0){

		$deleteid = $user_fun->htmlvalidation($_POST['delete_id']);

		$condition['id'] = $deleteid;
		$delete_rec = $user_fun->delete("client",$condition);
		
		if($delete_rec){
			$json['status'] = 0;
			$json['msg'] = "SuccessFully Deleted";

			$condition['cid'] = $condition['id'];
			unset($condition['id']);
			$delete_rec = $user_fun->delete("client_address",$condition);
		}
		else{
			$json['status'] = 1;
			$json['msg'] = "Data Not Deleted";
		}

	}
	else{
		$json['status'] = 2;
		$json['msg'] = "Invalid Value Passed";
	}

}
else{
	$json['status'] = 3;
	$json['msg'] = "Invalid Method Found";
}

echo json_encode($json);


?>