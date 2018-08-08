@extends('layout.layout')

@section('content')
<section class="card">
    <div class="card-block">
        <h5 class="m-t-lg"><strong>Cancelled Bookings</strong></h5>
        <br>
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('cancelled.bookings')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-new'}}">All Bookings</a>
                <a href="{{route('cancelled.bookings',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-new'}}">Today</a>
                <a href="{{route('cancelled.bookings',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-new'}}">This Week</a>
                <a href="{{route('cancelled.bookings',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-new'}}">This Month</a>
                @if($id == '')
                <a href="{{route('e.can.bookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 1)
                    <a href="{{route('e.can.todaybookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 2)
                    <a href="{{route('e.can.weekbookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 3)
                    <a href="{{route('e.can.monthbookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
            </div>
        </div>
        <br>
        <form method="POST" id="b_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="b_date2" name="b_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="b_date1" name="b_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="cancelwrapper">
            <canvas id="cancelchart" width="400" height="100"></canvas>
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
                <th>Cancelled Time</th>
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
                    <td>{{$value->status_time}}</td>
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
            $('.flatpickr').flatpickr({
                // onChange: function() {
                //     r_withdates();
                //     b_withdates();
                // }
            });
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
                    var ctx = $('#cancelchart');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('cancelbookings.chart')}}',true);
            ajx.send();
        }
    </script>
@endsection