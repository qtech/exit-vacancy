@extends('layout.layout')

@section('content')
<section class="card">
    <div class="card-block">
        <h5 class="m-t-lg"><strong>Pending Bookings</strong></h5>
        <br>
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('pending.bookings')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-new'}}">All Bookings</a>
                <a href="{{route('pending.bookings',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-new'}}">Today</a>
                <a href="{{route('pending.bookings',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-new'}}">This Week</a>
                <a href="{{route('pending.bookings',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-new'}}">This Month</a>
                @if($id == '')
                    <a href="{{route('e.p.bookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 1)
                    <a href="{{route('e.p.todaybookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 2)
                    <a href="{{route('e.p.weekbookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 3)
                    <a href="{{route('e.p.monthbookings')}}" class="btn btn-custom pull-right">Export</a>
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
        <div id="pendingwrapper">
            <canvas id="pendingchart" width="400" height="100"></canvas>
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
                <th>Booking Time</th>
            </tr>
            </thead>
            <tbody>
                @foreach($bookings as $value)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$value->user->fname}} {{$value->user->lname or ""}}</td>
                    <td>{{$value->hotel->hotel_name}}</td>
                    <td>{{$value->roomtype}}</td>
                    <td>{{$value->roomprice}}</td>
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

            $('.flatpickr').flatpickr({
                onChange: function() {
                    p_d_bookings();
                }
            });
        });

        var all = "{{route('pending.bookings')}}";
        var today = "{{route('pending.bookings',['id' => 1])}}";
        var week = "{{route('pending.bookings',['id' => 2])}}";
        var month = "{{route('pending.bookings',['id' => 3])}}";

        if(window.location.href == all) {
            p_bookings();
        }
        
        if(window.location.href == today) {
            p_t_bookings();
        }

        if(window.location.href == week) {
            p_w_bookings();
        }

        if(window.location.href == month) {
            p_m_bookings();
        }

        function p_bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Bookings',
                            fill: true,                             
                            backgroundColor: "#54bcb4",
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
                            spanGaps: true
                        }],
                    }

                    $('#pendingchart').remove();
                    $('#pendingwrapper').append('<canvas id="pendingchart" width="400" height="100"></canvas>');
                    //Start Chart plotting.
                    var ctx = $('#pendingchart');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('p.bookings.chart')}}',true);
            ajx.send();
        }

        function p_t_bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Bookings',
                            fill: true,                               
                            backgroundColor: "#54bcb4",
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
                            spanGaps: true
                        }],
                    }

                    $('#pendingchart').remove();
                    $('#pendingwrapper').append('<canvas id="pendingchart" width="400" height="100"></canvas>');
                    //Start Chart plotting.
                    var ctx = $('#pendingchart');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('p.t.bookings.chart')}}',true);
            ajx.send();
        }

        function p_w_bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Bookings',
                            fill: true,                              
                            backgroundColor: "#54bcb4",
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
                            spanGaps: true
                        }],
                    }

                    $('#pendingchart').remove();
                    $('#pendingwrapper').append('<canvas id="pendingchart" width="400" height="100"></canvas>');
                    //Start Chart plotting.
                    var ctx = $('#pendingchart');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('p.w.bookings.chart')}}',true);
            ajx.send();
        }

        function p_m_bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Bookings',
                            fill: true,                               
                            backgroundColor: "#54bcb4",
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
                            spanGaps: true
                        }],
                    }

                    $('#pendingchart').remove();
                    $('#pendingwrapper').append('<canvas id="pendingchart" width="400" height="100"></canvas>');
                    //Start Chart plotting.
                    var ctx = $('#pendingchart');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('p.m.bookings.chart')}}',true);
            ajx.send();
        }

        function p_d_bookings(){
            var date1 = document.getElementById("b_date1").value;
            var date2 = document.getElementById("b_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("b_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function() {
                    if(ajx.readyState == 4 && ajx.status == 200){
                        var res = JSON.parse(ajx.responseText);                                        
                        var data = {
                            labels: res.dateLabel,
                            datasets:[{
                                label:'Bookings',
                                fill: true,                               
                                backgroundColor: "#54bcb4",
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
                                spanGaps: true
                            }],
                        }

                        $('#pendingchart').remove();
                        $('#pendingwrapper').append('<canvas id="pendingchart" width="400" height="100"></canvas>');
                        //Start Chart plotting.
                        var ctx = $('#pendingchart');
                        var myLineChart = new Chart(ctx, {
                            type:'line',
                            data:data,
                        })
                    }
                }

                ajx.open("POST", "{{route('p.d.bookings.chart')}}", true);
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }
    </script>
@endsection