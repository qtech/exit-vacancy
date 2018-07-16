@extends('layout.layout')

@section('content')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="page-content-wrapper ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-b-30 m-t-0">Application Users</h4>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="example" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Number</th>
                                                    <th>Email Verified</th>
                                                    <th>Mobile Verified</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach($users as $value)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{$value->fname}} {{$value->lname}}</td>
                                                        <td>{{$value->email}}</td>
                                                        <td></td>
                                                        <td>{{$value->is_email_verify}}</td>
                                                        <td>{{$value->is_mobile_verify}}</td>
<td>
<a href="#" data-toggle="modal" data-target="#custom-width-modal{{$value->user_id}}"><i class="ti-trash" style="color:red; font-size:1.3em;"></i></a>
<div id="custom-width-modal{{$value->user_id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Confirm Action</h4>
            </div>
            <div class="modal-body">
            <h4>Are you sure you want to delete this user: <code>{{$value->fname}}{{$value->lname}}</code> ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <a href="{{route('deletenotification',['id' => $value->user_id])}}" class="btn btn-danger">Delete</a>
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
                    </div> <!-- End Row -->
                </div><!-- container -->
            </div> <!-- Page content Wrapper -->
        </div> <!-- content -->
    </div>
@endsection