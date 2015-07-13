<!-- Template -->
@extends('admin.layouts.main')

<!-- Page Title -->
@section('title','Page Title')

<!-- Link -->
@section('link')
    @parent

@endsection

<!-- Content Area -->
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-info">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/administrator/login/post') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<div class="col-md-12">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary submit">Login</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Script -->
@section('script')
    @parent
    <script>
        $('.submit').on('click', function (e) {
            
            /* Load Spinner */
            $('.submit').html('<i class="fa fa-cog fa-spin"></i>');
            $('.submit').attr('disabled','true');
            
            e.preventDefault();
            
            var email = $('[name=email]').val();
            var password = $('[name=password]').val();
            var _token = $('[name=_token]').val();
            
            $.post('/administrator/login', {_token : _token, email : email, password : password}, function () {
            
            }).done(function (response) {
                console.log(response);
                
                /* Remove Spinner */
                $('.submit').html('Register');
                $('.submit').removeAttr('disabled');
                
                if (response.status == 'success') {
                    /* Show message */
                    $('.panel-body').prepend('<div class="alert alert-success">You have login successfully!</div>');
                    
                    /* Redirect after 3 seconds */
                        setTimeout( function () {
                            window.location = '/administrator/dashboard'
                        }, 3000);
                } else {
                    /* Show message */
                    $('.panel-body').prepend('<div class="alert alert-danger">Incorrect credentials!</div>');
                }
                
            }).fail(function (response) {
                console.log(response);
                
                /* Remove Spinner */
                $('.submit').html('Register');
                $('.submit').removeAttr('disabled');
            });
        });    
    </script>
@endsection