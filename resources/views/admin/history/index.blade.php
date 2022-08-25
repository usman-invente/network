@extends('admin-layouts.adminapp')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@section('content')
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">History</h1>
            <div class="row gy-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-account shadow-sm p-3">
                        <div class="dt-buttons btn-group flex-wrap">
                            <a href="{{route('historyexport')}}" style="margin-bottom:30px" class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="example"><span>Excel</span>
                            </a>
                        </div>
                        <table id="optouts" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Date Downloaded</th>
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
    <script>
        $(document).ready(function() {
            $('#optouts').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": false,
                order: [
                    [0, "desc"]
                ],

                "ajax": {
                    "url": "{{ route('admin_gethistory') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "id",
                        orderable: false
                    },
                    {
                        "data": "name",
                        orderable: false
                    },
                    {
                        "data": "date",
                        orderable: false
                    },
                    {
                        "data": "options",
                        orderable: false
                    },




                ]

            });

        });
    </script>
    <script>
        $(document).on('click', '.delete', function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            $tr = $(this).closest("tr");


            swal({
                    title: "Are you sure?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        //console.log("sdsd");

                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin_delete_history') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(data) {
                                if (data.success == true) {
                                    swal(data.message, "", "success");
                                    $("#optouts").dataTable().fnDraw();

                                } else {
                                    swal(data.message, "", "error");
                                }

                            }
                        }); // submitting the form when user press yes
                    } else {
                        swal("Cancelled", "Your record  is safe :)", "info");
                    }
                });

        });
    </script>
    <script>
        function functionstatus(val) {
            // alert(val);
            var status = val.value;
            var id = $(val).attr("data-id");
            if (status == "") {
                return false;
            }
            $.ajax({
                type: "post",
                url: "{{route('user_status')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    id: id,
                    status: status
                },
                success: function(data) {
                    window.location = '{{ route('admin_users') }}'


                }
            });
        }
    </script>
    @endsection