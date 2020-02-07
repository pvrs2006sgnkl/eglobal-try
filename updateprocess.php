<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isset($_GET['checkid']) && $_GET['checkid'] > 0){

		$update_client_id = $user_fun->htmlvalidation($_GET['checkid']);

		$condition0['id'] = $update_client_id;
		$select_pre = $user_fun->select_assoc("client", $condition0);

		if($select_pre){

			$json['status'] = 0;
			$json['first_name'] = $select_pre['firstname'];
			$json['last_name'] = $select_pre['lastname'];
			$json['msg'] = "Success";

		}
		else{

			$json['status'] = 1;
			$json['first_name'] = "NULL";
			$json['last_name'] = "NULL";
			$json['msg'] = "Fail";
		}

	}
	else{
			$json['status'] = 2;
			$json['first_name'] = "NULL";
			$json['last_name'] = "NULL";
			$json['msg'] = "Invalid Values Passed";
	}
}
else{
			$json['status'] = 3;
			$json['firstname'] = "NULL";
			$json['lastname'] = "NULL";
			$json['msg'] = "Invalid Method Found";
}


echo json_encode($json);

?>