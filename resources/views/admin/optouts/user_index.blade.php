@extends('admin-layouts.adminapp')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@section('content')
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">Dashboard</h1>
            <div class="row gy-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-account shadow-sm p-3">

                        <div class="dt-buttons btn-group flex-wrap">
                            <a href="{{route('export')}}" style="margin-bottom:30px" class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="example"><span>Excel</span>
                            </a>
                        </div>
                        <table id="optouts" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fax</th>
                                    <th>Phone</th>
                                    <th>IP Address</th>
                                    <th>Date & Time</th>
                                  
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
                    "url": "{{ route('admin_getoptouts') }}",
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
                        "data": "ufax",
                        orderable: false
                    },
                    {
                        "data": "uphone",
                        orderable: false
                    },
                    {
                        "data": "ip_address",
                        orderable: false
                    },
                    {
                        "data": "date",
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
                            url: "{{ route('admin_delete_optouts') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(data) {
                                if (data.success == true) {
                                    swal(data.message, "", "success");
                                    parent.fadeOut('slow', function() {
                                        $(this).remove();
                                    });

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
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: "get",
                dataType: 'JSON',
                url: "{{ route('getOptout') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.success == true) {
                      console.log(data.data)
                      $("#fax_number").val(data.data.ufax);
                      $("#phone").val(data.data.uphone);
                      $("#ip").val(data.data.ip_address);
                      $("#optid").val(data.data.id);
                     $("#editModal").modal('show');


                    } else {
                        swal(data.message, "", "error");
                    }

                }
            }); // submitting the form when user press yes

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
                            url: "{{ route('admin_delete_optouts') }}",
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
    @endsection