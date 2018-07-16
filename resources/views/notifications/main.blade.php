@extends('layout.layout')

@section('content')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="page-content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                @include('include.msg')
                                <a href="{{route('addnotification')}}" class="btn btn-warning pull-right">Add</a>
                                    <h4 class="m-b-30 m-t-0">Notifications</h4>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                    <table id="example" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Title</th>
                                                            <th>Message</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($notification as $value)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$value->title}}</td>
                                                            <td>{{$value->message}}</td>
<td>
<a href="#" data-toggle="modal" data-target="#custom-width-modal{{$value->notification_id}}"><i class="ti-trash" style="color:red; font-size:1.3em;"></i></a>
<div id="custom-width-modal{{$value->notification_id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Confirm Action</h4>
            </div>
            <div class="modal-body">
            <h4>Are you sure you want to delete this notification: <code>{{$value->title}}</code> ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <a href="{{route('deletenotification',['id' => $value->notification_id])}}" class="btn btn-danger">Delete</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- container -->
            </div> <!-- Page content Wrapper -->
        </div> <!-- content -->
    </div>
@endsection