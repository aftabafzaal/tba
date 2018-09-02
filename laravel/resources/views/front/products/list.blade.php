<?php
$currency = Config::get('params.currency');
?> 

@if(count($products)>0)
@foreach ($products as $product)
<div class="prod-box col-sm-3">
    <div class="prod__inr">
        <div class="prod__img">
            <img src="{{ asset('uploads/products/thumbnail')}}/<?php echo $product->image; ?>" alt="" />
        </div>
        <div class="prod__cont">
            <h4><?php echo $product->name; ?></h4>
            <p><?php echo $product->teaser; ?></p>
            <div class="prod__price"><?php echo $currency[Config::get('params.currency_default')]['symbol'] ?> @include('front/products/price')</div>

            <div class="lnk-btn atc-btn"><a class="btn" href="<?php echo url('product/' . $product->id); ?>">Customize</a></div>
        </div>

    </div>
</div>
@endforeach
@else
<center><h3>Sorry, there is no results for your search</h3></center>
@endif




