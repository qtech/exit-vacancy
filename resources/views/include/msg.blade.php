@if(session('error'))
<div class="alert alert-danger alert-dismissible fade in">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	</button>
	<strong>{{session('error')}}</strong>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	</button>
	<strong>{{session('success')}}</strong>
</div>
@endif

@if(count($errors)>0)
	@foreach($errors->all() as $error)
	<div class="alert alert-danger alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>{{$error}}</strong>
	</div>
	@endforeach
@endif
