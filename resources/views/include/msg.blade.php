@if(session('error'))
<div id="" class="label label-danger">
	<strong style="font-weight: 700; font-size: 16px;">{{session('error')}}</strong>
</div>
@endif

@if(session('success'))
<div class="label label-primary">
	<strong style="font-weight: 700; font-size: 16px;">{{session('success')}}</strong>
</div>
@endif

@if(count($errors)>0)
	@foreach($errors->all() as $error)
	<div class="label label-danger">
		<strong style="font-weight: 700; color: #FFFFFF">{{$error}}</strong>
	</div>
	@endforeach
@endif
