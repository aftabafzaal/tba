@extends('layout')
@section('content')
<?php
$currency = Config::get('params.currency');
$required = "'required'";
?>

<div id="fh5co-contact" class="__web-inspector-hide-shortcut__ ">
    <div class="container">
        <div class="row">
            <div class="container-fluid ">
                <div class="checkout-back">
                    {!! Form::open(array( 'class' => 'form','url' => 'postOrder', 'name' => 'checkout')) !!}
                    <div class="checkout__main col-sm-8">
                        @if (count($errors->checkout) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->checkout->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div id="billing_information" class="billing_information">
                            <div class="hed"><h2>Billing <span>Information</span></h2></div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('First Name') !!}
                                {!! Form::text('billingFirstName', $user->firstName , array('class' => 'form-control',$required) ) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('Last Name') !!}
                                {!! Form::text('billingLastName', $user->lastName , array('class' => 'form-control',$required) ) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('email') !!}
                                {!! Form::text('billingEmail',  $user->email , array('class' => 'form-control',$required) ) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('country', 'Country *') !!}
                                <select name="billingCountry" id="billingCountry" class="form-control">
                                    <option >Country *</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            @if($country->id== $address->country) selected @endif > {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('state') !!}
                                <select <?php echo $required ?> class="form-control" name="billingState" id="billingState">
                                    <option value="">State / Region</option>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                            @if($state->id == $address->state) selected @endif> {{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('city') !!}
                                {!! Form::text('billingCity', $address->city , array('class' => 'form-control',$required) ) !!}
                            </div>
                            <div class="form-group col-sm-12">
                                {!! Form::label('address line 1') !!}
                                {!! Form::text('billingAddress1', $address->address , array('class' => 'form-control',$required) ) !!}
                            </div>
                            <div class="form-group col-sm-12">
                                {!! Form::label('address line 2') !!}
                                {!! Form::text('billingAddress2', null , array('class' => 'form-control','') ) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('Zip') !!}
                                {!! Form::text('billingZip', $address->zip , array('class' => 'form-control',$required) ) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('phone') !!}
                                {!! Form::text('billingPhone', $address->phone , array('class' => 'form-control',$required) ) !!}
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <div id="payment_method" class="billing_information">
                            <div class="hed"><h2>Payment <span>Information</span></h2></div>
                            @include('front/common/cc_form')
                            <div class="payment_method clrlist text-center">
                                <ul>
                                    <li>
                                        Managed by: 
                                    </li>
                                    <li>
                                        <span class='paypalicon'><img src="{{ asset('front/images/paypal-logo.png') }}"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div id="payment_information" class="billing_information">
                            <div class="form-group col-sm-8">
                                {!! Form::label('Additional Message') !!}
                                {!! Form::textarea('message', null, ['size' => '105x3','class' => 'form-control',$required]) !!} 
                                <span><p><strong>Note:</strong> This form submission could take <b>20 seconds</b> or longer, so keep patience!</p></span>
                            </div>
                            <div class="form-group col-sm-12 brackets--no"><button type="submit" class="btn btn-primary">Order Now</button></div>
                        </div>  
                    </div>  

                    <div class="checkout__sidebar col-sm-4">
                        <div class="order-cont clrlist listview overload">
                            <div class="hed"><h3>Order <span>Summary</span></h3></div>
                            <ul>
                                {{--*/ $sum = 0 /*--}}
                                @foreach ($cart as $product)
                                {{--*/ $sum = $sum+($product->total_price*$product->quantity)  /*--}}
                                <li class="order-total-descrp"><span class="txt1">{{$product->product_name}}</span> <span class="txt2">{{ $currency[Config::get('params.currency_default')]['symbol']}} {{$product->total_price}}</span></li>
                                @endforeach
                            </ul>
                        </div>
                        {!! Form::hidden('grandTotal',$sum) !!}
                        {!! Form::close() !!}  


                        @include('front/orders/right')

                    </div>       


                </div>

            </div>
        </div>

    </div>
</div>
<script>
    $('form').submit(function () {
        $(this).find('button[type=submit]').prop('disabled', true);
    });
</script>
<script>
    // A $( document ).ready() block.
    $(document).ready(function () {
        var countryId = '<?php echo $address->country; ?>';
        var stateId = '<?php echo $address->state; ?>';
        getStates(countryId);

        $("#is_shipping_different").on("change", function () {
            if ($("#is_shipping_different").is(':checked')) {
                getStates(countryId);
                $("#shipping_information").show();
            } else
            {
                $("#shipping_information").hide();
            }

        });
        //getCities(stateId);
    });

    $('#billingCountry, #shippingCountry').on('change', function () {
        var id = this.value;
        getStates(id);
    });
    $('#billingState, #shippingState').on('change', function () {
        var id = this.value;
        getCities(id);
    });
    function getStates(countryId) {
        var stateId = '<?php echo $address->state; ?>';
        $.ajax({
            type: "GET",
            url: "<?php echo url('/state/get/'); ?>/" + countryId,
            data: "",
            async: true
        }).success(function (val) {
            var response = JSON.parse(val);
            if (response.length > 0) {
                var html = "<option value=''>Select your state</option>";
                for (key in response) {
                    if (stateId == response[key].id) {
                        html += "<option value='" + response[key].id + "' selected>" + response[key].name + "</option>";
                    } else {
                        html += "<option value='" + response[key].id + "'>" + response[key].name + "</option>";
                    }

                }
            } else {
                html += "<option value=''>Select country first</option> ";
            }
            if ($("#is_shipping_different").is(':checked')) {
                $('#shippingState').html(html);
            }
            $('#billingState').html(html);
        });
    }
//    function getCities(stateId) {
//        var cityId = '<?php echo $address->city; ?>';
//        $.ajax({
//            type: "GET",
//            url: "<?php echo url('/city/get/'); ?>/" + stateId,
//            data: "",
//            async: true
//        }).success(function (val) {
//            var response = JSON.parse(val);
//            if (response.length > 0) {
//                var html1 = "<option value=''>Select your city</option>";
//                for (key in response) { 
//                    if (cityId == response[key].id) {
//                        html1 += "<option value='" + response[key].id + "' selected>" + response[key].name + "</option>";
//                    } else {
//                        html1 += "<option value='" + response[key].id + "'>" + response[key].name + "</option>";
//                    }
//
//                }
//            } else {
//                html1 += "<option value=''>Select state first</option> ";
//            }
//            $('#city').html(html1);
//        });
//
//    }

</script>  
@endsection
