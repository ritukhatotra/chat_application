@extends('index')
@section('content')
<section class="registation-fome-design">
    <div class="container">
        <div class="row">
            <div class="account_box bg-gradient">
				<form id="reg-form" action="{{url('register')}}" method="post">	
					@if($errors->any())
    					<p class="alert alert-danger">Registration Failed</p>
    				@endif
				     {{csrf_field()}}
                    <h1 class="text-center">Create Account</h1>
                    <div class="col-lg-6">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control trial-input" placeholder="First Name">
                    </div>
                    <div class="col-lg-6">
                       <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control trial-input" placeholder="Last Name">
                    </div>
                    <div class="col-lg-12">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control trial-input" placeholder="Email">
                        <p id="error-email" class="error"></p>
                    </div>
                    <div class="col-lg-12">
                        <label>Password</label>
                        <input type="password" id="password"  name="password" class="form-control trial-input" placeholder="Enter Password">
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-custom" >Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection