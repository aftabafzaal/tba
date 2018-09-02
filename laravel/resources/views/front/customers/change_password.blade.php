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
            <div class="tab-content">
			
				<div class="hed"><h2>change <span>password</span></h2></div>
			
                <div id="profile" class="tab-pane fade active in">
                    @if (session('success'))
                    <div class="alert alert-success  alert-dismissable clrlist listview">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable  clrlist listview">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <br>
                    <div class="profile__dtl col-sm-6 pul-cntr">
                    {!! Form::open(array( 'class' => 'form','url' => 'postchangepassword', 'method' => 'post')) !!}
                    <div class="form-group col-md-12">
						<label>Current Password</label>
                        {!! Form::password('old_password', ['class'=>'form-control','placeholder'=>'Current Password']) !!}
                    </div>
                    <div class="clearfix"></div>
					<div class="form-group col-md-12">
						<label>New Password</label>
                        {!! Form::password('password', ['class'=>'form-control','placeholder'=>'New Password']) !!}
                    </div>
					<div class="clearfix"></div>
					
                    <div class="form-group col-md-12">
						<label>Confirm Password</label>
                        {!! Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
                    </div>                        
					<div class="clearfix"></div>
                    <div class="form-group col-md-12">
                        <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit">
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  
@endsection