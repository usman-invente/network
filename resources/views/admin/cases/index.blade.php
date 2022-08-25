@extends('admin-layouts.adminapp')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>

@section('content')
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">Cases</h1>
            <div class="row gy-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-account shadow-sm p-3">

                        <div class="dt-buttons btn-group flex-wrap">

                        </div>
                        <table id="optouts" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Practice</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                    <th>Decline</th>
                                    <th>Assgin</th>
                                    <th>Assgin to user</th>
                                    <!-- <th>Notes</th> -->
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
                    "url": "{{ route('admin_case') }}",
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
                        "data": "practice",
                        orderable: false
                    },
                    {
                        "data": "name",
                        orderable: false
                    },
                    {
                        "data": "email",
                        orderable: false
                    },
                    {
                        "data": "phone",
                        orderable: false
                    },

                    {
                        "data": "address",
                        orderable: false
                    },

                    {
                        "data": "options",
                        orderable: false
                    },

                    {
                        "data": "decline",
                        orderable: false
                    },
                    {
                        "data": "assign",
                        orderable: false
                    },
                    {
                        "data": "assigntouser",
                        orderable: false
                    },
                    
                    // {
                    //     "data": "note",
                    //     orderable: false
                    // },


                ]

            });

        });
    </script>
    <script>
        $(document).on('click', '.email', function(e) {
            swal('Sending Email...', "Please Wait", "info");
            e.preventDefault();
            var id = $(this).data('id');
            var email = $(this).data('email');
            $tr = $(this).closest("tr");

            $.ajax({
                type: "POST",
                url: "{{ route('admin_sendemail') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    id: id,
                    email: email
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

        });
    </script>

    <script>
        $(document).on('click', '.assignhimself', function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            $tr = $(this).closest("tr");

            $.ajax({
                type: "POST",
                url: "{{ route('assignhimself') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    id: id,

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

        });
    </script>

    <script>
        $(document).on('click', '.assigntouser', function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            $tr = $(this).closest("tr");

            $.ajax({
                type: "POST",
                url: "{{ route('assigntouser') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    id: id,

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

        });
    </script>



    <script>
        $(document).on('focusout', '.comment', function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var val = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{ route('updatecomment') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    id: id,
                    val: val

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

        });
    </script>


    <script>
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location.href = '<?php echo env('APP_URL'); ?>/admin/case/edit/' + id;


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
                            url: "{{ route('deletecase') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(data) {
                                if (data.success == true) {
                                    swal(data.message, "", "success");
                                    $tr.remove();

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
           
            var user = val.value;
            var practice = $(val).attr("data-id");
          
            swal('', "Request is processing.Please wait...", "info");
            $.ajax({
                type: "post",
                url: "{{route('assigntouser')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    practice: practice,
                    user: user
                },
                success: function(data) {
                     if(data.success == true){
                        swal('', data.message, "success");
                        $("#optouts").dataTable().fnDraw();
                     }
                  
                }
            });
        }
    </script>
    @endsection