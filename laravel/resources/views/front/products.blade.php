@extends('layout')
<?php
$title = "Designs";
$description = "";
$keywords = "";
?>
@include('front/common/meta')
@section('content')
<section class="product-area scale--hover">
    <div class="container">
        <div class="hed">
            <h2>OUR BEST <span>Designs</span></h2>
            
        </div>
        @include('front/products/list')
    </div>
</section>	
<div class="clearfix"></div>
<div class="lnk-btn inline-block view-btn"></div>
@include('front/common/newsletters')
@endsection