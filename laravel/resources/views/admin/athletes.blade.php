@extends('admin/admin_template')

@section('content')
<section class="content-header">
      <h1>
       Athletes( Total : {{ count($model) }} )
        <!-- <small>Version 2.0</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Athletes</li>
      </ol>   
</section>

<section class="content">
      <div class="flash-message">
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
      @endforeach
      </div> <!-- end .flash-message -->
<div class="row">

@foreach($model as $user)
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <!-- <div class="widget-user-header bg-aqua-active"> -->
            @if($user->status == '1')
            <div class="widget-user-header bg-success">
            @else
            <div class="widget-user-header bg-danger">
            @endif
            <h4 class="widget-user-username"><a href="<?php echo url('admin/client/'.$user->id);?>" > {{$user->firstName}} {{$user->lastName}}</a></h4>
            <h5 class="widget-user-desc">Member Since: {{ date('d M Y',strtotime($user->created_at))}}</h5>
            </div>
            <div class="widget-user-image">
            
            @if($user->image == '')
            <img class="img-circle" src="{{ asset('front/images/usr.jpg')}}" alt="User Avatar">
            @else
            <img class="img-circle" src="{{ asset('uploads/users/'.$user->image) }}" alt="User Avatar">
            @endif
            </div>
            
           
            <div class="box-footer">
           
            <br>
              @include('admin/commons/users_action')
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
          </div>
@endforeach
      
      </div>

 <?php echo $model->render(); ?>
</section>      

@endsection