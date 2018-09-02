@extends('admin/admin_template')

@section('content')
<?php
$currency = Config::get('params.currency');
$orderPrefix = Config::get('params.order_prefix');
?>
<style>
    .result_img img {
        /*height: 200px;*/
        width: 80%; 
        padding-left: 140px;
        padding-right: 50px;
        /*        padding-bottom: 50px;
                padding-top: 50px;*/
    }

</style>


<div class="row">
    <div class="col-md-12">
        <div class="flash-message">
            
        </div> <!-- end .flash-message -->
        @include('admin.commons.errors')

        <div class="box box-primary">

            <?php
            $user = $data;
            ?>        
            @if($data->status == 1)
            <div class="box-body client__info">

                @else
                <div class="box-body">

                    @endif
                    <div class="row">
                        <div class="col-md-9">

                            <div class="hed col-sm-12">



                            </div>

                            <div class="col-sm-7 client cont p0">

                                <div class="box-header with-border">
                                    <h3 class="box-title"> Customer's Information ( @if($data->role_id == 2) Athlete @elseif($data->role_id == 4) General User @else Ambassador @endif )</h3>
                                </div>
                                <ul>
                                    <li>First Name:  {{ $data->firstName }}</li>
                                    <li>Middle Name: {{ $data->middleName }}</li>
                                    <li>Last Name: {{ $data->lastName }}</li>
                                    <li>Email: {{ $data->email }}</li>
                                    <li>Member Since: {{ date('d M Y',strtotime($data->created_at))}}</li>
                                </ul>
                            </div>

                            <div class="col-sm-5">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> Address Information</h3>
                                </div>
                                <ul>
                                    <li>Address :{{ $data->address }}</li>
                                    <li>Address 2:{{ $data->address2 }}</li>
                                    <li>Phone :{{ $data->phone }}</li>
                                    <!--                                    <li>Mobile :{{ $data->mobile }}</li>-->
                                    <li>Country: {{ $data->countryName }}</li>
                                    <li>State: {{ $data->stateName }}  </li>
                                    <li>City: {{ $data->city }}</li>
                                    <li>Zip Code: {{ $data->zip }}</li>
                                </ul>


                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery('.delete').click(function ()
        {
            $('#delete').attr('href', $(this).data('id'));
        });
    </script>
    @endsection
