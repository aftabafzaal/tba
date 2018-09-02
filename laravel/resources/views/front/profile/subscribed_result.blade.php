<?php

use App\Functions\Functions;
?>
<link rel="stylesheet" href="{{asset('front/croppie.css')}}">
<script src="{{asset('front/js/croppie.js')}}"></script>
<form method="POST" action="<?php echo url('collage'); ?>">
    <div class="hed pull-right">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <button type="submit" class="btn btn-primary">Compare Images</button>
    </div>
    @foreach($results as $row)
    <div class="upd__table">          
        <table class="text-center">

            <thead>
                <tr>
                    <th colspan="3" for="Updates 1">{{ $row->caption }}
                        <span class="pull-right">
                            <button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo url('result/delete/' . $row->id); ?>"><i class="fa fa-trash"></i></button>
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="upd__photo__side">
                    <td for="Updates 1">Front Picture</td>
                    <td>Side Picture</td>
                    <td>Back Picture</td>
                </tr>
                <tr class="upd__photos__box">
                    <td for="Updates 1">
                        <div id="success-front-<?php echo $row->id; ?>"></div>
                        <br>
                                        <div class="actions">
                                            <i class="fa fa-rotate-left vanilla-front-rotate-<?php echo $row->id; ?> btn btn-default" data-deg="-90" aria-hidden="true"></i>
                                            <i class="fa fa-rotate-right vanilla-front-rotate-<?php echo $row->id; ?> btn btn-default" data-deg="90" aria-hidden="true"></i>

                                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                            <i class="btn btn-default upload-front-result-<?php echo $row->id; ?> fa fa-save"></i>
                                        </div>
                                        <div class="no-transition" id="front-<?php echo $row->id; ?>" style="">
                                        </div>
                                        <script type="text/javascript">
<?php if (is_null($row->frontImage)) { ?>
    var srcFront<?php echo $row->id; ?> = "{{ asset('front/images/no_result.jpg')}}";
<?php } else { ?>
    var srcFront<?php echo $row->id; ?> = "{{ asset('uploads/users/results/front_images/thumbnail/'. $row->frontImage)}}";
<?php } ?>
var el = document.getElementById('front-<?php echo $row->id; ?>');
vanillaFront<?php echo $row->id; ?> = new Croppie(el, {
    viewport: {width: 200, height: 200},
    boundary: {width: 300, height: 300},
    enableResize: true,
    enableOrientation: true
});
//$('#imgInp').on('change', function () {
//   var reader = new FileReader();
//   reader.onload = function (e) {
vanillaFront<?php echo $row->id; ?>.bind({
    url: srcFront<?php echo $row->id; ?>,
    zoom: 0
}).then(function () {
    console.log('jQuery bind complete');
});

$('.vanilla-front-rotate-<?php echo $row->id; ?>').on('click', function (ev) {
    vanillaFront<?php echo $row->id; ?>.rotate(parseInt($(this).data('deg')));
});

