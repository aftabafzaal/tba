@extends('layout')

@section('content')
<?php
// echo $sessionId;
$path= asset('uploads/cart/'.$sessionId.'/thumbnail');
?>
<div id="fh5co-contact" class="__web-inspector-hide-shortcut__">
    <div class="container">
        <?php
        $currency = Config::get('params.currency');
        ?>
        <div class="row">
            <div class="container-fluid">
                <div class="checkout-back">
                    @if (count($cart)==0)
                    <div class="alert alert-success">
                        <h4><i class="icon fa fa-check"></i> &nbsp  Your Basket is empty</h4>
                    </div>
                    @endif
                    @if (count($cart)>0)
                    <div class="cart__main col-sm-12">
                        <div class="check-left-sect">
                            <form id="cart_update" name="cart_update"  action="update" >
                                <table class="table table-fit ">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Delete</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sum = 0;
                                        ?>
                                        @foreach ($cart as $product)
                                        <?php
                                        $rowTotal = $product->total_price * $product->quantity;
                                        $sum+=$rowTotal;
                                        ?>
                                        <tr>
                                            <td>
                                                <ul class="__img">
                                                    <li class="checkout-img">
                                                        <img src="<?php echo $path;?>/<?php echo $product->image ?>" alt="<?php echo $product->product_name; ?>" />
                                                    </li>
                                                    <li><?php echo $product->product_name; ?></li>
                                                </ul>
                                            </td>
                                            <td><div class="btn btn-danger white trash-icon"><a href="../cart/delete/<?php echo $product->cart_id ?>"><i class="fa fa-trash"></i></a></div></td>

                                            <td><span class="txt-price">{{ $currency[Config::get('params.currency_default')]['symbol']}} <?php echo $rowTotal; ?></span></td>
                                        </tr>


                                        @endforeach
                                        
                                        <tr>
                                            <td> </td>
                                            <td>Total</td>
                                            <td><span class="txt-price">{{ $currency[Config::get('params.currency_default')]['symbol']}}<?php echo $sum; ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="checkout-btm-lnks signalized--hover">
                                    <li><a href="{!! url('/') !!}"> <i class="fa fa-arrow-circle-right"></i>  Continue Shoping</a></li>
                                    <li><a href="{!! url('checkout') !!}"> <i class="fa fa-shopping-cart"></i> Proceed to checkout</a></li>
                                </ul>
                            </form >
                        </div>


                    </div>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function submitCart() {
        $('#cart_update').submit();
    }
</script>
@endsection
