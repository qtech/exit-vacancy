@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">Hotel Emails</h3>
                <a href="{{route('h.addmail')}}" class="btn btn-custom pull-right">Send Mail</a>
            </div>
        </div>
    </div>
</header>
<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Time</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($mail as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->created_at->format('d-m-y')}}</td>
                    <td>{{$value->created_at->format('H:i')}}</td>
                    <td>{{$value->title}}</td>
                    <td>{{$value->message}}</td>
<td>
    <a href="#" style="border-bottom:none;" data-toggle="modal" data-target="#myModal{{$value->notification_id}}"><i class="fa fa-trash" style="color:red; font-size:1.3em;"></i></a>

    <div class="modal fade" id="myModal{{$value->notification_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="myModalLabel">Confirm Action</h4>
				</div>
				<div class="modal-body">
					<h6>Are you sure you want to delete this email: <code>{{$value->title}}</code> ?</h6>
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
                    <a class="btn btn-rounded btn-danger" href="{{route('h.deletenotification',['id' => $value->notification_id])}}" class="btn btn-danger">Delete</a>
                </div>
			</div>
		</div>
	</div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection