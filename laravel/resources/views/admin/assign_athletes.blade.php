@extends('admin/admin_template')

@section('content')

<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach
        </div> <!-- end .flash-message -->
        <div class="flash-message">
            <h3 class="alert alert-info">Assign Athlete to "{{$ambassador->firstName}} {{$ambassador->lastName}}" <a href="{{url('admin/ambassadors')}}" class="btn btn-primary pull-right">Back</a></h3>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Unassigned Athletes ( Total : {{ count($model) }} )</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>

                </div>
            </div>
            <div class="box-body">
                @if(count($model)>0)

                <ul class="products-list product-list-in-box" style="
                    overflow: auto;
                    max-height: 650px;">

                    <table class="table" id="order_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <td></td> 

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($model as $row) { ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->firstName . ' ' . $row->lastName; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo date("d M Y", strtotime($row->created_at)); ?></td>
                                    <td><button type="button" class="btn btn-sm btn-default assign" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row->id ?>">Assign</button></td>
                                </tr>
                                <?php $i++;
                            } ?>
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" style="color: red">Alert</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h3>Are you sure do you want to assign this?</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="<?php echo url('admin/athlete/assign'); ?>" method="POST">
                                            <input type="hidden" id="athlete_id" name="athlete_id" value="">
                                            <input type="hidden" name="ambassador_id" value="<?php echo $ambassador_id; ?>">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-success pull-left">Yes</button> 
                                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>   
                                        </form>

                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>


                        </tbody>

                    </table>
<?php // echo $model->render(); ?>
                </ul>
                @else 
                <h3>No Data Found. . . .</h3>
                @endif
            </div>

        </div>
    </div>
</div>
<script>
    jQuery('.assign').click(function ()
    {
        $('#athlete_id').attr('value', $(this).data('id'));
    });
</script>
@endsection