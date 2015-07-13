@extends('admin.layouts.main')

@section('link')
    @parent
    <link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet"></link>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            
			<table id="users-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined At</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            
		</div>
	</div>
</div>

<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary submit">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection


@section('script')
    @parent
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="{{ asset('/user/js/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            
            var table = $('#users-table').DataTable( {
                "processing": true,
                "serverSide": true,
                "iDisplayLength": 50,
                "dom": '<"search"f><"top">t<"bottom"p><"clear">',
                "ajax": "/administrator/users/data",
                "columnDefs": [ {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-info'>Edit</button>"
                } ]
            } );
            
            /* Edit Actions event*/
            $('#users-table tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                
                /* Generate Edit Form */
                $('.modal-body').html(
                    '<form id="form"> \
                        <div class="form-group"> \
                            <label for="name">Name</label> \
                            <input type="text" id="name" name="name" class="form-control" value="'+data[0]+'"/> \
                        </div> \
                        <div class="form-group"> \
                            <label for="email">Email</label> \
                            <input type="text" id="email" name="email" class="form-control" value="'+data[1]+'"/> \
                        </div> \
                    </form>'
                );
                /* Show Modal */
                $('.modal').modal();
            } );
            
            
            
            /* Edit Save event */
            $('.submit').on('click', function () {
                /* Load Spinner */
                $('.submit').html('<i class="fa fa-cog fa-spin"></i>');
                $('.submit').attr('disabled','true');
                
                $('#form').validate({
                    rules : {
                        name : {
                            required : true
                        },
                        email : {
                            required : true,
                            email : true
                        }
                    },
                    submitHandler : function (form) {
                        /* Load Spinner */
                        $('.submit').html('<i class="fa fa-cog fa-spin"></i>');
                        $('.submit').attr('disabled','true');

                        var name = $('[name=name]').val();
                        var email = $('[name=email]').val();
                        var _token = $('[name=_token]').val();


                    },
                    invalidHandler : function (event, validator) {
                        /* Remove Spinner */
                        $('.submit').html('Register');
                        $('.submit').removeAttr('disabled');
                    }
                });
            });
            
            /* Search Box styling */
            $('.search div').append($('.search div label input'));
            $('.search div').prepend('<span class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>');
            $('.search div').addClass('input-group');
            $('.search div input').css('margin-left','0');
            $('.search div label').remove();
            
        } );
    </script>
@endsection