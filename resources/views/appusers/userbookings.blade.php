@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">User Bookings</h3>
                <a href="{{route('appusers')}}" class="btn btn-warning pull-right">Back</a>
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
                    <th>Hotel Name</th>
                    <th>Room Type</th>
                    <th>Room Price</th>
                    <th>Status</th>
                    <th>Room Image</th>
                    <th>Arrival</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($userbookings as $value)
                @php  
                    $hotel = App\Hoteldata::where(['hotel_data_id' => $value->hotel_id])->first();  
                @endphp
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$hotel->hotel_name}}</td>
                    <td>{{$value->roomtype}}</td>
                    <td>{{$value->roomprice}}</td>
                    <td>
                        @if($value->status == 1)
                            <label class="label label-success">Accepted</label>
                        @else
                            <label class="label label-danger">Declined</label>
                        @endif
                    </td>
                    <td>
                        <img height="30px;" width="60px;" src="{{asset(url('/').'/'.$value->roomimage)}}">    
                    </td>
                    <td>
                        @if($value->is_visited == 1)
                            <label class="label label-success">Visited</label>
                        @else
                            <label class="label label-danger">Not Visited</label>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection