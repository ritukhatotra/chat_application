@extends('index')
@section('content')
<section class="registation-fome-design">
    <div class="container">
        <div class="row">
            <div class="account_box bg-gradient">
				<form id="login-form" action="{{url('login')}}" method="post">					   
					@if($errors->any())
    					<p class="alert alert-danger">Invalid Login Attempt.</p>
    				@endif
				     {{csrf_field()}}
                    <h1 class="text-center">Login To Your Account</h1>
                    <div class="col-lg-12">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control trial-input" placeholder="Please enter the registation email address">
                    </div>
                    <div class="col-lg-12">
                        <label>Password</label>
                        <input type="password"  name="password" class="form-control trial-input" placeholder="Enter Password">
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-custom" >Signin</button>
                    </div>
                </form>
                <p class="text-center"><a href="{{url('reset-password')}}">Forgot Your Password?</a></p>
                <a href="{{url('register')}}"><button class="btn btn-custom">Don't Have an Account?</button></a>
            </div>
        </div>
    </div>
</section>
@endsection