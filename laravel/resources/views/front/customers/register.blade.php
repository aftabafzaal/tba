<?php
$required = 'required';
?>

@if (count($errors->register) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->register->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (Session::has('success'))
<div class="alert alert-success">
    <h4><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</h4>
</div>
@endif

<div class="placelabeler ">

    <div class="row fnc-fom">
        <div class="form-group col-sm-4">
            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name"  required="required" value="{{ old('firstName') }}">
            <label>First Name</label>
        </div>
        <div class="form-group col-sm-4">
            <input type="text" class="form-control" name="middleName" id="midName" placeholder="Middle Name" value="{{ old('middleName') }}">
            <label>Middle Name</label>
        </div>
        <div class="form-group col-sm-4">
            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name" required="required" value="{{ old('lastName') }}">
            <label>Last Name</label>
        </div>
    </div>

    <div class="row fnc-fom">
        <div class="form-group col-sm-4">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address *"  required="required" value="{{ old('email') }}">
            <label>Email</label>
        </div>
        <div class="form-group col-sm-4">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password *" required="required">
            <label>Password</label>
        </div>
        <div class="form-group col-sm-4">
            <input type="password" class="form-control" data-match-error="Whoops, these don't match" data-match="#password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password *" required="required">
            <label>Confirm Password</label>
        </div>
    </div>
    <div class="row fnc-fom">
        <div class="form-group col-sm-4">
            <select class="form-control" name="country" id="country" required="required">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option> 
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-4">
            <select class="form-control" name="state" id="state" required="required">
                <option value=''>Select country first</option> 
            </select>
        </div>    

        <div class="form-group col-sm-4">
            <input type="text" class="form-control" name="city" id="city" placeholder="City" value="{{ old('city') }}">
            <label>City</label>
        </div>
    </div>
    <div class="row fnc-fom">
        <div class="form-group col-sm-6">
            <input type="text" class="form-control" name="address" id="address" placeholder="Your Address Line 1 *" required="required" value="{{ old('address') }}">
            <label>Address</label>
        </div>

        <div class="form-group col-sm-6">
            <input type="text" class="form-control" name="address2" id="address" placeholder="Your Address Line 2 *" value="{{ old('address2') }}">
            <label>Address 2</label>
        </div>
    </div>

    <div class="row fnc-fom">
        <div class="form-group fnc-select col-sm-6">
            <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="{{ old('zip') }}">
            <label>Zip Code</label>
        </div>
        <div class="form-group col-sm-6">
            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone *" value="{{ old('phone') }}">
            <label>Phone</label>
        </div>
    </div>

</div>
<div class="reg__photos text-center col-sm-12 p0 clrlist">
    <button type="submit" class="btn btn-default reg__submit__btn" id="register_button">Register</button>
</div>

</div>

<script>

    $('#country').on('change', function () {
        $.ajax({
            type: "GET",
            url: "<?php echo url('/state/get/'); ?>/" + this.value,
            data: "",
            async: true
        }).success(function (val) {
            var response = JSON.parse(val);
            if (response.length > 0) {
                var html = "<option value=''>Select your state</option>";
                for (key in response) {
                    html += "<option value='" + response[key].id + "'>" + response[key].name + "</option>";
                }
            } else {
                html += "<option value=''>Select country first</option> ";
            }
            $('#state').html(html);
        });
    });
</script>  