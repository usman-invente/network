@extends('admin-layouts.adminapp')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@section('content')
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">Edit Case</h1>
            <div class="row gy-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-account shadow-sm p-3">


                        @if(session()->has('message'))
                        <div style="font-weight:700;background:#D1E7DD;border-radius: 10px;">
                            <p style="font-weight:700;padding: 19px;"> {{session()->get('message')}}</p>
                        </div>

                        @endif
                        <form action="{{route('updateCase')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$case->id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Join Our Network</h3>
                                    <p>Please complete the form and a member of our Network Development team will follow up to answer questions. If you'd like to proceed, we'll initiate the creation of a Participation Agreement as well as start the Credentialing process.</p>

                                </div>
                                <div class="col-md-12">
                                    <label>Please select your specialty</label><br><br>
                                    <input type="radio" name="practice" value="Dermatology" {{ ($case->practice=="Dermatology")? "checked" : "" }}> Dermatology
                                    <input type="radio" name="practice" value="Gastroenterology" {{ ($case->practice=="Gastroenterology")? "checked" : "" }}> Gastroenterology
                                    <input type="radio" name="practice" value="Podiatry" {{ ($case->practice=="Podiatry")? "checked" : "" }}> Podiatry
                                    <input type="radio" name="practice" value="Urology" {{ ($case->practice=="Urology")? "checked" : "" }}> Urology
                                    <input type="radio" name="practice" value="Other" {{ ($case->practice=="Other")? "checked" : "" }}> Other

                                </div>

                                <div id="otherfield" style="margin-top:30px;display:none;margin-bottom:30px">

                                    <div class="col-md-6">
                                        <label style="color:#222">To better serve you, please specify your specialty</label><br>
                                        <div class="form-group">
                                            <input type="text" name="other"  value="{{$case->other}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-6">
                                    <label style="color:#222">Name of Practice</label><br>
                                    <div class="form-group">
                                        <input type="text" name="name" value="{{$case->name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Contact Person</label><br>
                                    <div class="form-group">
                                        <input type="text" name="contact" value="{{$case->contact}}" class="form-control">
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-6">
                                    <label>NPI</label><br>
                                    <div class="form-group">
                                        <input type="text" name="npi" value="{{$case->npi}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>TIN</label><br>
                                    <div class="form-group">
                                        <input type="text" name="tin" value="{{$case->tin}}" class="form-control">
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-6">
                                    <label>Email</label><br>
                                    <div class="form-group">
                                        <input type="text" name="email" value="{{$case->email}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Verify Email</label><br>
                                    <div class="form-group">
                                        <input type="text" name="" class="form-control">
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-6">
                                    <label>Phone</label><br>
                                    <div class="form-group">
                                        <input type="text" name="phone" value="{{$case->phone}}" class="form-control">
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-6">
                                    <label>Fax</label><br>
                                    <div class="form-group">
                                        <input type="text" name="fax" value="{{$case->fax}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Address</label><br>
                                    <div class="form-group">
                                        <input type="text" name="address" value="{{$case->address}}" class="form-control">
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-6">
                                    <label>Address2</label><br>
                                    <div class="form-group">
                                        <input type="text" name="address2" value="{{$case->address2}}" class="form-control">
                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>City</label><br>
                                            <div class="form-group">
                                                <input type="text" name="city" value="{{$case->city}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>State</label><br>
                                            <div class="form-group">
                                                <input type="text" name="state" value="{{$case->state}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Zip</label><br>
                                            <div class="form-group">
                                                <input type="text" name="zip" value="{{$case->zip}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Country</label><br>
                                            <div class="form-group">
                                                <input type="text" name="county" value="{{$case->county}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-12">
                                    <label>Line of Business (Select all that apply)</label><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                     

                                            <div class="form-group">
                                           
                                            
                                                <input type="checkbox" name="bussiness_line[]"  value="Medicaid" @foreach ($bussiness_line as $line) @if($line== "Medicaid") checked @endif @endforeach > Medicaid
                                                <input type="checkbox" name="bussiness_line[]" value="Medicare" @foreach ($bussiness_line as $line) @if($line== "Medicare") checked @endif @endforeach> Medicare
                                         
                                                
                                            </div>
                                        </div>




                                    </div>
                                </div>
                                <br><br><br><br>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Minimum Age Seen</label><br>
                                            <div class="form-group">
                                                <input type="text" name="min_age_seen" value="{{$case->min_age_seen}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Maximum Age Seen</label><br>
                                            <div class="form-group">
                                                <input type="text" name="max_age_seen" value="{{$case->max_age_seen}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br><br><br>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Which health plan(s) would you like to join?</label><br>
                                            <div class="form-group">
                                                <input type="text" name="health_plan" value="{{$case->health_plan}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <br><br><br><br>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Comments</label><br>

                                            <textarea name="comments" cols="200" class="form-control">{{$case->comments}}</textarea>

                                        </div>

                                    </div>
                                </div>
                                <br><br><br><br>

                                <div class="col-md-12">
                                    <input type="submit" value="submit" class="btn  btn-secondary buttons-excel buttons-html5">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var val = $("input[type=radio][name='practice']:checked").val()
            if (val == "Other") {
                $("#otherfield").show();
            } else {
                $("#otherfield").hide();
            }
        });
    </script>

    @endsection