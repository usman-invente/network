@extends('admin-layouts.adminapp')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@section('content')
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">Case Detail</h1>
            <div class="row gy-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-account shadow-sm p-3">

                        <div class="row">
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;">Name of Practice</label><br>
                                {{$case->practice}}
                            </div>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;" >Contact Person</label><br>
                                {{$case->contact}}
                            </div>
                            <br><br><br><br>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;" >NPI</label><br>
                                {{$case->npi}}
                            </div>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;" >TIN</label><br>
                                {{$case->tin}}
                            </div>
                            <br><br><br><br>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;" >Email</label><br>
                                {{$case->email}}
                            </div>

                          
                            <br><br><br><br>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;">Phone</label><br>
                                {{$case->phone}}
                            </div>
                            <br><br><br><br>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;">Fax</label><br>
                                {{$case->fax}}
                            </div>

                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;" >Address</label><br>
                                {{$case->address}}
                            </div>
                            <br><br><br><br>
                            <div class="col-md-6">
                                <label style="color:#222;font-weight: 700;" >Address2</label><br>
                                {{$case->address2}}
                            </div>
                            <br><br><br><br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label style="color:#222;font-weight: 700;">City</label><br>
                                        {{$case->city}}
                                    </div>
                                    <div class="col-md-3">
                                        <label style="color:#222;font-weight: 700;">State</label><br>
                                        {{$case->state}}
                                    </div>

                                    <div class="col-md-3">
                                        <label style="color:#222;font-weight: 700;" >Zip</label><br>
                                        {{$case->zip}}
                                    </div>
                                    <div class="col-md-3">
                                        <label style="color:#222;font-weight: 700;" >Country</label><br>
                                        {{$case->country}}
                                    </div>

                                </div>
                            </div>
                            <br><br><br><br>
                            <div class="col-md-12">
                                <label style="color:#222;font-weight: 700;">Line of Business (Select all that apply)</label><br>
                                {{$case->bussiness_line}}
                            </div>
                            <br><br><br><br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label style="color:#222;font-weight: 700;" >Minimum Age Seen</label><br>
                                        {{$case->min_age_seen}}
                                    </div>
                                    <div class="col-md-6">
                                        <label style="color:#222;font-weight: 700;">Maximum Age Seen</label><br>
                                        {{$case->max_age_seen}}
                                    </div>
                                </div>
                            </div>
                            <br><br><br><br>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="color:#222;font-weight: 700;">Which health plan(s) would you like to join?</label><br>
                                        {{$case->health_plan}}
                                    </div>

                                </div>
                            </div>
                            <br><br><br><br>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="color:#222;font-weight: 700;">Comments</label><br>

                                        {{$case->comments}}

                                    </div>

                                </div>
                            </div>
                            <br><br><br><br>

                          
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



    @endsection