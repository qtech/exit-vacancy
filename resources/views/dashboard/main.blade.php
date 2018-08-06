@if(Auth()->user()->role == 1)
@extends('layout.layout')

@section('content')
<style>
    .widget-simple-sm-icon{
        line-height: 110px !important;
        font-size: 3.75rem !important; 
    }
    .a_tag{
        color: white !important;
    }
</style>
<div class="row">
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('appusers')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$users}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-users"></i> Users</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('hotelusers')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$hotels}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-build"></i> Hotels</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="#">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$bookings}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-post"></i> Bookings</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('mails')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$mails}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-mail"></i> Mails to Users</div>
            </section>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('h.mails')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$hmails}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-mail"></i> Mails to Hotels</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('sms')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$sms}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-comments-2"></i> SMS to Users</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('h.sms')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$hsms}}    
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-comments-2"></i> SMS to Hotels</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('notifications')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$notifications}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-alarm-2"></i> Notifications to Users</div>
            </section>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('h.notifications')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$hnotifications}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-alarm-2"></i> Notifications to Hotels</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('amenity')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$amenities}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-star"></i> Hotel Amenities</div>
            </section>
        </a>
    </div>
</div>

<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg"><strong>Registrations</strong></h5>
            <canvas id="myChart1" width="400" height="100"></canvas>
    </div>
</section>
<section class="card box-typical">
    <div class="card-block">
            <h5 class="m-t-lg"><strong>Bookings</strong></h5>
                <canvas id="myChart2" width="400" height="100"></canvas>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontWeight = 'bold';
            Chart.defaults.global.defaultFontSize = 14;
            registration();
            bookings();
        });

        function registration(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Hotels',
                            fill: false,                            
                            backgroundColor: "#00857B",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [], // try [5, 15] for instance
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "black",
                            pointBackgroundColor: "white",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "red",
                            pointHoverBorderColor: "brown",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data:res.hotels,
                            spanGaps: true,
                        },{
                            label:'Users', 
                            fill: false,                            
                            backgroundColor: "rgb(167, 105, 0)",
                            borderColor: "rgb(167, 105, 0)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "white",
                            pointBackgroundColor: "black",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "yellow",
                            pointHoverBorderColor: "green",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data:res.users,
                            spanGaps: false,                          
                        }],
                    }
                    //Start Chart plotting.
                    var ctx = $('#myChart1');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('dashboard.chartData')}}',true);
            ajx.send();
        }
        
        function bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Bookings',
                            fill: true,                            
                            backgroundColor: "#00857B",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [5,5], // try [5, 15] for instance
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "black",
                            pointBackgroundColor: "white",
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
                    var ctx = $('#myChart2');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('dashboard.bookingData')}}',true);
            ajx.send();
        }
    </script>
@endsection
@endif

@if(Auth()->user()->role == 3)
@endif