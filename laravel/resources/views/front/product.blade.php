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
<script>


</script>
<style>
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
                </div>
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

    <div id="large" style="height:200px;display: none;background: url({{ asset('uploads/products')}}/<?php echo $product->image; ?>) 0 0 no-repeat;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;">
        <div  data-value="1" data-type="text" id="front_large" style="line-height: 1.5;display: inline-block;text-align: center;width: <?php echo $product->textWidth * 2; ?>px; padding-left: <?php echo $product->left * 2 ?>px; padding-top: <?php echo $product->top * 2 ?>px; display: block; position: relative;"><span id='front_text_large' style='font-size:<?php echo $product->fontSize * 2 ?>px;font-weight:<?php echo $product->fontWeight * 2 ?>;color:#<?php echo $product->color ?>;font-family:<?php echo $styles[$product->style]; ?>; '  ></span></div>
    </div>

    <script>
        var textDivCount = 1;
        var currentSelectedId = "0";
        var perviousSelectedId = "";
        var styles =<?php echo json_encode($styles) ?>;

        function changeImage(attribute_value_id, thumbImage, image)
        {
            $('#draggable-zone').css("background-image", "url('" + thumbImage + "')");
            $('#large').css("background-image", "url('" + image + "')");
            $('#attribute_value_id').val(attribute_value_id);
        }

        function addText()
        {
            var textfields = "<p><input maxlength='<?php echo $product->textLimit ?>' class='form-control input_text' onkeyup=\"setText()\" type='text' onfocus=\"setDraggableActions('" + textDivCount + "')\" data-value='" + textDivCount + "' id='front_text_" + textDivCount + "' placeHolder='Name' /></p>";
            var textDiv = "<div data-value='" + textDivCount + "' data-type='text' id='front_div_" + textDivCount + "' style='height:100px;line-height: 1.5;display: inline-block;width: <?php echo $product->textWidth; ?>px;left: <?php echo $product->left ?>px;top: <?php echo $product->top ?>px;position:relative;text-align: center;' ><span id='text_" + textDivCount + "' style='font-size:<?php echo $product->fontSize ?>px;font-weight:<?php echo $product->fontWeight ?>;display: inline-block; color:#<?php echo $product->color ?>;font-family:<?php echo $styles[$product->style]; ?>;' ></span></div>";
            $("#text_fields").append(textfields);
            $("#draggable-zone").append(textDiv);
            textDivCount++;
        }

        function setText()
        {
            var text = $("#front_text_" + currentSelectedId).val();
            $("#front_" + currentSelectedId).text(text);
            update(currentSelectedId);
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
            update(1);
            addText();
            $('#front_text_' + textDivCount).focus();
        });

        function update(id) {
            $('#text_' + id).html($('#front_text_' + id).val());
            $('#front_text_large').html($('#front_text_' + id).val());
            $('#front_div_' + id).textfill({minFontPixels: 10, maxFontPixels: <?php echo $product->fontSize ?>, changeLineHeight: true, widthOnly: false});
            $('#front_large').textfill({minFontPixels: 20, maxFontPixels: <?php echo $product->fontSize *2 ?>, changeLineHeight: true, widthOnly: false});

        }

    </script>
    @endsection






