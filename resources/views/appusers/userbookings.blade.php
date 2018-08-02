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
                                <h4 class="m-b-30 m-t-0 pull-left">User Bookings</h4>
                                <a href="{{route('appusers')}}" class="btn btn-warning pull-right">Back</a>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="example" class="table table-striped table-bordered">
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
                                                                <label class="label label-info">Accepted</label>
                                                            @else
                                                                <label class="label label-danger">Declined</label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <img height="30px;" width="50px;" src="{{asset(url('/').'/'.$value->roomimage)}}">    
                                                        </td>
                                                        <td>
                                                            @if($value->is_visited == 1)
                                                                <label class="label label-info">Visited</label>
                                                            @else
                                                                <label class="label label-danger">Not Visited</label>
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