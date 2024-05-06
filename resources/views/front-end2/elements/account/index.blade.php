@extends('front-end.elements.account.layouts.account-layout')
@section('content')

<style type="text/css">
  .coral{background: #ff9966;background: -webkit-linear-gradient(to top, #ff5e62, #ff9966);background: linear-gradient(to top, #ff5e62, #ff9966);color: #fff;}
  .sul{
    background: #CAC531; background: -webkit-linear-gradient(to bottom, #F3F9A7, #CAC531); background: linear-gradient(to bottom, #F3F9A7, #CAC531);color: #fff;}
  .moj {
    background: #1D976C;background: -webkit-linear-gradient(to bottom, #93F9B9, #1D976C);background: linear-gradient(to bottom, #93F9B9, #1D976C);color: #fff; }
  .blu {
    background: #2193b0; background: -webkit-linear-gradient(to bottom, #6dd5ed, #2193b0); background: linear-gradient(to bottom, #6dd5ed, #2193b0);color: #fff; }
</style>



      
       <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
              <div class="col-md-12">
                <div class="">
                  <div class="x_content">
                   
</div>
</div>
</div>
</div>

<div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title" style="display: none;">
                    <h2>User Profile</small></h2>
                 
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="display: none;">
                    <br>
                    <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="first-name" required="required" class="form-control ">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Last Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="last-name" name="last-name" required="required" class="form-control">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Middle Name / Initial</label>
                        <div class="col-md-6 col-sm-6 ">
                          <input id="middle-name" class="form-control" type="text" name="middle-name">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Gender</label>
                        <div class="col-md-6 col-sm-6 ">
                          <div id="gender" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                              <input type="radio" name="gender" value="male" class="join-btn" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
                            </label>
                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                              <input type="radio" name="gender" value="female" class="join-btn" data-parsley-multiple="gender"> Female
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Date Of Birth <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input id="birthday" class="date-picker form-control" required="required" type="text">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                          <button class="btn btn-primary" type="button">Cancel</button>
              <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>



        </div>
        <!-- /page content -->

       


        @endsection
