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
    #draggable-zone 
    {
        background: url({{ asset('uploads/products/thumbnail')}}/<?php echo $product->image; ?>) 0 0 no-repeat;
        border:     0px solid #000;
        height:     <?php echo $thumbHeight; ?>px;
        overflow:   hidden;
        width:      <?php echo $thumbWidth; ?>px;
        }


        .style-serif{
            color:#ffff00;
            font-weight: 400;
            font-size: 30px;
            font-family: serif;
        }

        .style-serif-large{
            color:#ffff00;
            font-weight: 800;
            font-size: 60px;
            font-family: serif;
        }
    </style>

    <div class="row">
        <div id="my-element" style="width:100px; height:50px;">
            <span>Myasd asdasdasdas asdadasd awesome text!</span>
        </div>

    </div>

    <div class="container">


        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4" >
                <div id="text_fields" class="col-lg-12 col-md-12 col-sm-12"></div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Color:</label>
                    <input  class="form-control" type="text" maxlength="6" size="6" id="color" value="FFFFFF" />
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Font Size (px): </label>
                    <input  class="form-control" onkeyup="setFontSize()" type="text" maxlength="3" size="3" id="size" value="14" />
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Font Family:</label>
                    <select name="font_family" id="font_family" class="form-control">
                        <option selected="selected" value="Roboto">Roboto</option>
                        <option value='"Times New Roman", Times, serif'>Times New Roman</option>
                        <option value="Arial">Arial</option>
                        <option value="Impact">Impact</option>
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

                    <a href="javascript:void(0);" class="btn btn-info" onclick="makeOrderImage()">Finish</a></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6"><div id="draggable-zone" ></div></div>
        </div>
    </div>

    <div id="large" style="display: block;background: url({{ asset('uploads/products')}}/<?php echo $product->image; ?>) 0 0 no-repeat;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;">
        <a href="javascript:void(0);"  data-value="1" data-type="text" id="front_1_large" style="width: 800px; height: auto; left: <?php echo $product->left ?>px; top: <?php echo $product->top ?>px; display: block; position: relative; font-size: 28px; font-family: Roboto;"></a>
    </div>
    <script>


        $('#my-element').textfill({
        });

        function changeImage(attribute_value_id, thumbImage, image)
        {

            $('#draggable-zone').css("background-image", "url('" + thumbImage + "')");
            $('#large').css("background-image", "url('" + image + "')");
            $('#attribute_value_id').val(attribute_value_id);
        }

        $(document).ready(function () {

            addText();
            $('#input_text').focus();
        });

        function addText()
        {
            var textfields = "<p><input class='form-control input_text' onkeyup=\"setText()\" type='text' onfocus=\"setDraggableActions('" + textDivCount + "')\" data-value='" + textDivCount + "' id='front_text_" + textDivCount + "' placeHolder='Name' /></p>";
            var textDiv = "<div href='javascript:void(0);' data-value='" + textDivCount + "' data-type='text' id='front_" + textDivCount + "' style='width: <?php echo $product->textWidth ?>px; height:50px; left: <?php echo $product->left ?>px; top: <?php echo $product->top ?>px;display: block;position:relative;' class='style-serif' ><span>My awesome text!</span></div>";
            $("#text_fields").append(textfields);
            $("#draggable-zone").append(textDiv);
            $('#front_' + textDivCount).textfill();
            //addTextWr(textDivCount);
            
            
             $('#front_').textfill({
        });
            textDivCount++;
        }
    </script>
    @endsection






