<!DOCTYPE html>
<html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
	<title>Test</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>

	{{-- Add Employee Here --}}
	<div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	        <form id="AddEmployeeFORM" action="{{route('store_data')}}" method="POST" enctype="multipart/form-data">
	      	  @csrf
		      <div class="modal-body">
		        <div class="form-group mb-3">
		        	<label for="">Name</label>
		        	<input type="text" name="name" class="form-control">
		        	 <span class="text-danger error-text name_error"></span>
		        </div>
		        <div class="form-group mb-3">
		        	<label for="">Phone</label>
		        	<input type="text" name="phone" class="form-control">
		        	<span class="text-danger error-text phone_error"></span>
		        </div>
		        <div class="form-group mb-3">
		        	<label for="">Image</label>
		        	<input type="file" name="image" class="form-control">
		        	<span class="text-danger error-text image_error"></span>

		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"  id="btnSubmit" >Save </button>
		      </div>	

		    </form>
	    </div>
	  </div>
	</div>
	{{-- End Employee Here --}}

	{{-- Edit Modal Here --}}
	<div class="modal fade" id="EditEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	        <form id="UpdateEmployeeFORM" action="" method="POST" enctype="multipart/form-data">
	      	  @csrf
		      <div class="modal-body">
		      	<input type="hidden" name="employee_id" id="employee_id">
		        <div class="form-group mb-3">
		        	<label for="">Name</label>
		        	<input type="text" name="name" id="edit_name" class="form-control">
		        	 <span class="text-danger error-text name_error"></span>
		        </div>
		        <div class="form-group mb-3">
		        	<label for="">Phone</label>
		        	<input type="text" name="phone" id="edit_phone" class="form-control">
		        	<span class="text-danger error-text phone_error"></span>
		        </div>
		        <div class="form-group mb-3">
		        	<label for="">Image</label>
		        	<input type="file" name="image" id="edit_image" class="form-control">
		        	<span class="text-danger error-text image_error"></span>

		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		        <button type="submit" class=" updatebtn btn btn-primary"  id="btnSubmit" >Update </button>
		      </div>	

		    </form>
	    </div>
	  </div>
	</div>
	{{-- End Edit Modal Here --}}

	<div class="container mt-2">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4>
							Ajax Sample
							<a href="#" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class="btn btn-primary btn-sm float-end">Add Employee</a>

						</h4>

					</div>	
					<div class="card-body">
						<div class="table-reponsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Image</th>
										{{-- <th>Edit</th> --}}
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script>
	$(document).ready(function() {

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		fetch();

		//To Get The Data
		function fetch(){
			$.ajax({
				type: "GET",
				url	: "/fetch-employee", 
				dataType: "json", 
				success: function (response){
						//console.log(response.employee);
					$('tbody').html("");
					$.each(response.employee, function(key, item) {
						 $('tbody').append('<tr>\
								<td>'+item.id+'</td>\
								<td>'+item.name+'</td>\
								<td>'+item.phone+'</td>\
								<td> <img src="upload/employee/'+item.image+'" alt="image" width="50px" height="50px"></td>\
								<td><button type="button" value="'+item.id+'" class="edit_btn btn btn-success btn-sm">Edit</button>\
								<button type="button" value="'+item.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
							</tr>');
					});
				}
			})
		}


	//To edit value
	$(document).on('click', '.edit_btn', function(e) {
	
			e.preventDefault();

			var employee_id = $(this).val();

			$('#EditEmployeeModal').modal('show');

				$.ajax({
					type: "GET",
					url: "/edit-employee/"+employee_id,
					success: function(response){

						if(response.status == 404){

								alert(response.msg);
								$('#EditEmployeeModal').modal('hide');
						}
						else{
								$('#employee_id').val(employee_id);
							  $('#edit_name').val(response.employee.name);
							  $('#edit_phone').val(response.employee.phone);
							  // $('#edit_image').val(response.employee.image);
							  
						}
					}	
				});
			
		});

	$('#UpdateEmployeeFORM').on('submit', function(e) {
	
			e.preventDefault();
			$(".updatebtn").text('Updating. . .');
			 var id = $('#employee_id').val();
			// let EditformData = new FormData($('#UpdateEmployeeFORM')[0]);
       var form = this;
			 $('.updatebtn').attr("disabled", true);

				$.ajax({
				type: "POST",
				url: "/update-employee/"+id,
				data:  new FormData(form),
				processData: false,
        contentType: false,
				beforeSend: function () {

           $(form).find('span.error-text').text('');
         },
				success: function (response){
				
					if(response.status == 400){

						$('.updatebtn').removeAttr("disabled");
            $.each(response.error, function (prefix, val) {
                $(form).find('span.' + prefix + '_error').text(val[0]);
            });
            $('.updatebtn').text('Update');
					}
					else if(response.status == 404){
						 
						 alert(response.status.msg);
					}
					else{

					  	$(form)[0].reset();
              $('#EditEmployeeModal').modal('hide');
              $('.updatebtn').removeAttr("disabled");
              $('.updatebtn').text('Update');
              fetch();
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Login successfully recorded',
                  showConfirmButton: false,
                  timer: 4000,
            })
					}
					
				}
			
		});
	});




	 // Create A User
	$('#AddEmployeeFORM').on('submit',function(e) {
			e.preventDefault();
			
			 $("#btnSubmit").text('Sending..');
			//let formData = new FormData($('#AddEmployeeFORM')[0]);
			 var form = this;
			 $('#btnSubmit').attr("disabled", true);
			$.ajax({
				type: "POST",
				url: $(form).attr('action'),
				data:  new FormData(form),
				processData: false,
        dataType: 'json',
        contentType: false,
				 beforeSend: function () {

            $(form).find('span.error-text').text('');
         },
				success: function (data){
				
					if(data.code == 0){
	                    // $('#btnSubmit').removeAttr("disabled");
	                    $('#btnSubmit').removeAttr("disabled");
	                    $.each(data.error, function (prefix, val) {
	                        $(form).find('span.' + prefix + '_error').text(val[0]);
	                    });
	                     $('#btnSubmit').text('Send');
	                }
	                else if(data.code == 1){
	                	 
	                    $(form)[0].reset();
	                    $('#AddEmployeeModal').modal('hide');
	                    $('#btnSubmit').removeAttr("disabled");
	                    $('#btnSubmit').text('Send');
	                    fetch();
	                    Swal.fire({
	                        icon: 'success',
	                        title: 'Success',
	                        text: 'Login successfully recorded',
	                        showConfirmButton: false,
	                        timer: 4000,
                    })
                }
				}
			});
		});
	});
</script>

</html>

