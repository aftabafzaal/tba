<?php
$currency = Config::get('params.currency');
//use App\Charges;
//$subscription_fee = Charges::where('type','subscription_fee')->lists('rate');
//d($subscription_fee[0],1);
$required = 'required';
?>
<script>
<?php
if (isset(Auth::user()->id)) {
    echo 'jQuery("body").addClass("login00");';
} else {
    echo 'jQuery("body").addClass("logout");';
}
?>
</script>
<section class="hdr-top-area">
    <div class="container">
        <a class="navbar-brand pul-lft" href="{{url('/')}}"><img src="{{asset('')}}/front/images/logo.png" alt="logo" class="broken-image"/></a>

        

    </div>
</section>

