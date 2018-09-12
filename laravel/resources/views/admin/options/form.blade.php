<?php
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('name') !!}
    {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Text Limit') !!}
    {!! Form::text('textLimit', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Text Top Position') !!}
    {!! Form::text('topPosition', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Text Left Position') !!}
    {!! Form::text('leftPosition', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Text Width') !!}
    {!! Form::text('width', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Front Text Height') !!}
    {!! Form::text('height', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Font Color') !!}
    {!! Form::text('color', null , array('class' => 'form-control','id' => 'color') ) !!}
</div>

<div class="form-group">
    {!! Form::label('Font Size') !!}
    {!! Form::text('size', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group" >
    {!! Form::label('Style') !!}
    {!!Form::select('style_id',$styles,null,array('class' => 'form-control select','id'=>'style_id'))!!}
</div>
<input type="hidden" value="<?php echo $product_id?>" id="product_id" name="product_id"/>
<div class="form-group">
    <div class="col-sm-4">
        <button type="submit" value="products" class="btn btn-primary btn-block btn-flat">Save</button>
    </div>
    <div class="col-sm-4">
        <a href="{{ url('admin/products')}}" class="btn btn-warning btn-block btn-flat">Cancel</a>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select").select2();
        
        $('#color').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val(hex);
    		$(el).ColorPickerHide();
    	},
    	onBeforeShow: function () {
    		$(this).ColorPickerSetColor(this.value);
    	},
        onChange: function (hsb, hex, rgb) {
                        $('#color').val(hex);
                        
                    }
    })
    .bind('keyup', function(){
    	$(this).ColorPickerSetColor(this.value);
    });
    
    });
</script>