$('.upload-front-result-<?php echo $row->id; ?>').on('click', function (ev) {
    vanillaFront<?php echo $row->id; ?>.result({
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        var _token = $('#_token').val();
        $.ajax({
            url: "<?php echo url('crop'); ?>",
            type: "POST",
            dataType: 'json',
            data: {"image": resp, '_token': _token, "src": srcFront<?php echo $row->id; ?>},
            success: function (data) {
                console.log(data);
                if (data.success === 1) {
                    var errorsHtml = '<div class="alert alert-success"> <i class="fa fa-check"></i> Picture Updated Successfully.</div>';
                    $('#success-front-<?php echo $row->id; ?>').html(errorsHtml).show();
                    setTimeout(function () {
                        location.reload(true);
                    }, 300);
                }
            }
        });
    });
    //
});
                                        </script>

                        <?php
                        $frontImage = public_path() . '/uploads/users/results/front_images/original/' . $row->frontImage;
                        if (file_exists($frontImage)) {
                            ?>
                            <a href="{{asset('uploads/users/results/front_images/original/')}}/<?php echo $row->frontImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                        <?php } else { ?>
                            <a href="{{asset('uploads/users/results/front_images/')}}/<?php echo $row->frontImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                        <?php } ?>
                        <br>
                        <label><input type="checkbox" name="image[<?php echo $row->id ?>][front]" value="<?php echo $row->frontImage; ?>">Select</label>

                    </td>
                    <td>
                        <div id="success-side-<?php echo $row->id; ?>"></div>
                        <br>
                                <div class="actions">
                                    <i class="fa fa-rotate-left vanilla-side-rotate-<?php echo $row->id; ?> btn btn-default" data-deg="-90" aria-hidden="true"></i>
                                    <i class="fa fa-rotate-right vanilla-side-rotate-<?php echo $row->id; ?> btn btn-default" data-deg="90" aria-hidden="true"></i>

                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <i class="btn btn-default upload-side-result-<?php echo $row->id; ?> fa fa-save"></i>
                                </div>
                                <div class="no-transition" id="side-<?php echo $row->id; ?>" style="">
                                </div>
                                <script type="text/javascript">
<?php if (is_null($row->sideImage)) { ?>
                                        var srcSide<?php echo $row->id; ?> = "{{ asset('front/images/no_result.jpg')}}";
<?php } else { ?>
                                        var srcSide<?php echo $row->id; ?> = "{{ asset('uploads/users/results/side_images/thumbnail/'. $row->sideImage)}}";
<?php } ?>
                                    var el = document.getElementById('side-<?php echo $row->id; ?>');
                                    vanilla<?php echo $row->id; ?> = new Croppie(el, {
                                        viewport: {width: 200, height: 200},
                                        boundary: {width: 300, height: 300},
                                        enableResize: true,
                                        enableOrientation: true
                                    });
//$('#imgInp').on('change', function () {
//   var reader = new FileReader();
//   reader.onload = function (e) {
                                    vanilla<?php echo $row->id; ?>.bind({
                                        url: srcSide<?php echo $row->id; ?>,
                                        zoom: 0
                                    }).then(function () {
                                        console.log('jQuery bind complete');
                                    });

                                    $('.vanilla-side-rotate-<?php echo $row->id; ?>').on('click', function (ev) {
                                        vanilla<?php echo $row->id; ?>.rotate(parseInt($(this).data('deg')));
                                    });

                                    $('.upload-side-result-<?php echo $row->id; ?>').on('click', function (ev) {
                                        vanilla<?php echo $row->id; ?>.result({
                                            type: 'canvas',
                                            size: 'viewport'
                                        }).then(function (resp) {
                                            var _token = $('#_token').val();
                                            $.ajax({
                                                url: "<?php echo url('crop'); ?>",
                                                type: "POST",
                                                dataType: 'json',
                                                data: {"image": resp, '_token': _token, "src": srcSide<?php echo $row->id; ?>},
                                                success: function (data) {
                                                    console.log(data);
                                                    if (data.success === 1) {
                                                        var errorsHtml = '<div class="alert alert-success"> <i class="fa fa-check"></i> Picture Updated Successfully.</div>';
                                                        $('#success-side-<?php echo $row->id; ?>').html(errorsHtml).show();
                                                        setTimeout(function () {
                                                            location.reload(true);
                                                        }, 300);
                                                    }
                                                }
                                            });
                                        });
//
                                    });
                                </script>
                        <?php
                        $sideImage = public_path() . '/uploads/users/results/side_images/original/' . $row->sideImage;
                        if (file_exists($sideImage)) {
                            ?>
                            <a href="{{asset('uploads/users/results/side_images/original/')}}/<?php echo $row->sideImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                        <?php } else { ?>
                            <a href="{{asset('uploads/users/results/side_images/')}}/<?php echo $row->sideImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                        <?php } ?>
                        <br>
                        <label><input type="checkbox" name="image[<?php echo $row->id ?>][side]" value="<?php echo $row->sideImage; ?>">Select</label>
                    </td>
                    <td>
                        <div id="success-back-<?php echo $row->id; ?>"></div>
                        <br>
                                <div class="actions">
                                    <i class="fa fa-rotate-left vanilla-back-rotate-<?php echo $row->id; ?> btn btn-default" data-deg="-90" aria-hidden="true"></i>
                                    <i class="fa fa-rotate-right vanilla-back-rotate-<?php echo $row->id; ?> btn btn-default" data-deg="90" aria-hidden="true"></i>

                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <i class="btn btn-default upload-back-result-<?php echo $row->id; ?> fa fa-save"></i>

                                </div>
                                <div class="no-transition" id="back-<?php echo $row->id; ?>" style="">
                                </div>
                                <script type="text/javascript">
<?php if (is_null($row->backImage)) { ?>
                                        var srcBack<?php echo $row->id; ?> = "{{ asset('front/images/no_result.jpg')}}";
<?php } else { ?>
                                        var srcBack<?php echo $row->id; ?> = "{{ asset('uploads/users/results/back_images/thumbnail/'. $row->backImage)}}";
<?php } ?>
                                    var el = document.getElementById('back-<?php echo $row->id; ?>');
                                    vanillaBack<?php echo $row->id; ?> = new Croppie(el, {
                                        viewport: {width: 200, height: 200},
                                        boundary: {width: 300, height: 300},
                                        enableResize: true,
                                        enableOrientation: true
                                    });
//$('#imgInp').on('change', function () {
//   var reader = new FileReader();
//   reader.onload = function (e) {
                                    vanillaBack<?php echo $row->id; ?>.bind({
                                        url: srcBack<?php echo $row->id; ?>,
                                        zoom: 0
                                    }).then(function () {
                                        console.log('jQuery bind complete');
                                    });

                                    $('.vanilla-back-rotate-<?php echo $row->id; ?>').on('click', function (ev) {
                                        vanillaBack<?php echo $row->id; ?>.rotate(parseInt($(this).data('deg')));
                                    });

                                    $('.upload-back-result-<?php echo $row->id; ?>').on('click', function (ev) {
                                        vanillaBack<?php echo $row->id; ?>.result({
                                            type: 'canvas',
                                            size: 'viewport'
                                        }).then(function (resp) {
                                            var _token = $('#_token').val();
                                            $.ajax({
                                                url: "<?php echo url('crop'); ?>",
                                                type: "POST",
                                                dataType: 'json',
                                                data: {"image": resp, '_token': _token, "src": srcBack<?php echo $row->id; ?>},
                                                success: function (data) {
                                                    console.log(data);
                                                    if (data.success === 1) {
                                                        var errorsHtml = '<div class="alert alert-success"> <i class="fa fa-check"></i> Picture Updated Successfully.</div>';
                                                        $('#success-back-<?php echo $row->id; ?>').html(errorsHtml).show();
                                                        setTimeout(function () {
                                                            location.reload(true);
                                                        }, 300);
                                                    }
                                                }
                                            });
                                        });
//
                                    });
                                </script>

                        <?php
                        $backImage = public_path() . '/uploads/users/results/back_images/original/' . $row->backImage;
                        if (file_exists($backImage)) {
                            ?>
                            <a href="{{asset('uploads/users/results/back_images/original/')}}/<?php echo $row->backImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                        <?php } else { ?>
                            <a href="{{asset('uploads/users/results/back_images/')}}/<?php echo $row->backImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                        <?php } ?>
                        <br>
                        <label><input type="checkbox" name="image[<?php echo $row->id ?>][back]" value="<?php echo $row->backImage; ?>">Select</label>

                    </td>
                </tr>
                <tr class="upd__cmt__hdr">
                    <td colspan="3">Current Weight: <?php
                        if ($row->currentWeight != '') {
                            echo $row->currentWeight . ' ' . 'LBS';
                        } else {
                            echo "Not Added Yet";
                        }
                        ?></td>
                </tr>
                <tr class="upd__cmt__hdr">
                    <td colspan="3">
                        <span id="bodyfat_<?php echo $row->id ?>">
                            <span id="t_bodyfat_<?php echo $row->id ?>" > Body Fat Est: <?php
                                if ($row->currentBodyFat != '') {
                                    echo $row->currentBodyFat . ' ' . '%';
                                } else {
                                    echo "Not Added Yet";
                                }
                                ?> </span>
                            <?php if (isset($subscribed) && $subscribed->ambassador_id == Auth::user()->id) { ?>
                                <a class="btn-edit-xs" href="javascript:void(0);" onclick="edit('<?php echo $row->id ?>', 'bodyfat')" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?php } ?>
                        </span>
                        <span style="display:none;" id="edit_bodyfat_<?php echo $row->id ?>">
                            <div class="form-group col-sm-6 pul-cntr">
                                <span>Add Body Fat: </span>
                                <div class="input-group clr">
                                    <input type="number" class="form-control" min="1" step="any" name="v_bodyfat_<?php echo $row->id ?>" id="v_bodyfat_<?php echo $row->id ?>" value="<?php echo $row->currentBodyFat; ?>" placeholder="Current Body Fat">
                                    <span class="input-group-addon">
                                        <a class="btn " href="javascript:void(0);" onclick="save('<?php echo $row->id ?>', 'bodyfat')">Save</a>
                                    </span>

                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
                <tr class="upd__cmt__hdr">
                    <td colspan="2" class="text-left" for="Updates 1"><i class="fa fa-comments-o"></i>Ambassador Reviews</td>
                    <td><i class="fa fa-calendar"></i>{{ $row->date }}</td>
                </tr>
            </tbody>

        </table>
        <div class="upd__review__box clrlist">
            @foreach($messages as $message)
            @if($message->result_id == $row->id)
            <div class="media">
                <div class="media-left">
                    @foreach($users as $u)
                    @if($u->id == $message->user_id)
                    <img src="{{ asset('uploads/users/thumbnail/')}}/<?php echo $u->image; ?>" class="media-object">
                    @endif
                    @endforeach
                </div>
<!--                        <div class="review__online"><img src="{{ asset('front/images/online-icon.png') }}"></div>-->
                <div class="media-body media-body-icon">
                    <p>
                        {{ $message->message }}
                    </p>
                    <ul>
                        <li class="pul-lft"><i class="fa fa-clock-o"></i><?php
                            echo
                            Functions::relativeTime(strtotime($message->created_at), true);
                            ?></li>
                        <li class="pul-rgt"><i class="fa fa-check-circle-o"></i></li>
                    </ul>
                </div>

            </div>
            @endif

            @endforeach
            <?php if (isset($subscribed) && $subscribed->athlete_id == $user->id) { ?>
                <div class="row">
                    <hr>

                    <div class="form-group col-sm-12">
                        <button type="button" data-result-id="{{ $row->id }}" data-toggle="modal" data-target="#review" class="btn btn-lg btn-primary btn-flat pull-right">Add Comment</button>    
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    @endforeach
</form>
@include('front/common/delete_modal')
<script>
    jQuery('.delete').click(function ()
    {
        $('#delete').attr('href', $(this).data('id'));
    });

    function edit(id, type) {
        $("#" + type + "_" + id).hide();
        $("#edit_" + type + "_" + id).show();
    }

    function save(id, type) {
        var value = $("#v_" + type + "_" + id).val();
        $.get("<?php echo url("results/save"); ?>" + type, {value: value, id: id}, function () {
            $("#" + type + "_" + id).show();
            $("#edit_" + type + "_" + id).hide();
            $("#v_" + type + "_" + id).val(value);
            $("#t_" + type + "_" + id).text(value);
        })
                .done(function () {
                    //alert( "second success" );
                    window.location.reload();
                })
                .fail(function () {
                    //alert( "error" );
                })
                .always(function () {
                    //alert( "finished" );
                });
    }
</script>