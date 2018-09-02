@extends('login_signup')
<?php
$title = 'Join';
$description = "";
$keywords = "";
?>
@include('front/common/meta')
@section('content')
<?php
$required = 'required';
?>
<section class="account-area">
    <div class="container">
        <div class="hed">
            <h2>My <span>ACCOUNT</span></h2>
            <p>Get started with our step process</p>
        </div>
        <div class="acct__login acct__inr__title text-center col-sm-6">
            <h3>Login</h3>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" class="form" action="{{ url('postLogin') }}">
                <input type="hidden"  name="_token" value="{{ csrf_token() }}">
                <div class="form-group mb25">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required />
                </div>
                <div class="form-group mb10">
                    <input type="password" class="form-control" placeholder="Password" name="password" required  />
                </div>
                <div class="checkbox text-left">
                    <label><input type="checkbox" class="checkbox" name="remember">Remember me</label>
                </div>
                <div class="acct__lost">
                    <a href="{{url('')}}/password/email"><i class="fa fa-life-ring" aria-hidden="true"></i>Lost your password?</a>
                </div>
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-default acct__login__btn">Login</button>
            </form>
        </div>
        <div class="acct__login acct__reg acct__inr__title text-center col-sm-6">
            <h3>Register</h3>
            <div class="reg__athlete__btn reg__amb__btn">
                <a href="{{url('signup/user')}}">Register</a>
            </div>
        </div>
    </div>
</section>

@include('front/common/newsletters')

@endsection