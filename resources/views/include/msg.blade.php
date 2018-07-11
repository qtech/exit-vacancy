@if(session('error'))
<div id="" class="alert alert-danger">
	<strong style="font-weight: 700; font-size: 16px;"><i class="fas fa-exclamation-triangle"></i> {{session('error')}}</strong>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
	<strong style="font-weight: 700; font-size: 16px;"><i class="fas fa-check"></i> {{session('success')}}</strong>
</div>
@endif

@if(count($errors)>0)
	@foreach($errors->all() as $error)
	<div class="alert alert-danger">
		<strong style="font-weight: 700; color: #FFFFFF"><i class="fas fa-exclamation-triangle"></i> {{$error}}</strong>
	</div>
	@endforeach
@endif
