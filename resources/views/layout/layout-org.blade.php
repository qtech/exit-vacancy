<!DOCTYPE html>
<html>
<head>
        <title>{{config('app.name')}}</title>
        <link rel="shortcut icon" href="{{asset('logo.png')}}">
        <style>
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                margin: 0; 
            }
        </style>
        {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> --}}
        {{-- MULTI SELECT CSS --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        
        {{-- TAGS INPUT CSS --}}
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
        
        {{-- DROP-ZONE --}}
        <link href="{{asset('/assets/plugins/dropzone/dist/dropzone.css')}}" rel="stylesheet" type="text/css">
        
        {{-- DATA-TABLES --}}
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{asset('/assets/plugins/morris/morris.css')}}">
        
        <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="{{asset('/assets/js/jquery.min.js')}}"></script>
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
        <script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('/assets/js/detect.js')}}"></script>
        <script src="{{asset('/assets/js/fastclick.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.blockUI.js')}}"></script>
        {{-- <script src="{{asset('/assets/js/waves.js')}}"></script> --}}
        <script src="{{asset('/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.scrollTo.min.js')}}"></script>

        <!--Morris Chart-->
        {{-- <script src="{{asset('/assets/plugins/morris/morris.min.js')}}"></script> --}}
        <script src="{{asset('/assets/plugins/raphael/raphael-min.js')}}"></script>
        {{-- <script src="{{asset('/assets/pages/dashborad.js')}}"></script> --}}
        <script src="{{asset('/assets/js/app.js')}}"></script>

        {{-- DROP-ZONE --}}
        <script src="{{asset('/assets/plugins/dropzone/dist/dropzone.js')}}"></script>

        {{-- DATA-TABLES --}}
        {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

        <script>
            var config = {
                baseurl:'{{url("/")."/"}}'
            };
        </script>
    </body>
</html>