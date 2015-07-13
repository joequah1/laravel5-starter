@extends('admin.layouts.main')

@section('link')
    @parent

@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            
			<div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    Welcome!
                </div>
            </div>

		</div>
	</div>
</div>
@endsection


@section('script')
    @parent
@endsection