@extends('layout')
@section('content')
<?php
$currency = Config::get('params.currency');
$orderPrefix = Config::get('params.order_prefix');
?>
<section class="dashboard-area">
    <div class="tab-content">
        <div id="profile" class="tab-pane fade active in">
            <div class="container">
                <div class="dash__lft col-sm-3">
                    <div class="dash__tabs">
                        @include('front/common/left')
                    </div>
                </div>
                <div class="col-sm-9">
                    <h3>Order Information</h3>

                    <ul class="list-unstyled">
                        <li><strong>Order ID:</strong> <?php echo $orderPrefix; ?>{{$order->id}}</li>
                        <li><strong>Email:</strong> {{$order->email}}</li>
                        <li><strong>Order Total:</strong> {{ $currency[Config::get('params.currency_default')]['symbol']}} {{ $order->grandTotal}}</li>
                    </ul>

                    <div class="check-left-sect">
                        <h3>Designs Information</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>                                 
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum = 0;
                                $i = 0;
                                //d($orders->products,1);
                                ?>
                                @foreach ($order->products as $product)
                                <?php
                                $rowTotal = $product->price * $product->quantity;
                                $sum += $rowTotal;

                                if ($i == 0) {
                                    //$billingName=$product->billingFirstName.' '.$product->billingLastName;
                                    //$shippingName=$product->shippingFirstName.' '.$product->shippingLastName;
                                }
                                ?>
                                <tr>
                                    <td><img class="img-circle pull-left" style="height: 60px;" src="{{ asset('uploads/orders/'.$order->id.'/thumbnail')}}/<?php echo $product->image ?>" alt="<?php echo $product->name; ?>" />
                                    
                                    
                                    </td>
                                    
                                    <td><span>{{ $currency[Config::get('params.currency_default')]['symbol']}} <?php echo $product->price ?></span></td>
                                    <td><a href="{{ asset('uploads/orders/'.$order->id)}}/<?php echo $product->image ?>" target="_blank">Download</a></td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
