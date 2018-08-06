@extends('layout.layout')

@section('content')
<section class="card">
    <div class="card-block">
            <h3>Hotel Owners</h3>
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
                <th>Bookings</th>
                <th>User Status</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($hotelusers as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                        <a style="border-bottom:none !important; color:black;" href="{{route('hoteldetails',['id' => $value->user_id])}}">{{$value->fname}} {{$value->lname}}</a>
                    </td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->hotel->number}}</td>
                    <td>
                        @if($value->is_email_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->is_mobile_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td style="text-align:center;"><label class="label label-warning">{{count($value->hotelbookings)}}</label></td>
                    <td>
                        @if($value->user_status == 1)
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