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
                createdRow: function(row, data) {
                    console.log(data['l_isview']);
                    if (data['l_isview'] == 0) {
                    $(row).addClass("rowBackground");
               }
                },
                "processing": true,
                "serverSide": true,
                "responsive": false,
                order: [
                    [0, "desc"]
                ],

                "ajax": {
                    "url": "{{ route('myallcases') }}",
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

                   
                 


                ]

            });

        });
    </script>
     <script>
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location.href= '<?php echo env('APP_URL');?>/admin/case/'+id;
        

        });
    </script>

<script>
        $(document).on('click', '.seen', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Mark it seen!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        //console.log("sdsd");

                        $.ajax({
                            type: "POST",
                            url: "{{ route('markseen') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(data) {
                                if (data.success == true) {
                                    swal.close()
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
    
    @endsection