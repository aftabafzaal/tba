<?php

use App\Functions\Functions;
?>
@foreach($results as $row)
<div class="upd__table">          
    <table class="text-center">

        <thead>
            <tr>
                <th colspan="3" for="Updates 1">{{ $row->caption }}</th>
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
                    <div class="upd__photos">
                        @if(is_null($row->frontImage))
                        <img  alt="" src="{{ asset('front/images/no_result.jpg')}}"/>
                        @else
                        <img src="{{ url('uploads/users/results/front_images/thumbnail/'. $row->frontImage)}}">
                        @endif
                    </div>
                    <?php
                    $frontImage = public_path() . '/uploads/users/results/front_images/original/' . $row->frontImage;
                    if (file_exists($frontImage)) {
                        ?>
                        <a href="{{asset('uploads/users/results/front_images/original/')}}/<?php echo $row->frontImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                    <?php } else { ?>
                        <a href="{{asset('uploads/users/results/front_images/')}}/<?php echo $row->frontImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                    <?php } ?>

                </td>
                <td>
                    <div class="upd__photos">
                        @if(is_null($row->sideImage))
                        <img  alt="" src="{{ asset('front/images/no_result.jpg')}}"/>
                        @else
                        <img src="{{ url('uploads/users/results/side_images/thumbnail/'. $row->sideImage)}}">
                        @endif                             
                    </div>
                    <?php
                    $sideImage = public_path() . '/uploads/users/results/side_images/original/' . $row->sideImage;
                    if (file_exists($sideImage)) {
                        ?>
                        <a href="{{asset('uploads/users/results/side_images/original/')}}/<?php echo $row->sideImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                    <?php } else { ?>
                        <a href="{{asset('uploads/users/results/side_images/')}}/<?php echo $row->sideImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                    <?php } ?>
                </td>
                <td>
                    <div class="upd__photos">
                        @if(is_null($row->backImage))
                        <img  alt="" src="{{ asset('front/images/no_result.jpg')}}"/>
                        @else                                 
                        <img src="{{ url('uploads/users/results/back_images/thumbnail/'. $row->backImage)}}">
                        @endif
                    </div>
                    <?php
                    $backImage = public_path() . '/uploads/users/results/back_images/original/' . $row->backImage;
                    if (file_exists($backImage)) {
                        ?>
                        <a href="{{asset('uploads/users/results/back_images/original/')}}/<?php echo $row->backImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                    <?php } else { ?>
                        <a href="{{asset('uploads/users/results/back_images/')}}/<?php echo $row->backImage; ?>" class="btn btn-primary mb20" target="_blank">View Enlarge</a>
                    <?php } ?>
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
    </div>
</div>
@endforeach