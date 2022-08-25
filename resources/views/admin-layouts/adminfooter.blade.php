<footer class="app-footer">
	<div class="container text-center py-3">
		<small class="copyright">Designed with <span class="sr-only">love</span>
			<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fb866a" stroke="fb866a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
				<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
			</svg>
		</small>
	</div>
</footer>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Record </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label>Fax Number</label>
						<input type="text" id="fax_number" class="form-control" value="  ">
						<label>Phone</label>
						<input type="text" id="phone" class="form-control" value=" ">
						<label>Ip Address</label>
						<input type="text" id="ip" class="form-control" value=" ">
						<input type="hidden" id="optid" class="form-control" value=" ">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary updaterecord">Update Record</button>
			</div>
		</div>
	</div>
</div>
<!-- Edit Modal Start -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update User </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" id="name" value="  ">
						<label>Email</label>
						<input type="email" class="form-control" id="email" value=" ">
						<div class="mb-3">
							<label for="" class="form-label">Role</label>
							<select class="form-control" name="" id="role">
								<option value="1" selected>Admin</option>
								<option  value="2">User</option>
							</select>
						</div>
						<input type="hidden" class="form-control" id="userid" value=" ">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary updateuser">Update User</button>
			</div>
		</div>
	</div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="{{asset('public/assets/js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{asset('public/assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/css/custom.css')}}">

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({
			lengthChange: false,
			buttons: ['excel']
		});

		table.buttons().container()
			.appendTo('#example_wrapper .col-md-6:eq(0)');
	});
</script>

<script>
	$(document).on('click', '.updaterecord', function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "{{ route('admin_update_optouts') }}",
			data: {
				'_token': "{{ csrf_token() }}",
				id: $("#optid").val(),
				ip: $("#ip").val(),
				phone: $("#phone").val(),
				fax: $("#fax_number").val(),
			},
			success: function(data) {
				if (data.success == true) {
					$("#optouts").dataTable().fnDraw();
					swal(data.message, "", "success");
					$("#editModal").modal('hide');

				} else {
					swal(data.message, "", "error");
				}

			}
		}); // submitting the form when user press yes

	});
</script>

<script>
	$(document).on('click', '.updateuser', function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "{{ route('admin_update_user') }}",
			data: {
				'_token': "{{ csrf_token() }}",
				id: $("#userid").val(),
				name: $("#name").val(),
				email: $("#email").val(),
				role: $("#role").val(),
			},
			success: function(data) {
				if (data.success == true) {
					$("#users").dataTable().fnDraw();
					swal(data.message, "", "success");
					$("#editUser").modal('hide');

				} else {
					swal(data.message, "", "error");
				}

			}
		}); // submitting the form when user press yes

	});
</script>
</body>

</html>