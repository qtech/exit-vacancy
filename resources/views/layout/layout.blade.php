<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>ExitVacancy</title>

	<style>
		input[type=number]::-webkit-inner-spin-button, 
		input[type=number]::-webkit-outer-spin-button { 
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			margin: 0; 
		}
	</style>
	<script src="{{asset('/n-asset/js/lib/jquery/jquery-3.2.1.min.js')}}"></script>
	
	{{-- DATATABLE --}}
	<link rel="stylesheet" href="{{asset('/n-asset/css/lib/datatables-net/datatables.min.css')}}">
	<link rel="stylesheet" href="{{asset('/n-asset/css/separate/vendor/datatables-net.min.css')}}">
	<link rel="stylesheet" href="{{asset('/n-asset/css/lib/bootstrap-table/bootstrap-table.min.css')}}">

	{{-- TAGS INPUT --}}
	<link rel="stylesheet" href="{{asset('/n-asset/css/separate/vendor/tags_editor.min.css')}}">

	{{-- SELECT 2 --}}
	<link rel="stylesheet" href="{{asset('/n-asset/css/separate/vendor/select2.min.css')}}">

    <link rel="stylesheet" href="{{asset('/n-asset/css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/n-asset/css/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/n-asset/css/main.css')}}">
</head>
<body class="with-side-menu">

	@include('include.navbar')<!--.site-header-->

	@include('include.sidebar')<!--.side-menu-->

	<div class="page-content">
		<div class="container-fluid">
			@include('include.msg')
			@yield('content')
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<script src="{{asset('/n-asset/js/lib/popper/popper.min.js')}}"></script>
	<script src="{{asset('/n-asset/js/lib/tether/tether.min.js')}}"></script>
	<script src="{{asset('/n-asset/js/lib/bootstrap/bootstrap.min.js')}}"></script>
	<script src="{{asset('/n-asset/js/plugins.js')}}"></script>



	{{-- BOOTSTRAP NOTIFY --}}
	<script src="{{asset('/n-asset/js/lib/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
	<script src="{{asset('/n-asset/js/lib/bootstrap-notify/bootstrap-notify-init.js')}}"></script>
	
	{{-- TAGS _ INPUT --}}
	<script src="{{asset('/n-asset/js/lib/jquery-tag-editor/jquery.tag-editor.min.js')}}"></script>
	<script>
		$(function() {
			$('#tags-editor-textarea').tagEditor();
		});
	</script>

	{{-- WIDGETS --}}
	<link rel="stylesheet" href="{{asset('/n-asset/css/separate/pages/widgets.min.css')}}">

	{{-- SELECT 2 --}}
	<script src="{{asset('/n-asset/js/lib/select2/select2.full.min.js')}}"></script>

	{{-- DATATABLE --}}
	<script src="{{asset('/n-asset/js/lib/datatables-net/datatables.min.js')}}"></script>
	<script>
		$(function() {
			$('#example').DataTable();
		});
	</script>
	<script src="{{asset('/n-asset/js/lib/bootstrap-table/bootstrap-table.js')}}"></script>
	<script src="{{asset('/n-asset/js/lib/bootstrap-table/bootstrap-table-export.min.js')}}"></script>
	<script src="{{asset('/n-asset/js/lib/bootstrap-table/tableExport.min.js')}}"></script>
	<script src="{{asset('/n-asset/js/lib/bootstrap-table/bootstrap-table-init.js')}}"></script>
    
<script src="{{asset('/n-asset/js/app.js')}}"></script>
</body>
</html>