@extends('user.layouts.main')

@section('link')
    @parent
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

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
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
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
<script type='text/javascript'>var rma ={'campaignId':'cf94fe4b46b97905211c23f947687b83','customize':{  'src':'http://rmarepo.richmediaads.com/2754/sunsilk_tablet/','custTracker':['']}};</script><img src='http://track.mobileads.com/t?i=cf94fe4b46b97905211c23f947687b83' width='0' height='0' style='display:none' /><script src='mraid.js'></script><script type='text/javascript' src='http://cdn.mobileads.com/general.js'></script>

<script type='text/javascript'>var rma ={'campaignId':'ad4ad18a224dba2ca5c281dad18728ab','customize':{  'src':'http://rmarepo.richmediaads.com/2754/sunsilk_tablet/'}};</script><img src='http://track.richmediaads.com/t?i=ad4ad18a224dba2ca5c281dad18728ab' width='0' height='0' style='display:none' /><script type='text/javascript' src='http://cdn.richmediaads.com/general.js'></script>
@endsection


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
            var remember = $('[name=remember]').val();
            var _token = $('[name=_token]').val();
            
            $.post('/login', {_token : _token, email : email, password : password, remember : remember}, function () {
            
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
                            window.location = '/dashboard'
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