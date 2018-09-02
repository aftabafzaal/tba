@extends('layout')

@section('content')
<section class="account-area">
    <div class="container">
        <div class="reg-area text-center p50 mb50">
            <div class="hed">
                <h2>Thank you <span><?php echo $user->firstName ?> <?php echo $user->lastName ?></span></h2>
            </div>
            <p class="lead">You have successfully verified your account.
                <!--			<br>
                                        <small>A confimation email has been sent to you email address.</small>-->
            </p>
            <?php if (!isset(Auth::user()->id)) { ?>
                <div class="acct__login text-center col-sm-12 clrlist">

                    <ul>
                        <li><a href="{{ url('signup') }}" class="btn btn-primary"> Sign In</a></li>
                    </ul>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
</section>
@endsection