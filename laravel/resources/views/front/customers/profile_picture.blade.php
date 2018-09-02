@extends('customer')
@section('content')
<?php
$required = 'required';
?>
<section class="dashboard-area">
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        #img-upload{
            width: 100%;
            height: 100%;
        }

    </style>

    <div class="container">
        <div class="dash__lft col-sm-3">
            <div class="dash__tabs">
                @include('front/common/left')
            </div>
        </div>
        <div class="dash__rgt col-sm-9">
            <div class="tab-content">
                <div id="profile" class="tab-pane fade active in">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable clrlist listview">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Whoops!</strong> There were some problems with your input.<br/>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="profile__photo">
                        <div class="form-group text-center">
                            @if($user->image != '')
                            <img id='img-upload1' src="{{ asset('/uploads/users/thumbnail/')}}/<?php echo $user->image; ?>" alt="{{$user->firstName}} {{$user->middleName}} {{$user->lastName}}" style="width:270px;height: 260px;">
                            @else
                            <img id='img-upload1' src="{{ asset('/front/images/no_result.jpg')}}" alt="{{$user->firstName}} {{$user->middleName}} {{$user->lastName}}" style="width:270px;height: 260px;">
                            @endif
                        </div>
                        {!! Form::open(array('files' => true,'class' => 'form','url' => 'changeprofileimage', 'method' => 'post', 'id' => 'coverForm')) !!}
                        <div class="text-center form-group" aria-hidden="0" id="select1">
                            <span class="btn btn-primary btn-file btn-lg">
                                Select Image <input type="file" uploader="uploader" id="imgInp1" name="image">
                            </span>
                        </div>
                        <div class="text-center form-group " aria-hidden="0" id="upload1" style="display:none;">

                            <button class="btn btn-primary btn-file btn-lg" onclick="document.getElementById('coverForm').submit()">Upload</button>
                            <button type="button" class="btn btn-file btn-lg btn-outline" id="cancel1">Cancel</button>

                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<script>
    $(document).ready(function () {
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-upload1').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInp1").change(function () {
            readURL1(this);
        });
        document.getElementById('imgInp1').addEventListener('change', function () {
            var style = this.value === '' ? 'block' : 'none';
            var upload = this.value === '' ? 'none' : 'block';
            document.getElementById('select1').style.display = style;
            document.getElementById('upload1').style.display = upload;
        });

        $('#cancel1').on('click', function () {
            document.getElementById('upload1').style.display = 'none';
            document.getElementById('select1').style.display = 'block';
            location.reload();
        }
        );
    });

</script>
@endsection