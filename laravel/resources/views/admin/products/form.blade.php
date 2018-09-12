<?php
$required = "required";



?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('name') !!}
    {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group" style="display: none;">
    {!! Form::label('attibutes') !!}
    {!!Form::select('attibutes',$attributes,$productAttributes,array('class' => 'form-control select','multiple'=>'multiple','name'=>'attributes[]'))!!}
</div>

<div class="form-group">
    {!! Form::label('Url (Key)') !!}
    {!! Form::text('key',$url, array('class' => 'form-control',$required)) !!}
</div>
<div class="form-group">
    {!! Form::label('price') !!}
    {!! Form::text('price', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('image') !!}
    {!! Form::file('image', null,array($required,'class'=>'form-control')) !!}
</div>
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