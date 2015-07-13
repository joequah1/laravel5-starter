@extends('user.layouts.main')

@section('link')
    @parent
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
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

					<form id="registration-form" class="form-horizontal" role="form" method="POST" action="{{ url('/registration') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary submit">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('/user/js/jquery.validate.min.js') }}"></script>

    <script>
        
        $('#registration-form').validate({
            rules : {
                name : {
                    required : true
                },
                email : {
                    required : true,
                    email : true
                },
                password : {
                    required : true,
                    minlength: 6,
                    maxlength: 16
                },
                password_confirmation : {
                    required : true,
                    equalTo : '[name=password]'
                }
            },
            submitHandler : function (form) {
                /* Load Spinner */
                $('.submit').html('<i class="fa fa-cog fa-spin"></i>');
                $('.submit').attr('disabled','true');
                
                var name = $('[name=name]').val();
                var email = $('[name=email]').val();
                var password = $('[name=password]').val();
                var password_confirmation = $('[name=password_confirmation]').val();
                var _token = $('[name=_token]').val();

                $.post('/registration', {_token : _token, name : name, email : email, password : password, password_confirmation : password_confirmation}, function () {

                }).done(function (response) {
                    console.log(response);

                    /* Remove Spinner */
                    $('.submit').html('Register');
                    $('.submit').removeAttr('disabled');
                    
                    if (response.status == 'success') {
                        /* Show message */
                        $('.panel-body').prepend('<div class="alert alert-success">You have registered successfully!</div>');

                        /* Redirect after 3 seconds */
                        setTimeout( function () {
                            window.location = '/login'
                        }, 3000);
                    } else {
                        /* Show message */
                        $('.panel-body').prepend('<div class="alert alert-danger">Error occurred!</div>');
                    }
                }).fail(function (response) {

                    /* Remove Spinner */
                    $('.submit').html('Register');
                    $('.submit').removeAttr('disabled');
                    
                    /* Show message */
                    $('.panel-body').prepend('<div class="alert alert-danger">Error occurred!</div>');
                    
                    console.log(response);
                });
            },
            invalidHandler : function (event, validator) {
                /* Remove Spinner */
                $('.submit').html('Register');
                $('.submit').removeAttr('disabled');
            }
        });
   
    </script>
@endsection