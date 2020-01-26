<?php
include 'database_connection.php';
include 'function.php';

if (!isset($_SESSION['type'])) {
	header('location:login.php');
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
                			<button type="button" name="add" id="add_button" class="btn btn-success">Add Complain</button>
                		</div>
                		<div class="col-md-2">
                			<select id="searchByStatus" class="form-control">
					           <option value=''>-- Select Status--</option>
					           <option value='Pending'>Pending</option>
					           <option value='Solved'>Solved</option>
         					</select>
                		</div>
                	</div>
                </div>
                <div class="panel-body">
                	<table id="complain_data" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>Subject</th>
								<th>User Name</th>
								<th>User Phone</th>
								<th>Assigned Employee</th>
								<th>Date</th>
								<th>Status</th>
								<th>Edit</th>
								<th>Delete</th>
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
								<option value="">Select Complain Category</option>
								<?php echo fill_category_list($connect); ?>
							</select>
    					</div>
    					<div class="form-group">
							<label>Enter Complain Subject</label>
							<?php //echo getSingleValue($connect, 'category_name', 'category', 'category_id', 4);?>
							<input type="text" name="subject" id="subject" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Complain Description</label>
							<textarea class="md-textarea form-control editor" id="description" name="description" rows="4" cols="50">
							</textarea>
						</div>

						<div class="form-group">
							<label>Emergency Contact to talk with</label>
							<input type="text" name="contact_no" id="contact_no" class="form-control" required />
						</div>
						<?php if ($_SESSION["type"] == 'master' || $_SESSION['type'] == 'employee') {?>
						<div class="form-group">
						<select name="employee_id" id="employee_id" class="form-control">
							<option value="">Assign A Staff</option>
							<?php echo getDrodownFromTable('employee', $connect); ?>
						</select>
						</div>
						<?php }?>

						<?php if ($_SESSION["type"] == 'master' || $_SESSION['type'] == 'employee') {?>
						<?php $status = array("" => "Select Complain Status", "Pending" => "Pending", "Solved" => "Solved");?>
						<div class="form-group">
						<select name="status" id="status" class="form-control">
							<?php echo getDropdownFromArray($status); ?>
						</select>
						</div>
						<?php }?>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="id" id="id" />
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
				$('#complain_data').DataTable().ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var id = $(this).attr("id");
		var btn_action = 'fetch_single_complain';
		$.ajax({
			url:'complain_action.php',
			method:"POST",
			data:{id:id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#complainModal').modal('show');
				$('#category_id').val(data.category_id).trigger('change');
				$('#complain_name').val(data.complain_name);
				$('#subject').val(data.subject);
				$('#description').val(data.description);
				$('#contact_no').val(data.contact_no);
				$('#status').val(data.status);
				$('#employee_id').val(data.employee_id);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Complain");
				$('#id').val(id);
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
					complaindataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});


});

$(document).ready(function(){
   $('#complain_data').DataTable({
      'processing': true,
      'serverSide': true,
      "orderMulti": true,
      "order": [[ 6, "asc" ], [ 5, "asc"]],
      'serverMethod': 'post',
      'ajax': {
          'url':'complain_fetch.php',
           'data': function(data){
          		var searchByStatus = $('#searchByStatus').val(); // Read values
          		data.searchByStatus = searchByStatus;                   // Append to data
       		}
      },
      dom: 'Bfrtip',
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o" style="color: red"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o" style="color: blue"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o" style="color: orange"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o" style="color: black"></i>',
                titleAttr: 'PDF'
            }
        ]
   });

     $('#searchByStatus').change(function(){
     $('#complain_data').DataTable().draw();
  });
});

</script>


<?php
include 'footer.php';
?>
