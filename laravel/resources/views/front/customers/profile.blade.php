@extends('customer')

@section('content')
<?php
$role = Auth::user()->role->role;
?>
<section class="dashboard-area">
    <div class="container">
        <div class="dash__lft col-sm-3">
            <div class="dash__tabs">
                @include('front/common/left')
            </div>
        </div>
        <div class="dash__rgt col-sm-9">
            <div class="tab-content">
                <div id="profile" class="tab-pane fade active in">
                    @include('front/common/errors')
                    <!--
                                                    <div class="hed">
                                                    <h2>UPLOADED <span>Shows</span></h2>
                                                </div>-->

                    <div class="profile__dtl col-sm-12">
                        <div class="profile__btns clrlist">
                            <ul class="pul-rgt">
                                <li>
                                    @if($user->availability == '1' && $role == 'ambassador')
                                    <a href="<?php echo url('user/unavailable/' . $user->id); ?>" class="btn btn-primary "><i class="fa fa-warning"></i> Unavailable</a>
                                    @elseif($user->availability == '0' && $role == 'ambassador')
                                    <a href="<?php echo url('user/available/' . $user->id); ?>" class="btn btn-primary "><i class="fa fa-check-square-o"></i> Available</a>
                                    @endif
                                </li>
                                @if($user->status == 1)
                                <li><a href="#" class="profile__approve__btn"><i class="fa fa-check-square-o"></i>Approved</a></li>
                                @endif
                                <li><a href="{{url('profile/edit')}}" class="profile__edit__btn"><i class="fa fa-pencil"></i>Edit Profile</a></li>
                            </ul>
                        </div>


                        <div class="clearfix"></div>

                        <div class="profile__info">

                            

                            <div class="label-box col-sm-6">
                                <h5>Name:</h5>
                                <h4>{{$user->firstName}} {{$user->middleName}} {{$user->lastName}}</h4>
                            </div>

                            <div class="label-box col-sm-6">
                                <h5>Email:</h5>
                                <h4>{{$user->email}}</h4>
                            </div>
                            <div class="label-box col-sm-6">
                                <h5>Phone:</h5>
                                <h4>{{$address->phone}}</h4>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  


@endsection