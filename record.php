<?php

include_once('config.php');
$user_fun = new Userfunction();
$counter = 1;

if(isset($_POST['keyword']) && !empty(trim($_POST['keyword']))){

	$keyword = $user_fun->htmlvalidation($_POST['keyword']);

	$match_field['firstname'] = $keyword;
	$match_field['lastname'] = $keyword;
	$select = $user_fun->search("client", $match_field, "OR");

}
else{
	if(isset($_GET['page']) && isset($_GET['client_id']) && $_GET['client_id'] > 0)
	{
		$match_field['cid'] = $user_fun->htmlvalidation($_GET['client_id']);
		$select = $user_fun->search("client_address", $match_field);
		?>
		<table class="table" style="vertical-align: middle; text-align: center;">
			<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Street</th>
				<th scope="col">City</th>
				<th scope="col">Zipcode</th>
				<th scope="col">Country</th>
				<th scope="col">Action</th>
			</tr>
			</thead>
			<tbody>
			<?php if($select){ foreach($select as $se_data){ ?>
			<tr>
				<th scope="row"><?php echo $counter; $counter++; ?></th>
				<td><?php echo $se_data['street']; ?></td>
				<td><?php echo $se_data['zipcode']; ?></td>
				<td><?php echo $se_data['city']; ?></td>
				<td><?php echo $se_data['country']; ?></td>
				<td>
					<button type="button" class="btn btn-danger editdata" data-dataid="<?php echo $se_data['ca_id']; ?>" data-toggle="modal" data-target="#updateModalCenter">Update</button>
					<button type="button" class="btn btn-danger deletedata" data-dataid="<?php echo $se_data['ca_id']; ?>" data-toggle="modal" data-target="#deleteModalCenter">Delete</button>
				</td>
			</tr>
			<?php }}else{ echo "<tr><td colspan='7'><h2>No Result Found</h2></td></tr>"; } ?>
			</tbody>
		</table>	
	<?php
	}
	else
	{
		$select = $user_fun->select("client");
	?>
		<table class="table" style="vertical-align: middle; text-align: center;">
			<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">First Name</th>
				<th scope="col">Last Name</th>
				<th scope="col">&nbsp;</th>
				<th scope="col">Action</th>
			</tr>
			</thead>
			<tbody>
			<?php if($select){ foreach($select as $se_data){ ?>
			<tr>
				<th scope="row"><?php echo $counter; $counter++; ?></th>
				<td><?php echo $se_data['firstname']; ?></td>
				<td><?php echo $se_data['lastname']; ?></td>
				<td>
					<a href="address.php?page=address&client_id=<?php echo $se_data['id'];?>">View my address</a>
				</td>
				<td>
					<button type="button" class="btn btn-danger editdata" data-dataid="<?php echo $se_data['id']; ?>" data-toggle="modal" data-target="#updateModalCenter">Update</button>
					<button type="button" class="btn btn-danger deletedata" data-dataid="<?php echo $se_data['id']; ?>" data-toggle="modal" data-target="#deleteModalCenter">Delete</button>
				</td>
			</tr>
			<?php }}else{ echo "<tr><td colspan='7'><h2>No Result Found</h2></td></tr>"; } ?>
			</tbody>
		</table>	
	<?php
	}
}
?>