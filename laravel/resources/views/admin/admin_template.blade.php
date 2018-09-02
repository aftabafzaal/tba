<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{Config::get('params.site_name')}} | Admin Panel</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <!-- Bootstrap 3.3.5 -->
        <link href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css')}}">

        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/skin-blue-light.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.css')}}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datepicker/datepicker3.css')}}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!--        <link rel="stylesheet" href="{{ asset('front/main.css') }}">-->


        <script src="{{ asset('adminlte/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
        <script src="{{ asset('adminlte/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('adminlte/plugins/select2/select2.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/admin-extra.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/colorized.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('front/css/colorpicker.css') }}" />
        <script type="text/javascript" src="{{ asset('front/js/colorpicker.js') }}"></script>
    </head>
    <body class="hold-transition skin-blue-light sidebar-mini">
        <div class="wrapper">
            <!-- Header -->
            @include('admin/commons/header')

            <!-- Sidebar -->
            @include('admin/commons/sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <section class="content">
                    <!-- Your Page Content Here -->
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- Footer -->
            @include('admin/commons/footer')
        </div>

        <script src="{{ asset('adminlte/plugins/ckeditor/ckeditor.js')}}"></script>
        <script src="{{ asset('adminlte/dist/js/app.min.js')}}"></script>
        <script src="{{ asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>



        <script>
$(function () {

    //Timepicker
    //Date picker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayBtn: true,
        todayHighlight: true

    });

});
        </script>
        <script>
            $(document).ready(function () {
                var url = window.location;
                $('.sidebar-menu a[href="' + url + '"]').parent().addClass('active');

                $('.sidebar-menu a[href="' + url + '"]').closest('.treeview').addClass('active');

                $('.sidebar-menu a[href="' + url + '"]').closest('.treeview-menu').css("display", "block");



                $('.sidebar-menu a').filter(function () {
                    return this.href === url;
                }).parent().addClass('active');


            });
        </script>



    </body>
</html>
