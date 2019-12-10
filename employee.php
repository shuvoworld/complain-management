<?php
//employee.php

include 'database_connection.php';

if (!isset($_SESSION['type'])) {
	header('location:login.php');
}

if ($_SESSION['type'] != 'master') {
	header("location:index.php");
}

include 'header.php';

?>

	<span id="alert_employee_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">Employee List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#employeeModal" class="btn btn-success">Add</button>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
                    		<table id="data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Employee Name</th>
									<th>Phone</th>
									<th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="employeeModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Employee</h4>
    				</div>
    				<div class="modal-body">
    					<label>Employee Name</label>
						<input type="text" name="name" id="name" class="form-control" required />
						<label>Employee Phone No</label>
						<input type="text" name="contact_no" id="contact_no" class="form-control" required />
						<label>Employee Email</label>
						<input type="text" name="email" id="email" class="form-control" required />
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="id" id="id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
    					<input type="submit" name="employee_action" id="employee_action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add employee");
		$('#employee_action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#form', function(event){
		event.preventDefault();
		$('#employee_action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"employee_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#form')[0].reset();
				$('#employeeModal').modal('hide');
				$('#alert_employee_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#employee_action').attr('disabled', false);
				employeedataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var id = $(this).attr("id");
		var btn_action = 'employee_fetch_single';
		$.ajax({
			url:"employee_action.php",
			method:"POST",
			data:{id:id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#employeeModal').modal('show');
				$('#name').val(data.name);
				$('#contact_no').val(data.contact_no);
				$('#email').val(data.email);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit employee");
				$('#id').val(id);
				$('#employee_action').val('Edit');
				$('#btn_action').val("Edit");
			}
		})
	});

	var employeedataTable = $('#data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"employee_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[4, 5],
				"orderable":false,
			},
		],
		"pageLength": 25
	});
	$(document).on('click', '.delete', function(){
		var id = $(this).attr('id');
		var status = $(this).data("status");
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"employee_action.php",
				method:"POST",
				data:{id:id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_employee_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					employeedataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});
});
</script>

<?php
include 'footer.php';
?>


