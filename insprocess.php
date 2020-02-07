<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(!isset($_GET['page']) || $_GET['page'] != 'address'){
		if(isset($_POST['first_name']) && isset($_POST['last_name'])){

			$first_name = $user_fun->htmlvalidation($_POST['first_name']);
			$last_name = $user_fun->htmlvalidation($_POST['last_name']);

			if((!preg_match('/^[ ]*$/', $first_name)) && (!preg_match('/^[ ]*$/', $last_name))){

				$field_val['firstname'] = $first_name;
				$field_val['lastname'] = $last_name;
		
				$select = $user_fun->search("client", $field_val, "AND");

				if(is_array($select) && count($select) > 0)
				{
					$json['status'] = 201;
					$json['msg'] = "The record already exists...";
					echo json_encode($json);
					exit;
				}

				$insert = $user_fun->insert("client", $field_val);

				if($insert){
					$json['status'] = 101;
					$json['msg'] = "Data Successfully Inserted";
				}
				else{
					$json['status'] = 102;
					$json['msg'] = "Data Not Inserted";
				}
			}
			else{
				if(preg_match('/^[ ]*$/', $first_name)){

					$json['status'] = 103;
					$json['msg'] = "Please enter first name";

				}
				else if(preg_match('/^[ ]*$/', $last_name)){

					$json['status'] = 104;
					$json['msg'] = "Please enter last name";
				}
			}
		}
		else{
			$json['status'] = 108;
			$json['msg'] = "Invalid Values Passed";
		}
	}
	else
	{
		$client_id = $user_fun->htmlvalidation($_POST['client_id']);
		$street_name = $user_fun->htmlvalidation($_POST['street_name']);
		$city = $user_fun->htmlvalidation($_POST['city']);
		$zipcode = $user_fun->htmlvalidation($_POST['zipcode']);
		$country = $user_fun->htmlvalidation($_POST['country']);

		if(!preg_match('/[0-9]/', $client_id))
		{
			$json['status'] = 301;
			$json['msg'] = "Invalid client to request...";
		}
		else if(!preg_match('/[0-9a-zA-Z, ]/i', trim($street_name)))
		{
			$json['status'] = 302;
			$json['msg'] = "Please enter the street name";
		}
		else if(!preg_match('/[0-9a-zA-Z, ]/i', $city))
		{
			$json['status'] = 303;
			$json['msg'] = "Please enter city name";
		}
		else if(!preg_match('/[0-9a-zA-Z, ]/i', $zipcode))
		{
			$json['status'] = 304;
			$json['msg'] = "Please enter the zipcode";
		}
		else if(!preg_match('/[0-9a-zA-Z]/i', $country))
		{
			$json['status'] = 305;
			$json['msg'] = "Please choose country";
		}
		else
		{
			$field_val['cid'] = $client_id;
			$field_val['street'] = $street_name;
			$field_val['zipcode'] = $zipcode;
			$field_val['city'] = $city;
			$field_val['country'] = $country;

			$insert = $user_fun->insert("client_address", $field_val);

			if($insert){
				$json['status'] = 101;
				$json['msg'] = "Data Successfully Inserted";
			}
			else{
				$json['status'] = 102;
				$json['msg'] = "Data Not Inserted";
			}
		}
	}
}
else{

	$json['status'] = 109;
	$json['msg'] = "Invalid Method Found";
}
echo json_encode($json);

?>