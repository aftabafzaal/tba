@extends('design_layout')

@section('content')
<?php
$currency = Config::get('params.currency');
$price = $product->price;

$data = getimagesize(asset('uploads/products') . "/" . $product->image);
$width = $data[0];
$height = $data[1];
$thumbWidth = (int) $width / 2;
$thumbHeight = (int) $height / 2;
?>

<style>

    .monkeythink {
        position: relative;
        float: left;
        width: 200px;
        height: 286px;

    }

    .monkeythink .jtextfill {
        position: absolute;
        top: 30px;
        left: 20px;
        width: 150px;
        height: 70px;
        background-color: #fff;
        text-align: center;
    }
</style>
<script>
    function update() {
        var size = parseInt($('#maxsize').val(), 10);
        if (!isNaN(size)) {
            $('.dyntextval').html($('#dyntext').val());

            $('.jtextfill').textfill({
			maxFontPixels: 20,
			minFontPixels: 1,
			changeLineHeight: false
		});
        }
    }

    $(function () {
        $('#maxsize').keyup(update);
        $('#dyntext').keyup(update);
        update()
    });
</script>
<div>


    <div>
        <label for="dyntext">What is the monkey thinking?</label>
        <input type="text" id="dyntext" value="e=mc²">
    </div>
    <div>
        <label for="maxsize">Maximal font size in pixels?</label>
        <input type="text" id="maxsize" value="0">
    </div>

    <hr>

    <div class="monkeythink">
        <div class="jtextfill">
            <span class="dyntextval" >e=mc²</span>
        </div>
    </div>

</div>




@endsection






