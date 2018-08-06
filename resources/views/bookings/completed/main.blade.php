@extends('layout.layout')

@section('content')
<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg"><strong>Completed Bookings</strong></h5>
            <canvas id="completechart" width="400" height="100"></canvas>
    </div>
</section>

<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('completed.bookings')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-new'}}">All Bookings</a>
                <a href="{{route('completed.bookings',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-new'}}">Today</a>
                <a href="{{route('completed.bookings',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-new'}}">This Week</a>
                <a href="{{route('completed.bookings',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-new'}}">This Month</a>
            </div>
        </div>
        <br>
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Hotel Name</th>
                <th>Room Type</th>
                <th>Price</th>
                <th>Image</th>
                <th>Amenities</th>
                <th>Arrived</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($bookings as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->user->fname}} {{$value->user->lname}}</td>
                    <td>{{$value->hotel->hotel_name}}</td>
                    <td>{{$value->roomtype}}</td>
                    <td>${{$value->roomprice}}</td>
                    <td>
                        <img height="30px;" width="60px;" src="{{asset(url('/').'/'.$value->roomimage)}}">
                    </td>
                    <td><label class="label label-info">{{$value->roomamenity}}</label></td>
                    <td>
                        @if($value->is_visited == 1)
                            <label class="label label-success">YES</label>
                        @else
                            <label class="label label-danger">NO</label>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontWeight = 'bold';
            Chart.defaults.global.defaultFontSize = 14;
            completebookings();
        });
        
        function completebookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Bookings',
                            fill: false,                            
                            backgroundColor: "#00857B",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "black",
                            pointBackgroundColor: "black",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "red",
                            pointHoverBorderColor: "brown",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data:res.bookings,
                            spanGaps: true,
                        }],
                    }
                    //Start Chart plotting.
                    var ctx = $('#completechart');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('completebookings.chart')}}',true);
            ajx.send();
        }
    </script>
@endsection