@extends('customer')
@section('content')
<?php
$required = 'required';
?>
<section class="dashboard-area">
    <div class="container">
        @if (count($errors->register) > 0)
        <div class="alert alert-danger alert-dismissable clrlist listview">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Whoops!</strong> There were some problems with your input.
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
        <div class="dash__lft col-sm-3">
            <div class="dash__tabs">
                @include('front/common/left')
            </div>
        </div>
        <div class="dash__rgt col-sm-9">
            <div class="tab-content">
                <div id="profile" class="tab-pane fade active in">
                    <div class="profile__dtl col-sm-12">

                        {!! Form::model($user, ['files' => true,'class' => 'form','url' => ['updateprofile'], 'method' => 'post']) !!}
                        <div class="form-group col-sm-4">
                            {!! Form::label('First Name') !!}
                            {!! Form::text('firstName', null , array('class' => 'form-control',$required) ) !!}
                        </div>
                        <div class="form-group col-sm-4 ">
                            {!! Form::label('Middle Name') !!}
                            {!! Form::text('middleName', null , array('class' => 'form-control') ) !!}
                        </div>
                        <div class="form-group col-sm-4 ">
                            {!! Form::label('Last Name') !!}
                            {!! Form::text('lastName', null , array('class' => 'form-control',$required) ) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('email') !!}
                            {!! Form::text('email', null , array('class' => 'form-control',$required) ) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('phone') !!} *
                            {!! Form::text('phone', isset($address->phone) ? $address->phone : null , array('placeholder'=>"Phone *",'class' => 'form-control',$required) ) !!}
                        </div>
                        {!! Form::hidden('address_id', isset($address->id) ? $address->id : null ) !!}



                        <div class="col-md-12 fit__sub__reset clrlist">
                            {!! Form::hidden('address_id', isset($address->id) ? $address->id : null ) !!}
                            <button type="submit" class="fit__submit">Update</button>
                            <button type="button" class="fit__reset" onclick="back()">Back</button>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>



            </div>
        </div>
    </div>
	<script>
		window.setTimeout(function() {
			jQuery(".alert").fadeTo(500, 0).slideUp(500, function(){
				jQuery(this).remove(); 
			});
		}, 4000);
	</script>
	
</section>  
@endsection