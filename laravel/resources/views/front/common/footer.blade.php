<footer>
    <section class="ftr-area">
        <div class="container">

            <div class="ftr__box col-sm-5">

                <div class="icon-boxed icon-rounded clrlist shake-icon">
                    <h4>Connect with us</h4>
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>

                <div class="footer_brand color-gray mt20" ><img src="{{asset('/front/images/logo.png')}}" alt="logo" /></div>

            </div>

            <div class="ftr__box ftr__links col-sm-3 clrlist listview">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ url('home') }}">Home</a></li>
                    <li><a href="{{ url('about-us') }}">About Us</a></li>
                    <li><a href="{{ url('products') }}">Designs</a></li>
                </ul>
            </div>

            <div class="ftr__box ftr__contact col-sm-4 clrlist listview list-icon">
                <h4>Contact Us</h4>
                <ul>
                    <li><a href="mailto:admin@hammerfit.net"><i class="fa fa-envelope"></i> admin@tba.com</a></li>
                    <li><a><i class="fa fa-phone"></i> 414 803 4327</a></li>
                    <li><a href="#"><i class="fa fa-home"></i> Indianapolis, IN 46278</a></li>
                    <li><a href="#"><i class="fa fa-globe"></i> Show on map</a></li>
                </ul>
            </div>

        </div>
    </section>
</footer>
<script>
    $(document).ready(function () {
<?php if (isset(Auth::user()->id)) { ?>
            $('body').addClass('user-login');
<?php } else { ?>
            $('body').addClass('user-logout');
<?php } ?>
    });

</script>

<script>

    function isScrolledIntoView(elem) {
        var docViewTop = jQuery(window).scrollTop();
        var docViewBottom = docViewTop + jQuery(window).height();

        var elemTop = jQuery(elem).offset().top;
        var elemBottom = elemTop + jQuery(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

    jQuery(window).scroll(function () {
        jQuery('header, section, footer, [class*="-area"]').each(function () {
            if (isScrolledIntoView(this) === true) {
                jQuery(this).addClass("/ in-view");
            } else {
                jQuery(this).removeClass("/ in-view");
            }
        });
    });

</script>
