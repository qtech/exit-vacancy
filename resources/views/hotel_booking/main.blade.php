@extends('layout.layout')

@section('content')
{{-- <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="page-content-wrapper ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-b-30 m-t-0">Bookings</h4>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="example" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer</th>
                                                    <th>Email</th>
                                                    <th>Number</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach($getdetails as $value)
                                                    @php    
                                                        $client = App\User::with('customer')->where(['user_id' => $value->user_id])->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{$client->fname}} {{$client->lname}}</td>
                                                        <td>{{$client->email}}</td>
                                                        <td>{{$client->customer->number}}</td>
                                                        <td>{{$client->customer->city}}, {{$client->customer->state}}</td>
                                                        <td>
                                                            @if($value->status == 0)
                                                            <label class="label label-warning">Pending</label>
                                                            @endif
                                                            @if($value->status == 1)
                                                            <label class="label label-info">Accepted</label>
                                                            @endif
                                                            @if($value->status == 2)
                                                            <label class="label label-danger">Declined</label>
                                                            @endif
                                                            @if($value->status == 3)
                                                            <label class="label label-success">No response</label>
                                                            @endif
                                                        </td>
<td>
<a href="#" data-toggle="modal" data-target="#custom-width-modal{{$value->booking_id}}"><i class="ti-trash" style="color:red; font-size:1.3em;"></i></a>
<div id="custom-width-modal{{$value->booking_id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Confirm Action</h4>
            </div>
            <div class="modal-body">
            <h4>Are you sure you want to delete this booking: <code>{{$client->fname}} {{$client->lname}}</code> ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Closeeee</button>
                <a href="{{route('deletebooking',['id' => $value->booking_id])}}" class="btn btn-danger">Delete</a>
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
    </div>  --}}
    
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">User Bookings</h3>
            </div>
        </div>
    </div>
</header>
<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Room Type</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Your Payment</th>
            </tr>
            </thead>
            <tbody>
                @foreach($getdetails as $value)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$value->user->fname}} {{$value->user->lname}}</td>
                    <td>{{$value->user->email}}</td>
                    <td>+{{$value->customer->number}}</td>
                    <td>{{$value->roomtype}}</td>
                    <td>
                        @if($value->status == 0)
                        <label class="label label-warning">Pending</label>
                        @endif
                        @if($value->status == 1)
                        <label class="label label-success">Accepted</label>
                        @endif
                        @if($value->status == 2)
                        <label class="label label-danger">Declined</label>
                        @endif
                        @if($value->status == 3)
                        <label class="label label-warning">No response</label>
                        @endif
                    </td>
                    <td>${{$value->total_amount or "0"}}</td>
                    <td>${{$value->hotel_payment}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection