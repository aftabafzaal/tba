@if (count($errors) > 0)
<div class="">
    <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@if (Session::has('success'))
<div class="">
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h4><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</h4>
</div>
</div>
@endif
@if (Session::has('danger'))
<div class="">
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <h5>{!! session('danger') !!}</h5>
</div>
</div>
@endif
