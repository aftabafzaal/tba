@extends('admin/admin_template')

@section('content')
<?php
$currency = Config::get('params.currency');
$orderPrefix = Config::get('params.order_prefix');
?>
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        @include('admin.commons.errors')
        <!-- PRODUCT LIST -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Orders (Total : {{ count($orders) }} ) </h3>
<!--                <div class="form-group" style="margin: -26px 0px 0px 263px;position: absolute;width: 173px;">
                    <label for="type" style="position: absolute;margin: 6px 0px 0px -95px;">Order Status</label>
                    <select class="form-control"  id="order_status" name="type">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="complete">Complete</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                        <option value="onhold">On Hold</option>
                    </select>
                </div>-->
<!--                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="products-list product-list-in-box">

                    <table class="table" id="order_table">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Name</th>
                                <th>Added</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><?php echo $orderPrefix; ?>{{$order->id}}</td>
                                <td>{{ $order->billingFirstName.' '.$order->billingLastName }}</td>
                                <td>{{ date('d M Y',strtotime($order->created_at))}}</td>
                                <td>{{ ucfirst($order->orderStatus)}}</td>
                                <td>{{ $currency[Config::get('params.currency_default')]['symbol']}}{{ $order->grandTotal}}</td>
                                <td><a class="btn btn-info" href="{{ url('admin/order/'.$order->id) }}">Detail</a></td>
                                <td><button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-id="order/delete/<?php echo $order->id; ?>"><i class="fa fa-trash"></i></button></td>                                    
                            </tr>
                            @endforeach 
                            @include('admin/commons/delete_modal')
                        </tbody>

                    </table>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.col -->

</div>
<script>
jQuery('.delete').click(function ()
{
    $('#delete').attr('href', $(this).data('id'));
});
</script>
@endsection

