<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{$title}}</title>
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{asset('public/css/style.css')}}">
		<link rel="stylesheet" href="{{asset('public/css/animate.min.css')}}">
		<link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}">
	</head>
	<body>  
		<header>			
			<div class="bottom-header">
				<div class="container">
					<div class="mobile-logo">
					<a href="javascript:void(0)">
					   Chat Application
					</a>
				</div>
				<nav class="navbar navbar-default">
					<div class="navbar-header">
						<div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
							<button data-target=".js-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="collapse navbar-collapse js-navbar-collapse">
							<div class="logo-new">
								<a href="javascript:void(0)">
								   Chat Application
								</a>
							</div>
						</div>
					</div>
				</nav>				
			</div>
		</header>
		@yield('content')
		<footer>    	
			<div class="bottom-footer">
				<p><strong>Copyright by</strong> &copy; {{date('Y')}}. All rights reserved. </p>
			</div>
		</footer>
	</body>   
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('public/js/bootstrap.min.js')}}"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script src="{{asset('public/js/custom.js')}}"></script>
</html>