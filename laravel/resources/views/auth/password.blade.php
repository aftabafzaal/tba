@extends('login_signup')
<?php
$title = 'Reset Password';
$description = '';
$keywords = '';
?>
@include('front/common/meta')
@section('content')
<section class="account-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 pul-cntr mt50 text-center">
                <div class="panel panel-default">
                    <div class="panel-heading clrhm"><h2><?php echo $title; ?></h2></div>
                    <div class="panel-body ">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissable clrlist listview">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Whoops!</strong> There were some problems with your input.<br> 
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

						<h4>To reset your password,<br/> enter the email address you use to sign in.</h4>
                        <form class="form mt20 form-control-2x" role="form" method="POST" action="{{ url('/password/email') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
									<!--label>E-Mail Address</label-->
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">
                            </div>

                            <div class="form-group">
                                
                                    <button type="submit" class="btn btn-primary form-control">
                                        Reset my password <i class="fa fa-paper-plane"></i>
                                    </button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
