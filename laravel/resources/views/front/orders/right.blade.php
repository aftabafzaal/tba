<div class="order-cont clrlist listview overload">
    <div class="hed"><h3>Order <span>Total</span></h3></div>
    <ul>
        <li><span class="subtotal-txt">Subtotal:</span><span class="subtotal-txt subtotal-txt2">{{ $currency[Config::get('params.currency_default')]['symbol']}}<?php echo $sum; ?></span></li>
        
    </ul>
</div>