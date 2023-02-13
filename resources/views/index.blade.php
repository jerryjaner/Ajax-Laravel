<!DOCTYPE html>
<html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
	<title>Test</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>
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
										<th>Edit</th>
										<th>Delete</th>
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
	// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>

<script>
	$(document).ready(function() {

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		fetch();

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
								<td><button type="button" value="'+item.id+'" class="edit_btn btn btn-success btn-sm">Edit</button></td>\
								<td><button type="button" value="'+item.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
							</tr>');
					});
				}

			})
		}


	 // Create A User
		$('#AddEmployeeFORM').on('submit',function(e) {
			e.preventDefault();

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
				// contentType: false,
				// processType: false,
				//dataType: "json",
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
	                }
	                else if(data.code == 1){
	                	 
	                    $(form)[0].reset();
	                    $('#AddEmployeeModal').modal('hide');
	                    $('#btnSubmit').removeAttr("disabled");
	                    fetch();

	                    Swal.fire({
	                        icon: 'success',
	                        title: 'Success',
	                        text: 'Login successfully recorded',
	                        showConfirmButton: false,
	                        timer: 2000
                    })
                }
				}

			});
		});
	});
</script>

</html>