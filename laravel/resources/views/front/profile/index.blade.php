@extends('layout')

@section('content')
<?php
$athlete_id = Auth::user()->id;
$currency = Config::get('params.currency');
$required = "";
?>

<div class="container">

    <div class="col-lg-12 col-sm-12 mb40">

        <div class="flash-message">
            @include('front.common.errors')
        </div> <!-- end .flash-message -->

        <div class="card hovercard">
            <div class="card-background">
                @if(is_null($user->image))
                <img class="card-bkimg" alt="" src="{{ asset('front/images/stories-bg.jpg')}}">
                @endif
                <img class="card-bkimg" alt="" src="{{ asset('uploads/users')}}/<?php echo $user->image; ?>">
            </div>
            <div class="useravatar">
                @if(is_null($user->image))
                <img class="card-bkimg" alt="" src="{{ asset('front/images/no_result.jpg')}}"/><br>
                @else
                <img src="{{ asset('uploads/users')}}/<?php echo $user->image; ?>" alt="" /><br>
                @endif

            </div>
            <div class="card-info"> 
                <span class="card-title">
                    {{$user->firstName}} {{$user->middleName}} {{$user->lastName}} 
                </span>
                <p>

                    @if(is_null($specialities)) Not Added @else {{ $specialities->title }} @endif
                </p>      
            </div>
        </div>

        <div class="btn-pref btn-group btn-group-justified btn-group-lg" id="stars" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    <div class="hidden-xs">Personal</div>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button"  class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    <div class="hidden-xs">Professional</div>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="fa fa-info" aria-hidden="true"></span>
                    <div class="hidden-xs">Contact Info</div>
                </button>
            </div>
        </div>


        <div class="holder">
            <div class="tab-content overload bdr0">

                <div class="tab-pane fade in active" id="tab1">       
                    <table class="table table-bordered col-md-12 col-lg-12 table-hover">
                        <tbody> 
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{date('d/m/Y',strtotime($user->dob))}}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>@if($user->gender == 'f') Female @else Male @endif</td>
                            </tr>

                            <tr>
                                <td >Height:</td>
                                <td>{{$user->height}} Feet</td>
                            </tr>
                            <tr>
                                <td >Weight:</td>
                                <td>{{$user->weight}} LBS</td>
                            </tr>

                            <tr>
                                <td for="Updates 1">Medical Concerns:</td>
                                <td>{{$user->medicalConcerns}}</td>
                            </tr>                 
                        </tbody>
                    </table>    

                </div>


                <div class="tab-pane bdr1 aboutme-area col-sm-12 " id="tab2">
                    <!--                <div class=" col-md-12 col-lg-12 "> -->
                    <table class="table table-bordered col-md-12 col-lg-12 table-hover">
                        <tbody> 
                        <div class="profile__desc0">
                            <h4>About me:</h4>
                            <p>
                                @if($user->about !== Null && $user->about !== ''){{$user->about}} @else Not Added yet @endif
                            </p>
                        </div>
                        <div class="profile__desc0">
                            <h4>Goals:</h4>
                            <p>
                                {{$user->goals}}
                            </p>
                        </div>
                        <div class="profile__desc0">
                            @if($user->isCompetitor == 1)
                            <h4>Federation:</h4>
                            <p>
                                {{$user->federation}}
                            </p>
                            @endif
                        </div>         
                        <div class="profile__desc0">
                            <h4>Experience:</h4>
                            <p>
                                @if($user->experience !== Null){{$user->experience}}+ years @else Not added yet @endif
                            </p>
                        </div>
                        </tbody>
                    </table>

                    <!--                </div>-->
                </div>


                <div class="tab-pane  bdr1 aboutme-area col-sm-12 " id="tab3">

                    <div class="profile__desc0">
                        <h4>Email</h4>
                        <p>{{$user->email}}</p>
                    </div>


                    <div class="profile__desc0">
                        <h4>Phone:</h4>
                        <p>{{$address->phone}}</p>
                    </div>
                    <div class="profile__desc0">
                        <h4>Country</h4>
                        <p>@foreach($countries as $country)
                            @if($address->country == $country->id)  
                            {{ $country->name}}
                            @endif
                            @endforeach</p>
                    </div>
                    <div class="profile__desc0">
                        <h4>State:</h4>
                        <p>@foreach($states as $state)
                            @if($address->state == $state->code)  
                            {{ $state->title}}
                            @endif
                            @endforeach</p>

                    </div>
                </div>

            </div>

        </div>
        <div class="nextshow col-md-12 p0">
            <h3>Date of Next Show:</h3>
            <p>@if(is_null($shows)) No Date
                @else
                {{ date('d/m/Y', strtotime($shows->date)) }}
                @endif
            </p>
        </div>
        @include('front/profile/'.$role)
    </div>


</div>

<script>
    $(document).ready(function () {
        $(".btn-pref .btn").click(function () {
            $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
            // $(".tab").addClass("active"); // instead of this do the below 
            $(this).removeClass("btn-default").addClass("btn-primary");
        });
    });
</script>
@endsection
