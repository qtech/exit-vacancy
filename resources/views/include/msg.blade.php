@if(session('error'))
<script>
	$(document).ready(function(){
		$.notify({
			icon: 'font-icon font-icon-warning',
			title: '<strong>Error!</strong>',
			message: '{{session('danger')}}'
		}, {
			type: 'danger'
		});
	});
</script>
@endif

@if(session('success'))
<script>
$(document).ready(function(){
	$.notify({
		icon: 'font-icon font-icon-check-circle',
		title: '<strong>Success!</strong>',
		message: '{{session('success')}}'
	}, {
		type: 'success'
	});
});
</script>
@endif

@if(count($errors)>0)
	@foreach($errors->all() as $error)
	<script>
		$(document).ready(function(){
			$.notify({
				icon: 'font-icon font-icon-warning',
				title: '<strong>Error!</strong>',
				message: '{{$error}}'
			}, {
				type: 'danger'
			});
		});
	</script>
	@endforeach
@endif
