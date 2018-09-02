@extends('layout')
@section('content')
<?php
$currency = Config::get('params.currency');
$orderPrefix = Config::get('params.order_prefix');
?>
<section class="dashboard-area">
    <div class="container">
        <div class="dash__lft col-sm-3">
            <div class="dash__tabs">
                @include('front/common/left')
            </div>
        </div>
        <div class="dash__rgt col-sm-9">
            
            <div class="tab-content pl20">
                <div id="profile" class="tab-pane fade active in">
                    <div class="hed"><h2>Your <span>Orders</span></h2></div>
                <table id="example" class="table table-bordered mt20 " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Added</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>                                    
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><?php echo $orderPrefix; ?>{{$order->id}}</td>
                            <td>{{ date('d M Y h:i a',strtotime($order->created_at))}}</td>
                            <td>{{ ucfirst($order->orderStatus)}}</td>
                            <td>{{ $currency[Config::get('params.currency_default')]['symbol']}}{{ $order->grandTotal}}</td>
                            <td><a href="order/{{$order->id}}" class="btn btn-primary btn-flat">Details</a></td>                                    
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
                    </div>
            </div>
        </div>
    </div>
</section>

@endsection