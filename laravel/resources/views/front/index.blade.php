@extends('layout')
<?php
$title = 'Home';
$description = '';
$keywords = '';
?>
@include('front/common/meta')
@section('content')
<style>
    .trainer-box{
        cursor: pointer;
    }
</style>

<section class="slider-area no-ctrl"  >
    <div id="carousel-example-generic" class="carousel slide slider--pauseplay" data-ride="carousel" data---interval="false">

        <ol class="carousel-indicators thumbs">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item active bg-cvr" style="background-image:url('{{asset('')}}/front/images/slide1.jpg');">
                <div class="caro-caps0">
                    <div class="container">
                        <div class="slide__cont col-sm-5 p0 pul-cntr">

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>


    </div>
</section>


<section class="product-area scale--hover">
    <div class="container">
        <div class="hed">
            <h2>OUR BEST <span>Designs</span></h2>
        </div>
        @include('front.products.list')
        <div class="clearfix"></div>
        <div class="lnk-btn inline-block view-btn"><a href="products"><i class="fa fa-eye"></i> View All</a></div>

    </div>
</section>


@include('front/common/newsletters')
<script type="text/javascript">
    function changePage(id)
    {
        window.location = '<?php echo url('user'); ?>' + '/' + id;
    }
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $('body').addClass('home-page');
    });

    // function changePage(id) 
    // {
    //   alert(id);
    //  //window.location.href = "<?php echo url('user'); ?>/"+id;
    // }

</script>

<script type="text/javascript">

    $(function () {
        $("#cartIcon1").attr("src", "{{asset('')}}/front/images/cart-icon.png");
        $("#cartIcon2").attr("src", "{{asset('')}}/front/images/cart-icon2.png");
    });

</script>

<script type="text/javascript">

    $(function () {
        $("#hdr-icon1").attr("src", "{{asset('')}}/front/images/hdricon1.png");
        $("#hdr-icon2").attr("src", "{{asset('')}}/front/images/hdricon2.png");
    });

</script>

<?php // echo $model->body;?>
@endsection
