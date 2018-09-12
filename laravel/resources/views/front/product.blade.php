@extends('design_layout')

@section('content')
<?php
$styles = Config::get('fonts');

$currency = Config::get('params.currency');
$price = $product->price;

$data = getimagesize(asset('uploads/products') . "/" . $product->image);
$width = $data[0];
$height = $data[1];
$thumbWidth = (int) $width / 2;
$thumbHeight = (int) $height / 2;
?>
<style>
    .bigtext {

    }
    #draggable-zone 
    {
        background: url({{ asset('uploads/products/thumbnail')}}/<?php echo $product->image; ?>) 0 0 no-repeat;
        border:     0px solid #000;
        height:     <?php echo $thumbHeight; ?>px;
        overflow:   hidden;
        width:      <?php echo $thumbWidth; ?>px;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4" >
                <div id="text_fields" class="col-lg-12 col-md-12 col-sm-12"></div>
                <!--
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Font Family:</label>
                    <select name="font_family" id="font_family" class="form-control">
                        <option >Select Font Style</option>
                <?php
                foreach ($styles as $key => $style) {
                    ?>
                                <option style="font-family: <?php echo $style ?>"  value="<?php echo $key ?>" ><?php echo $style; ?></option>
                <?php } ?>
                    </select> 
                </div>-->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Text Style:</label>
                    <br clear="all"/>
                    <?php foreach ($productImages as $row) { ?><div class="col-lg-3 col-md-3 col-sm-3">
                            <a href="#_" onclick='changeImage("<?php echo $row->attribute_value_id; ?>", "<?php echo asset('uploads/products_images/thumbnail') . "/" . trim($row->image); ?>", "<?php echo asset('uploads/products_images') . "/" . trim($row->image); ?>")'>
                            <img src="{{ asset('uploads/products_images/thumbnail')}}/<?php echo $row->image; ?>" width="50" height="50"/></div>
                        </a>

                    <?php } ?>
                </div>
                <div class="add-text-area col-sm-4"> <br clear="all"/>

                    <form id="form_add_to_cart" class="prod-detail-form ">
                        <input type="hidden" name="product_id"  id="product_id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="image"  id="image" value="<?php echo $default[0]->image ?>" />
                        <input type="hidden" name="attribute_value_id"  id="attribute_value_id" value="<?php echo $default[0]->attribute_value_id ?>" />
                        <input type="hidden" name="quantity"  id="quantity" value="1" />
                        <input type="hidden" name="total_price"  id="total_price" value="<?php echo $product->price; ?>" />
                        <input type="hidden" name="price"  id="price" value="<?php echo $product->price; ?>" />
                    </form>
                    <a href="javascript:void(0);" class="btn btn-info" onclick="makeOrderImage()">Finish</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6"><div id="draggable-zone" ></div></div>
        </div>
    </div>
    <?php /* ?>
      <div id="large" style="height:<?php echo $product->textHeight * 2; ?>px;display: none;background: url({{ asset('uploads/products')}}/<?php echo $product->image; ?>) 0 0 no-repeat;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;">
      <div  data-value="1" data-type="text" id="front_large" style="display: inline-block;text-align: center;width: <?php echo $product->textWidth * 2; ?>px; padding-left: <?php echo $product->left * 2 ?>px; padding-top: <?php echo $product->top * 2 ?>px; display: block; position: relative;"><span id='front_text_large' style='font-size:<?php echo $product->fontSize * 2 ?>px;font-weight:<?php echo $product->fontWeight * 2 ?>;color:#<?php echo $product->color ?>;font-family:<?php echo $styles[$product->style]; ?>;'  ></span></div>
      </div>
      <?php */ ?>
    <!--
    border-style: solid;
    -->
    <script>
        var textDivCount = 1;
        var currentSelectedId = "0";
        var perviousSelectedId = "";
        var styles =<?php echo json_encode($styles) ?>;
        var textfields = "";
        var textDiv = "";

<?php
$i = 1;
foreach ($options as $option) {
    $zIndex=$i+rand(1,100);
    ?>

            textfields += "<p><input maxlength='<?php echo $option->textLimit ?>' class='form-control input_text' onkeyup=\"setText(<?php echo $i ?>,<?php echo $option->size ?>)\" type='text' onfocus=\"setDraggableActions('<?php echo $i ?>')\" data-value='<?php echo $i ?>' id='front_text_<?php echo $i ?>' placeHolder='<?php echo $option->name ?>' value='4' /></p>";
            textDiv += "<div  data-value='<?php echo $i ?>' data-type='text' id='front_div_<?php echo $i ?>' style='height:<?php echo $option->height; ?>px;display: inline-block;width: <?php echo $option->width; ?>px;left: <?php echo $option->leftPosition ?>px;top: <?php echo $option->topPosition ?>px;position:relative;text-align: center;font-size:<?php echo $option->size ?>px;color:#<?php echo $option->color ?>;font-family:<?php echo $styles[$option->style_id]; ?>;' ><span id='text_<?php echo $i ?>' style='height:<?php echo $option->height; ?>px;' ><?php echo $option->name ?>4</span></div>";

    <?php
    $i++;
}
?>

        function changeImage(attribute_value_id, thumbImage, image)
        {
            $('#draggable-zone').css("background-image", "url('" + thumbImage + "')");
            $('#large').css("background-image", "url('" + image + "')");
            $('#attribute_value_id').val(attribute_value_id);
        }

        function addText()
        {
            $("#text_fields").append(textfields);
            $("#draggable-zone").append(textDiv);
            textDivCount++;
        }

        function setText(currentSelectedId, size)
        {
            var text = $("#front_text_" + currentSelectedId).val();
            $("#front_" + currentSelectedId).text(text);
            update(currentSelectedId, size);
        }


        function rgb2hex(orig) {
            var rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
            return (rgb && rgb.length === 4) ? "" +
                    ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
                    ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
                    ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : orig;
        }

        function setDraggableActions(id)
        {
            perviousSelectedId = currentSelectedId;
            currentSelectedId = id
            var type = $("#front_" + currentSelectedId).data("type");
            if (type == 'text') {
                $("#font_family").val($("#front_" + currentSelectedId).css('font-family'));
                $("#size").val(parseInt($("#front_" + currentSelectedId).css("font-size")));
                $("#color").val(rgb2hex($("#front_" + currentSelectedId).css("color")));

            }
        }

        $(document).ready(function () {

            addText();
<?php
$i = 1;
foreach ($options as $option) {
    ?>
                update(<?php echo $i; ?>,<?php echo $option->size ?>);
    <?php
    $i++;
}
?>
            $('#front_text_' + textDivCount).focus();
        });

        function update(id, size) {
            //alert(size);
            $('#text_' + id).html($('#front_text_' + id).val());
            $('#front_text_large').html($('#front_text_' + id).val());
            $('#front_div_' + id).bt({minfontsize: 20, maxfontsize: size});
            //$('#front_div_' + id).textfill({minFontPixels: 1, maxFontPixels: <?php //echo $product->fontSize   ?>});
            //$('#front_large').textfill({minFontPixels: 2, maxFontPixels: <?php //echo $product->fontSize * 2   ?>});

        }

    </script>

    <script type="text/javascript">


        function saveCart() {
            var price = $('#total_price').val();
            var form = $('#form_add_to_cart').serialize();
            var jqxhr = $.get("../cart/add", form, function () {
                //alert( "Product added to cart."+$('#image').val() );
                window.location = "../cart/view";

            })
                    .done(function () {
                        //alert( "second success" );
                    })
                    .fail(function () {
                        //alert( "error" );
                    })
                    .always(function () {
                        //alert( "finished" );
                    });

        }

        function makeOrderImage() {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#large").show();
            html2canvas($("#large"), {
                onrendered: function (canvas) {
                    theCanvas = canvas;
                    // document.body.appendChild(canvas);
                    var photo = canvas.toDataURL('image/jpeg');
                    $("#large").hide();
                    $.ajax({
                        method: 'POST',
                        type: 'POST',
                        url: '../makeorderimage',
                        data: {
                            photo: photo,
                            _token: CSRF_TOKEN,
                            time: <?php echo time(); ?>
                        },
                        success: function (data) {
                            $('#image').val(data);

                            if (data.length >= 5)
                                saveCart();
                            else
                                alert("Please upload an image");
                        }
                    });
                }
            });


        }


        $('#draggable-zone').mouseleave(function () {

            var top = $("#front_1").css("top");
            var left = $("#front_1").css("left");


            top = parseFloat(top) * 2;
            left = parseFloat(left) * 2;
            $("#front_1_large").css("left", left).css("top", top);
        });

        $('#font_family').change(function () {
            textWr = $('#front_div_' + currentSelectedId);

            var style = $("#font_family").val();


            $(textWr).css('font-family', styles[style]);
            $('#front_text_large').css('font-family', styles[style]);
            update(currentSelectedId)
            // update(currentSelectedId);

        });

        $('.font-style').click(function () {
            var type = $(this).data("type");
            //$("#front_" + currentSelectedId).toggleClass($(this).val());

        });

        function setFontSize()
        {
            var size = $("#size").val();
            if (!isNaN(size)) {
                $("#front_" + currentSelectedId).css("font-size", size + "px");
                size = parseFloat(size) * 2;
                $("#front_" + currentSelectedId + "_large").css("font-size", size + "px");
            }
        }
    </script>






    @endsection






