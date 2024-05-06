@extends('front-end.layouts.front-layout') 
@section('content')

    <div class="login-wrapper row mx-0">
      <div class="login-sec shadow">
        <h3 class="mb-5"> {{ __('Please login to continue') }} </h3>
         @if(session('status'))
         <h5 class="mb-5" style="text-align: center;color: green;"> {{session('status')}} </h5>
         @endif
         @if (count($errors) > 0)
  @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
  @endforeach
@endif

@if (session()->has('message'))
  <p class="alert alert-success">{{ session('message') }}</p>
@endif
        <form action="{{route('user.login')}}" method="POST" id="login-form1">
          @csrf
          <div class="form-group">
            <label for="InputMobile"> {{ __('Mobile Number') }} </label>
            <input type="text" class="form-control" id="InputMobile" placeholder="{{__('Enter Your')}} {{__('Mobile Number')}}" name="cust_mobile" required>
             @error('cust_mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
          </div>
          <div class="form-group">
            <label for="InputPassword"> {{ __('Password') }} </label>
            <input type="password" class="form-control" id="InputPassword" placeholder="{{__('Enter Your')}} {{__('Password')}}" name="password" required>
             @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
             <small class="d-block text-right py-2"><a href="{{route('customer.reset.password')}}">{{ __('Forgot Password?') }}</a></small> 
          </div>
          
          <button type="submit" class="btn btn-warning btn-lg btn-block mx-auto text-white">{{ __('Login') }}</button>
        </form>

      </div>

      <div class="login-sec reg-sec">
        <h3 class="mb-5">{{ __('New customer?') }}</h3>
        
        <a class="btn btn-light btn-lg btn-block mx-auto" href="{{route('user.register')}}">{{ __('Create Account') }}</a>
        
        <div class="mt-4 why-reg row mx-0">
          <i class="fa fa-clock-o" aria-hidden="true"></i>
          <p>
            {{__('Save Time')}}
            <small>{{__('Fastest pick up and drop off car rental')}}</small>
          </p>
        </div>

        <div class="mt-4 why-reg row mx-0">
          <i class="fa fa-cog" aria-hidden="true"></i>
          <p>
            {{__('Manage Your Car Rental')}}
            <small>{{__('Booking and reserving cars are even more faster to manage')}}</small>
          </p>
        </div>

        <div class="mt-4 why-reg row mx-0">
          <i class="fa fa-user" aria-hidden="true"></i>
          <p>
            {{__('Access Your Account')}}
            <small>{{__('Anytime and wherever you are')}}</small>
          </p>
        </div>

      </div>

    </div>


@endsection