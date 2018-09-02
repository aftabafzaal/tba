@extends('admin/admin_template')
@section('content')
<?php
$currency = Config::get('params.currency');
$orderPrefix = Config::get('params.order_prefix');
?>
@include('admin/commons/errors')
<div id="warning_message"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">

        <div class="box box-primary">

            <div class="box-body">
                <div class="box-header with-border">
                    <h2 class="box-title">Order Information</h2>
                </div>
                <div class="col-lg-6 col-md-6 col-md-6">
                    <ul class="products-list product-list-in-box" >
                        <li><strong>Order ID:</strong> <?php echo $orderPrefix; ?>{{$orders->id}}</li>
                        <li><strong>Email:</strong> {{$orders->email}}</li>
                        <li><strong>Order Date:</strong> {{ date("d M Y",strtotime($orders->orderDate))}}</li>
                        <li><strong>Order Total:</strong> {{ $currency[Config::get('params.currency_default')]['symbol']}}{{ $orders->grandTotal}}</li>
                        <li><strong>Order Status:</strong></li>
                    </ul>

                    <div class="form-group">
                        <button class="btn btn-default pull-right" onclick="updateStatus('<?php echo $orders->id; ?>', $('#order_status').val())" >Update Status</button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-md-6">
                    <!--                    <div class="box-header with-border">
                                            <h2 class="box-title">User Information</h2>
                                        </div>-->
                    <ul class="products-list product-list-in-box" >
                        <li>
                            <strong>Name:</strong> {{$orders->name}}
                        </li>
                        <li>
                            <strong> Country:</strong> {{$addresses->country}}
                        </li>
                        <li>
                            <strong>State:</strong> {{$addresses->state}}
                        </li>
                        <li>
                            <strong>City:</strong> {{$addresses->city}}
                        </li>
                        <li>
                            <strong>Zip:</strong> {{$addresses->zip}}
                        </li>
                        <li>
                            <strong>Phone:</strong> {{$addresses->phone}}
                        </li>
                    </ul>
                </div>

            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="{{url('admin/orders')}}">Back</a>
            </div>
        </div>

    </div>
    <!--    <div class="col-lg-12 col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Order Status</h3>
                </div>
                <div class="box-body">
                    
                </div>
    
            </div>
        </div>-->
    @if(isset($orders->message) && $orders->message != '')
    <div class="col-lg-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Message</h3>
            </div>
            <div class="box-body">
                <?php echo $orders->message; ?>
            </div>

        </div>
    </div>
    @endif

    <div class="col-lg-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Summary</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">


                <table class="table table-bordered">
                    <thead>
                        <tr>                                 
                            <th>Design</th>
                            <th>Price</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum = 0;
                        $i = 0;
                        //d($orders->products,1);
                        ?>
                        @foreach ($orders->products as $product)
                        <?php
                        $rowTotal = $product->price * $product->quantity;
                        $sum += $rowTotal;

                        if ($i == 0) {
                            //$billingName=$product->billingFirstName.' '.$product->billingLastName;
                            //$shippingName=$product->shippingFirstName.' '.$product->shippingLastName;
                        }
                        ?>
                        <tr>
                            <td>


                                <img class="img-circle pull-left" style="height: 60px;" src="{{ asset('uploads/orders/'.$orders->id.'/thumbnail')}}/<?php echo $product->image ?>" alt="<?php echo $product->name; ?>" />



                                <div class="cart_productname">
                                    <?php echo $product->name; ?>
                                </div>
                            </td>
                            <td><span>{{ $currency[Config::get('params.currency_default')]['symbol']}} <?php echo $product->price ?></span></td>
                            <td><a href="{{ asset('uploads/orders/'.$orders->id)}}/<?php echo $product->image ?>" target="_blank">Download</a></td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div></div>
    </div>



</div>
<script>
    function updateStatus(order, status)
    {
        $("#warning_message").html('');
        $('.loader').css('display', 'block');
        $("#warning_message").html('');

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $.ajax({
            url: '{{ url("admin/updateOrderStatus") }}',
            type: 'POST',
            data: {_token: CSRF_TOKEN, orderid: order, status: status},
            dataType: 'JSON',
            success: function (data) {
                $('.loader').css('display', 'none');
                if (data.success === 1)
                {
                    $("#warning_message").html('<div class="alert alert-success alert-dismissible">' +
                            '<button type="button" class="close fa fa-times " data-dismiss="alert" aria-hidden="true"></button>' +
                            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
                            'Successfully updated.' +
                            '</div>');

                } else
                {
                    $("#warning_message").html('<div class="alert alert-danger alert-dismissible">' +
                            '<button type="button" class="close   fa fa-times " data-dismiss="alert" aria-hidden="true"></button>' +
                            '<h4><i class="icon fa fa-warning"></i> Alert!</h4>' +
                            'Some thing went wrong.' +
                            '</div>');
                }
            }
        });

    }
</script>
@endsection
