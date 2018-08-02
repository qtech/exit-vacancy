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
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>User Status</th>
                                                </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach($users as $value)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>
                                                            <a href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname}} {{$value->lname}}</a>
                                                        </td>
                                                        <td>{{$value->email}}</td>
                                                        <td>{{$value->customer->number}}</td>
                                                        <td>
                                                            @if($value->is_email_verify == 1)
                                                                <label class="label label-info">Verified</label>
                                                            @else
                                                                <label class="label label-danger">Not Verified</label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->is_mobile_verify == 1)
                                                                <label class="label label-info">Verified</label>
                                                            @else
                                                                <label class="label label-danger">Not Verified</label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->user_status == 1)
                                                                <a href="{{route('disableuser',['id' => $value->user_id])}}"><label class="label label-success">Active</label></a>
                                                            @else
                                                                <a href="{{route('enableuser',['id' => $value->user_id])}}"><label class="label label-warning">In-Active</label></a>
                                                            @endif
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