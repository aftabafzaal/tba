<div class="col-xs-4 border-right p0">
    @if($user->status == '1')
    <a href="<?php echo url('admin/user/disapprove/' . $user->id); ?>" class="btn btn-sm btn-default dissapprove"> Disapprove</a>
    @else
    <a href="<?php echo url('admin/user/approve/' . $user->id); ?>" class="btn btn-sm  btn-default approve">Approve</a>
    @endif
</div>
@if($user->role_id == '3')
<div class="col-xs-4 border-right">
    <a href="<?php echo url('admin/user/edit/' . $user->id); ?>" class="btn btn-sm  btn-default commission">Commission</a>
</div>

<div class="col-xs-4">
    @if($user->availability == '1')
    <a href="<?php echo url('admin/user/unavailable/' . $user->id); ?>" class="btn btn-sm btn-default dissapprove"> Unavailable</a>
    @else
    <a href="<?php echo url('admin/user/available/' . $user->id); ?>" class="btn btn-sm  btn-default approve"> Available</a>
    @endif
</div>
@endif