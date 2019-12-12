<?php
//brand.php
include 'database_connection.php';

include 'function.php';

if (!isset($_SESSION['type'])) {
	header('location:login.php');
}

if ($_SESSION['type'] != 'master') {
	header('location:index.php');
}

include 'header.php';

?>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
                			<h3 class="panel-title">Complain List</h3>
                		</div>
                		<div class="col-md-2" align="right">
                			<button type="button" name="add" id="add_button" class="btn btn-success">Add</button>
                		</div>
                	</div>
                </div>
                <div class="panel-body">
                	<table id="complain_data" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>Subject</th>
								<th>Description</th>
								<th>User Name</th>
								<th>User Organization</th>
								<th>User Phone</th>
								<th>Status</th>
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="complainModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="complain_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Complain</h4>
    				</div>
    				<div class="modal-body">
    					<div class="form-group">
    						<select name="category_id" id="category_id" class="form-control" required>
								<option value="">Select Category</option>
								<?php echo fill_category_list($connect); ?>
							</select>
    					</div>
    					<div class="form-group">
							<label>Enter Complain Subject</label>
							<?php echo getSingleValue($connect, 'category_name', 'category', 'category_id', 4); ?>
							<input type="text" name="subject" id="subject" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Complain Description</label>
							<textarea class="md-textarea form-control" id="description" name="description" rows="4" cols="50">
							</textarea>
						</div>

						<div class="form-group">
							<label>Emergency Contact to talk with</label>
							<input type="text" name="contact_no" id="contact_no" class="form-control" required />
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="complain_id" id="complain_id" />
    					<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#complainModal').modal('show');
		$('#complain_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Complain");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#complain_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"complain_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#complain_form')[0].reset();
				$('#complainModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				branddataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var complain_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:'complain_action.php',
			method:"POST",
			data:{complain_id:complain_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#complainModal').modal('show');
				$('#category_id').val(data.category_id);
				$('#complain_name').val(data.complain_name);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Complain");
				$('#complain_id').val(complain_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});

	$(document).on('click','.delete', function(){
		var complain_id = $(this).attr("id");
		var status  = $(this).data('status');
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"complain_action.php",
				method:"POST",
				data:{complain_id:complain_id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					branddataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});


	var branddataTable = $('#complain_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"complain_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[4, 5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

});
</script>


<?php
include 'footer.php';
?>