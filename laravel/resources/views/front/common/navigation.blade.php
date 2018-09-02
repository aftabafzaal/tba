<?php
$cart = Session::get('cart');
?>
<header class="hdr-sticky hdr--sticky hdr--sticky-inactive-xs">

    @include('front/common/header')

    <section class="hdr-area hdr-nav  cross-toggle">
        <div class="container">
            <nav class="navbar navbar-default" role="navigation" id="slide-nav">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand visible-xs" href="{{url('/')}}"><img src="{{asset('')}}/front/images/logo.png" alt="logo" class="broken-image"/></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div id="slidemenu">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-main">
                                <li><a href="{{url('/')}}">HOME</a></li>
                                <li><a href="{{url('')}}/about-us">ABOUT US</a></li>
                                <li><a href="{{url('')}}/products">Online Designs</a></li>
                            </ul>

                            <ul class="nav navbar-nav pul-rgt login-area">
                                <?php
                                if (isset(Auth::user()->id)) {
                                    ?>
                                    <li class="dropdown" ><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i><img src="{{asset('')}}/front/images/inr-cart-icon.png" id="cartIcon1"></i> MY ACCOUNT</a>
                                        <ul class="dropdown-menu">
                                            <li ><a href="{{ url('myorders')}}" class="pagelinkcolor">My Orders</a></li>
                                            <li><a href="{{ url('changepassword')}}" class="pagelinkcolor">Change Password</a></li>
                                            <li><a href="{{ url('profile')}}" class="pagelinkcolor">Profile</a></li>
                                            <li><a href="{{ url('auth/logout')}}" class="pagelinkcolor">Log Out</a></li>
                                        </ul>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="{{url('')}}/signup"><i><img src="{{asset('')}}/front/images/inr-cart-icon.png" id="cartIcon1"></i> LOGIN</a></li>
                                    <?php
                                }
                                ?>
                                <li><a href="{{url('')}}/cart/view"><i><img src="{{asset('')}}/front/images/inr-cart-icon2.png" id="cartIcon2"></i> MY CART</a></li>
                                
                            </ul>

                        </div><!-- /.navbar-collapse -->
                    </div>
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </section>
</header>
