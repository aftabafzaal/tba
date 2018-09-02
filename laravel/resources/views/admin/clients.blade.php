@extends('admin/admin_template')
@section('content')
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        @include('front/common/errors')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Users (Total: {{count($model)}} )</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>

                </div>
            </div>
            <div class="box-body" style="">
                @if(count($model)>0)
                
                <table class="table no-margin" id="order_table">
                    <thead>
                        <tr >
                            <th>#</th>
                            <th>Name</th>
                            <th>Joined As</th>
                            <th>Email</th>
                            <th>Status</th>
                            <td></td> 

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($model as $row)
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->firstName . ' ' . $row->lastName; ?></td>
                            <td><?php echo $row->email; ?></td>
                            <td><?php echo date("d M Y", strtotime($row->created_at)); ?></td>
                            <td><?php if ($row->status) { ?> <span class="green">Approved</span> <?php } else { ?><span class="red"> Disapproved </span><?php } ?></td>
                            <td><a href="client/{{$row->id}}" class="btn btn-info btn-sm">Detail</a></td>
                            <td><button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-id="client/delete/<?php echo $row->id ?>"><i class="fa fa-trash"></i></button></td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                        @include('admin/commons/delete_modal')
                    </tbody>

                </table>
                <div class="col-sm-12">
                    <?php echo $model->render(); ?>
                </div>
                @else
                <div class="col-sm-12">
                    <h3>No Data Found. . .</h3>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
<script>
    jQuery('.delete').click(function ()
    {
        $('#delete').attr('href', $(this).data('id'));
    });
</script>
@endsection