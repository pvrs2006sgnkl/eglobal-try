<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Client managment</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		.box-title{
			border-radius: 5px;
			box-shadow: 0px 0px 3px 1px gray;
			padding: 10px 0px;
		}
		.error-msg{
			color: #dc3545;
			font-weight: 600;
		}
		.success-msg{
			color: green;
			font-weight: 600;
		}
	</style>
</head>

<body>
	
	<div class="container-fluid">
		<div class="container">
			<div  class="row justify-content-center">
				<div class="col-lg-6">
				<button type="button" class="btn btn-lg btn-primary add-new-client" data-toggle="modal" data-target="#exampleModalCenter" >Add Record</button>	
				</div>
				<div class="col-lg-6">
					<input type="text" id="search" class="form-control" placeholder="Search Now">
				</div>
			</div>
			<div class="row mt-5" id="tbl_rec">
		
			</div>
		</div>
	</div>
	
<!-- Insert Design Modal -->
	
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered add-record" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="ins_rec">
	      <div class="modal-body">
			  	<div class="form-group">
					<label><b>First Name</b></label>
					<input type="text" name="first_name" class="form-control" placeholder="First Name">
					<span class="error-msg first_name_error error"></span>
			  	</div>
			  	<div class="form-group">
					<label><b>Last Name</b></label>
					<input type="text" name="last_name" class="form-control" placeholder="Last Name">
					<span class="error-msg last_name_error error"></span>
			  	</div>	
				<div class="form-group">
					<span class="error-msg error-msg-info"></span>
					<span class="success-msg" id="sc_msg"></span>
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" id="close_click" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" >Add Record</button>
	      </div>
      </form>
    </div>
  </div>
</div>
	
<!-- End Insert Modal -->
		
<!-- Update Design Modal -->
	
<div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalCenterTitle">Update Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="updata">
	  <input type="hidden" name="client_id" value="" class="client_ref_id"/>
      <div class="modal-body">
		  	<div class="form-group">
				<label><b>First Name</b></label>
				<input type="text" class="form-control first_name_info" name="first_name" placeholder="First Name">
				<span class="error-msg first_name_error"></span>
		  	</div>
		  	<div class="form-group">
				<label><b>Last Name</b></label>
				<input type="text" class="form-control last_name_info" name="last_name" placeholder="Last Name">
				<span class="error-msg flast_name_error"></span>
		  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="up_cancle">Cancle</button>
        <button type="submit" class="btn btn-primary">Update Record</button>
      </div>
      </form>	
    </div>
  </div>
</div>	
	
<!-- End Update Design Modal -->
	
<!-- Delete Design Modal -->
	
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalCenterTitle">Are You Sure Delete This Record ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <p>If You Click On Delete Button Record Will Be Deleted. We Don't have Backup So Be Carefull.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="de_cancle" data-dismiss="modal">Cancle</button>
        <button type="button" class="btn btn-primary" id="deleterec">Delete Now</button>
      </div>
    </div>
  </div>
</div>	
	
<!-- End Delete Design Modal -->
	
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">
	
$(document).ready(function (){
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
	};

	var load_address_param = '';

	if(getUrlParameter('page') !== undefined && getUrlParameter('page') != '')
		load_address_param = '?page='+getUrlParameter('page')+'&client_id='+getUrlParameter('client_id');

	$('#tbl_rec').load('record.php'+load_address_param);

	$('#search').keyup(function (){
		var search_data = $(this).val();
		$('#tbl_rec').load('record.php', {keyword:search_data});
	});

	$('button.add-new-client').on('click', function()
	{
		$("#ins_rec").find('input').each(function()
		{
			$(this).val('');
		});
	});

	//insert Record

	$('#ins_rec').on("submit", function(e){
		e.preventDefault();

		$.ajax({

			type:'POST',
			url:'insprocess.php',
			data:$(this).serialize(),
			success:function(vardata){

				var json = JSON.parse(vardata);

				var response_fld_ref = '';
				$('#ins_rec .error').addClass('d-none').removeClass('d-show').html('');

				if(json.status == 101){
					console.log(json.msg);
					$('#tbl_rec').load('record.php');
					$('#ins_rec').trigger('reset');
					$('#close_click').trigger('click');
				}
				else if(json.status == 102){
					$('#sc_msg').text(json.msg);
					console.log(json.msg);
				}
				else if(json.status == 103)
					response_fld_ref = '#ins_rec .first_name_error';
				else if(json.status == 104)
					response_fld_ref = '#ins_rec .last_name_error';

				if(json.status == 201)
					response_fld_ref = '#ins_rec .error-msg-info';

				$(''+response_fld_ref+'').html(json.msg).addClass('d-show').removeClass('d-none');

			}

		});

	});

	//select data

	$(document).on("click", "button.editdata", function(){
		var check_id = $(this).data('dataid');

		$.getJSON("updateprocess.php", {checkid : check_id}, function(json){
			console.log(json);
			if(json.status == 0){
				$('#updateModalCenter .client_ref_id').val(check_id);
				$('#updateModalCenter .first_name_info').val(json.first_name);
				$('#updateModalCenter .last_name_info').val(json.last_name);
			}
			else{
				console.log(json.msg);
			}
		});
	});

	//Update Record

	$('#updata').on("submit", function(e){
		e.preventDefault();

		$.ajax({

			type:'POST',
			url:'updateprocess2.php',
			data:$(this).serialize(),
			success:function(vardata){

				var json = JSON.parse(vardata);

				if(json.status == 101){
					console.log(json.msg);
					$('#tbl_rec').load('record.php');
					$('#ins_rec').trigger('reset');
					$('#up_cancle').trigger('click');
				}
				else if(json.status == 102){
					$('#umsg_6').text(json.msg);
					console.log(json.msg);
				}
				else if(json.status == 103){
					$('#umsg_1').text(json.msg);
					console.log(json.msg);
				}
				else if(json.status == 104){
					$('#umsg_2').text(json.msg);
					console.log(json.msg);
				}
				else if(json.status == 105){
					$('#umsg_3').text(json.msg);
					console.log(json.msg);
				}
				else if(json.status == 107){
					$('#umsg_4').text(json.msg);
					console.log(json.msg);
				}
				else if(json.status == 106){
					$('#umsg_5').text(json.msg);
					console.log(json.msg);
				}

				else{
					console.log(json.msg);
				}

			}

		});

	});

	//delete record

	var deleteid;

	$(document).on("click", "button.deletedata", function(){
		deleteid = $(this).data("dataid");
	});

	$('#deleterec').click(function (){
		$.ajax({
			type:'POST',
			url:'deleteprocess.php',
			data:{delete_id : deleteid},
			success:function(data){
				var json = JSON.parse(data);
				if(json.status == 0){
					$('#tbl_rec').load('record.php');
					$('#de_cancle').trigger("click");
					console.log(json.msg);
				}
				else{
					console.log(json.msg);
				}
			}
		});
	});
});

</script>

</body>
</html>
