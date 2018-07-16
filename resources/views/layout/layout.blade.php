<!DOCTYPE html>
<html>
<head>
        <title>{{config('app.name')}}</title>
        
        <link rel="shortcut icon" href="{{asset('logo.png')}}">

        {{-- DATA-TABLES --}}
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{asset('/assets/plugins/morris/morris.css')}}">

        <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
			@yield('content')
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

        {{-- DATA-TABLES --}}
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>
    </body>
</html>