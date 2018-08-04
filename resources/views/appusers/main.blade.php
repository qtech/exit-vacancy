@extends('layout.layout')

@section('content')
<style>
    .btn-custom{
        background-color: #00857B;
        border-color: #00857B;
    } 
    .btn-custom:hover{
        background-color: #00857ba8;
        border-color: #00857B;
    }   
</style>
<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('appusers')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-default'}}">All Users</a>
                <a href="{{route('appusers',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-default'}}">No Bookings</a>
                <a href="{{route('appusers',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-default'}}">Bookings this month</a>
                <a href="{{route('appusers',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-default'}}">More than 5 Bookings</a>
                <a href="{{route('appusers',['id' => 4])}}" class="btn {{$id == 4 ? 'btn-custom' : 'btn-default'}}">Registered this month</a>
            </div>
        </div>
        <br>
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
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
                        <a style="border-bottom:none !important; color:black;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname or $value->user->fname}} {{$value->lname or $value->user->lname}}</a>
                    </td>
                    <td>{{$value->email or $value->user->email}}</td>
                    <td>{{$value->customer->number}}</td>
                    <td>
                        @if($value->is_email_verify == 1 || @$value->user->is_email_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->is_mobile_verify == 1 || @$value->user->is_mobile_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->user_status == 1 || @$value->user->user_status == 1)
                            <a href="{{route('disableuser',['id' => $value->user_id])}}"><label class="label label-success">Active</label></a>
                        @else
                            <a href="{{route('enableuser',['id' => $value->user_id])}}"><label class="label label-danger">In-Active</label></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection