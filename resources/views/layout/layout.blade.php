<!DOCTYPE html>
<html>
    
<!-- Mirrored from themesdesign.in/upbond_1.1/layouts/green/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 11 Jul 2018 12:12:56 GMT -->
<head>
        <title>{{config('app.name')}}</title>
        
        <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{asset('/assets/plugins/morris/morris.css')}}">

        <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" type="text/css">

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            @include('include.navbar')
            <!-- Top Bar End -->
            <!-- ========== Left Sidebar Start ========== -->
            @include('include.sidebar')
            <!-- Left Sidebar End -->
            <!-- Start right Content here -->

            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="{{asset('/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('/assets/js/detect.js')}}"></script>
        <script src="{{asset('/assets/js/fastclick.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('/assets/js/waves.js')}}"></script>
        <script src="{{asset('/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.scrollTo.min.js')}}"></script>

        <!--Morris Chart-->
        <script src="{{asset('/assets/plugins/morris/morris.min.js')}}"></script>
        <script src="{{asset('/assets/plugins/raphael/raphael-min.js')}}"></script>

        <script src="{{asset('/assets/pages/dashborad.js')}}"></script>

        <script src="{{asset('/assets/js/app.js')}}"></script>

    </body>

<!-- Mirrored from themesdesign.in/upbond_1.1/layouts/green/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 11 Jul 2018 12:14:04 GMT -->
</html>