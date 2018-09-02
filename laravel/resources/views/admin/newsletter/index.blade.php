@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Subscribers( Total : {{ count($newsletter) }} )</h3>
            </div>
            <!-- /.box-header -->
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
                @endforeach
            </div> <!-- end .flash-message -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($newsletter as $row)
                    <tr>
                        <td><?php echo $i;
                    $i++;
                    ?></td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->email}}</td>
                        <td><button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-id="delete/<?php echo $row->id ?>"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    @endforeach
                    @include('admin/commons/delete_modal')
                    </tbody>
                </table>
<?php echo $newsletter->render(); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<script>
    jQuery('.delete').click(function ()
    {
        $('#delete').attr('href', $(this).data('id'));
    });
</script>
@endsection