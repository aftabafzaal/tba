@extends('customer')
@section('content')
<?php
$required = 'required';
?>
<section class="dashboard-area">
    <div class="container">
        <div class="dash__lft col-sm-3">
            <div class="dash__tabs">
                @include('front/common/left')
            </div>
        </div>
        <div class="dash__rgt col-sm-9">

            <div id="profile">
                <div class="profile__dtl col-sm-12">
                    <div class="flash-message">
                        @if (count($errors->register) > 0)
                        <div class="alert alert-danger alert-dismissable clrlist listview">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>		
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->register->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissable clrlist listview">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</p>
                        </div>
                        @endif
                    </div>
                    <form method="post" action="<?php echo url('updateaddress'); ?>">
                        <div class="profile__info">

                            <div class="form-group col-sm-12">
                                {!! Form::label('Address Line 1 *') !!}
                                {!! Form::text('address', isset($address->address) ? $address->address : null  , array('placeholder'=>"Address Line 1 *",'class' => 'form-control',$required) ) !!}
                            </div>

                            <div class="form-group col-sm-12">
                                {!! Form::label('Address Line 2') !!}
                                {!! Form::text('address2', isset($address->address2) ? $address->address2 : null  , array('placeholder'=>"Address Line 2",'class' => 'form-control') ) !!}
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('country', 'Country *') !!}
                                <select name="country" id="country" class="form-control">
                                    <option >Country *</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            @if($country->id== $address->country) selected= selected @endif > {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('state') !!} *
                                <select name="state" id="state" <?php echo $required; ?> class="form-control">
                                    <option >State *</option>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                            @if($state->id == $address->state) selected @endif> {{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('city','City *') !!}
                                <input type="text" class="form-control" name="city" id="city" placeholder="City" value="{{ $address->city }}">
<!--                                <select name="city" id="city" <?php echo $required; ?> class="form-control">
                                    <option >City *</option>
                                </select>-->
                                <!--                                {!! Form::text('city', isset($address->city) ? $address->city : null , array('placeholder'=>"City *",'class' => 'form-control',$required) ) !!}-->
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('zip') !!} *
                                {!! Form::text('zip', isset($address->zip) ? $address->zip : null , array('placeholder'=>"Postal Code / Zipcode *",'class' => 'form-control',$required) ) !!}
                            </div>
                        </div>

                        <div class="form-group fit__sub__reset clrlist col-sm-12">
                            {!! Form::hidden('address_id', isset($address->id) ? $address->id : null ) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="fit__submit">Update</button>
                            <button type="button" class="fit__reset" onclick="back()">Back</button>
                        </div>

                    </form>       
                </div>
            </div>

        </div>
    </div>
</div>
</section>  
<script>
    // A $( document ).ready() block.
    $(document).ready(function () {
        var countryId = '<?php echo $address->country; ?>';
        var stateId = '<?php echo $address->state; ?>';
        getStates(countryId);
        //getCities(stateId);
    });

    $('#country').on('change', function () {
        var id = this.value;
        getStates(id);
    });
    $('#state').on('change', function () {
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
            $('#state').html(html);
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