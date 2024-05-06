@extends('admin.layouts.app')
@section('content')
    @php
    header('Content-Type: text/html; charset=utf-8');
    @endphp
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <div class="row" style="min-height: 70vh;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title">{{ $pageTitle }}</h3>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger" id="err_msg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}<button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success" id="err_msg">
                        <p>{{ session('status') }}<button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">×</button></p>
                    </div>
                @endif
                <form >
                    @csrf
                    <input type="hidden" name="faq_id" value="{{ $viewRes->faq_id}}">
                    <div class="card-body">
                        <div class="row">
                         
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Customer Name') }}</label>
                                    <input type="text" id="	cust_fname" name="	cust_fname" readonly placeholder="Customer Name"
                                        class="form-control" value="{{ $viewRes->cust_fname }} {{($viewRes->cust_lname)}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Mobile Number') }}</label>
                                    <input type="text" id="cust_mobile_code" name="cust_mobile_code" readonly placeholder="Mobile Number"
                                        class="form-control" value="{{ $viewRes->cust_mobile_code }}{{ $viewRes->cust_mobile_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Email') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Email"
                                        class="form-control" value="{{ $viewRes->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('DOB') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Email"
                                        class="form-control" value="{{ $viewRes->cust_dob }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Qatar Id') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Qatar Id"
                                        class="form-control" value="{{ $viewRes->cust_qatar_id }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Passport Number') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Passport Number"
                                        class="form-control" value="{{ $viewRes->cust_passport_number }}">
                                </div>
                            </div>
                            @php
                           // dd($viewRes->cust_city);
                            $city=DB::table('cities')->where('city_id',$viewRes->cust_city)->first();
                            $location=DB::table('city_locations')->where('city_loc_id',$viewRes->cust_state)->first();
                            
                            @endphp
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('City') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="City"
                                        class="form-control" value="@if($city){{ @$city->city_name }}@else Not Given @endif">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Location') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Location"
                                        class="form-control" value="@if($location){{ $location->location_name }} @else Not Given @endif">
                                </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Driving License Number') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Driving License Number"
                                        class="form-control" value="{{@$viewRes->cust_driving_license_no}}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Driving License Issue Date') }}</label>
                                    <input type="text" id="email" name="email" readonly placeholder="Driving License Issued Date"
                                        class="form-control" value="{{@$viewRes->cust_license_issued_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Driving License Issue Country') }}</label>
                                     @php
                                 $lic_country=DB::table('countries')->where('country_id',$viewRes->cust_license_issued_country)->first();
                                 
                                @endphp
                                
                                    <input type="text" id="email" name="email" readonly placeholder="Driving License Issued Date"
                                        class="form-control" value="@if($lic_country!=NULL){{@$lic_country->country_name}} @else Not Specified @endif">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Address Line 1') }}</label>
                                   <textarea  readonly placeholder="Address line  1"
                                        class="form-control">{{ @$viewRes->cust_address_line_1 }}</textarea>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Address Line 2') }}</label>
                                   <textarea  readonly placeholder="Address line 2"
                                        class="form-control">{{ @$viewRes->cust_address_line_2 }}</textarea>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Nationality') }}</label>
                                   
                                     @php
                                 $nation=DB::table('countries')->where('country_id',$viewRes->cust_nationality)->first();
                                @endphp
                                
                                  
                                    <input type="text" id="email" name="email" readonly placeholder="NATIONALITY"
                                        class="form-control" value="{{@$nation->country_name}}">
                                </div>
                            </div>
                             <div class="col-md-6">
                              <div class="form-group">
                                  <label class="form-label">{{ __('Status') }}</label>
                                  @if($viewRes->cust_profile_status==1)
                                  <input type="text" readonly placeholder="Status"
                                      class="form-control" value="Active">
                                      @else
                                      <input type="text"  readonly placeholder="Status"
                                      class="form-control" value="Inactive">
                                      @endif

                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('OTP') }}</label>
                                @if($viewRes->cust_otp_verify==1)
                                <input type="text"  readonly placeholder="OTP"
                                    class="form-control" value="Verified">
                                    @else
                                    <input type="text" readonly placeholder="OTP"
                                    class="form-control" value="Not Verified">
                                    @endif

                            </div>
                        </div>
                        
                        </div>
                    </div>
                    <center>
                      <button type="button" class="btn btn-cyan" onclick="history.back()">Cancel</button>
                      </center>
                      </br>

            </div>
            </form>
        </div>
    </div>
    </div>
@endsection