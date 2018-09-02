@extends('customer')

@section('content')
<section class="dashboard-area">
    <div class="container">
        <div class="dash__lft col-sm-3">
            <div class="dash__tabs">
                @include('front/common/left')
            </div>
        </div>
        <div class="dash__rgt col-sm-9">
            <div id="profile" >
                <div class="profile__dtl col-sm-12">
                    <div class="profile__btns clrlist">
                        <ul class="pul-rgt">
                            @if($user->status == 1)
                            <li><a href="#" class="profile__approve__btn"><i class="fa fa-check-square-o"></i>Approved</a></li>
                            @endif
                            <li><a href="{{url('address/edit')}}" class="profile__edit__btn"><i class="fa fa-pencil"></i>Edit</a></li>
                        </ul>
                    </div>

                    <div class="clearfix"></div>

                    <div class="profile__info">
                        <!--table>
                            <tbody>
                                <tr>
                                    <td for="Updates 1">Address 1:</td>
                                    <td>{{$address->address}}</td>
                                </tr>
                                <tr>
                                    <td for="Updates 1">Address 2:</td>
                                    <td>{{$address->address2}}</td>
                                </tr>
                                <tr>
                                    <td for="Updates 1">Country:</td>
                                    <td>@foreach($countries as $country)
                                    @if($address->country == $country->id)  
                                    {{ $country->name}}
                                    @endif
                                    @endforeach</td>
                                </tr>
                                <tr>
                                    <td for="Updates 1">State:</td>
                                    <td>@foreach($states as $state)
                                    @if($address->state == $state->code)  
                                    {{ $state->title}}
                                    @endif
                                    @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td for="Updates 1">City:</td>
                                    <td>{{$address->city}}</td>
                                </tr>
                                <tr>
                                    <td for="Updates 1">Zipcode:</td>
                                    <td>{{$address->zip}}</td>
                                </tr>
                                
                            </tbody>
                        </table-->

                        <div class="label-box col-sm-6">
                            <h5>Address 1:</h5>
                            <h4>{{$address->address}}</h4>
                        </div>
                        <div class="label-box col-sm-6">
                            <h5>Address 2:</h5>
                            <h4>{{$address->address2}}</h4>
                        </div>
                        <div class="label-box col-sm-3">
                            <h5>Country:</h5>
                            <h4>@foreach($countries as $country)
                                @if($address->country == $country->id)  
                                {{ $country->name}}
                                @endif
                                @endforeach</h4>
                        </div>
                        <div class="label-box col-sm-3">
                            <h5>State:</h5>
                            <h4>@foreach($states as $state)
                                @if($address->state == $state->id)  
                                {{ $state->name}}
                                @endif
                                @endforeach
                            </h4>
                        </div>
                        <div class="label-box col-sm-3">
                            <h5>City:</h5>
                            <h4>
                                {{ $address->city}}
                            </h4>
                        </div>
                        <div class="label-box col-sm-3">
                            <h5>Zipcode:</h5>
                            <h4>{{$address->zip}}</h4>
                        </div>




                    </div>
                </div>

            </div>
        </div>
</section> 

@endsection