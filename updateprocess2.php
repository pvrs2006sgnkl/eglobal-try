<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['first_name']) && isset($_POST['last_name'])){

		$update_id = $user_fun->htmlvalidation($_POST['client_id']);
		$firstname = $user_fun->htmlvalidation($_POST['first_name']);
		$lastname = $user_fun->htmlvalidation($_POST['last_name']);

		if((!preg_match('/^[ ]*$/', $firstname)) && (!preg_match('/^[ ]*$/', $lastname)) ){

			$condition['id'] = $update_id;

			$field_val['firstname'] = $firstname;
			$field_val['lastname'] = $lastname;

			$update = $user_fun->update("client", $field_val, $condition);

			if($update){
				$json['status'] = 101;
				$json['msg'] = "Data Successfully Updated";
			}
			else{
				$json['status'] = 102;
				$json['msg'] = "Data Not Updated";
			}

		}
		else{

			if(preg_match('/^[ ]*$/', $firstname)){

				$json['status'] = 103;
				$json['msg'] = "Please Enter First Name";

			}
			if(preg_match('/^[ ]*$/', $lastname)){

				$json['status'] = 104;
				$json['msg'] = "Please Enter Last Name";

			}
		}
	}
	else{

		$json['status'] = 108;
		$json['msg'] = "Invalid Values Passed";
	}
}
else{

	$json['status'] = 109;
	$json['msg'] = "Invalid Method Found";
}
echo json_encode($json);

?>