@extends('admin/admin_template')

@section('content')


<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-12" >
        <!-- PRODUCT LIST -->
        <div class="box-body table-responsive no-padding">

            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title">Design (<?php echo $product->name?>) ( Total : {{ count($options) }} ) </h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-sm btn-info btn-flat" href="{{url('admin/options/create')}}/{{$product_id}}">Add new Options</a>

                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Top</th>
                                    <th>Left</th>
                                    <th>Color</th>
                                    <th>Style</th>
                                    <th>Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $row)
                                <tr>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->topPosition; ?></td>
                                    <td><?php echo $row->leftPosition; ?></td>
                                    <td><?php echo $row->color; ?></td>
                                    <td><?php echo $row->style_id; ?></td>
                                    <td><?php echo $row->created_at; ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-warning btn-flat"  href="{{url('admin/options/edit')}}/<?php echo $row->id ?>" >Edit</a>
                                        <a class="btn btn-sm btn-danger btn-flat"  href="{{url('admin/options/delete')}}/<?php echo $row->id ?>" >X</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
                <!-- /.box-footer -->
            </div>

        </div>
    </div>
</div>

@endsection