@extends('layout.layout')

@if(Auth()->user()->role == 1)
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
                <div class="row" style="padding-top: 5px; padding-left: 6px; padding-right: 6px;">
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$t_users}}
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$m_users}}
                            <p>Month</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$users}}
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-users"></i> Users Registration</div>
                </div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('hotelusers')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="row" style="padding-top: 5px; padding-left: 6px; padding-right: 6px;">
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$t_hotels}}
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$m_hotels}}
                            <p>Month</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$hotels}}
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-build"></i> Hotels Registration</div>
                </div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('completed.bookings')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="row" style="padding-top: 5px; padding-left: 6px; padding-right: 6px;">
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$t_c_bookings}}
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$m_c_bookings}}
                            <p>Month</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$completebookings}}
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-ok"></i> Completed Bookings</div>
                </div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('cancelled.bookings')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="row" style="padding-top: 5px; padding-left: 6px; padding-right: 6px;">
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$t_p_bookings}}
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$m_p_bookings}}
                            <p>Month</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$pendingbookings}}
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-list-rotate"></i> Pending Bookings</div>
                </div>
            </section>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('cancelled.bookings')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="row" style="padding-top: 5px; padding-left: 6px; padding-right: 6px;">
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$t_users}}
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$m_users}}
                            <p>Month</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$users}}
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-del"></i> Cancelled Bookings</div>
                </div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('transaction')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="row" style="padding-top: 5px; padding-left: 6px; padding-right: 6px;">
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$t_users}}
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$m_users}}
                            <p>Month</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d_boxes">
                            {{$users}}
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-wallet"></i> Earnings</div>
                </div>
            </section>
        </a>
    </div>
</div>

<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg pull-left"><strong>User Registrations</strong></h5>
        <form method="POST" id="u_r_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="u_r_date2" name="u_r_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="u_r_date1" name="u_r_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="chart1wrapper">
            <canvas id="myChart1" width="400" height="100"></canvas>
        </div>
    </div>
</section>
<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg pull-left"><strong>Hotel Registrations</strong></h5>
        <form method="POST" id="h_r_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="h_r_date2" name="h_r_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="h_r_date1" name="h_r_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="chart2wrapper">
            <canvas id="myChart2" width="400" height="100"></canvas>
        </div>
    </div>
</section>
<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg pull-left"><strong>Completed Bookings</strong></h5>
        <form method="POST" id="c_b_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="c_b_date2" name="c_b_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="c_b_date1" name="c_b_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="chart3wrapper">
            <canvas id="myChart3" width="400" height="100"></canvas>
        </div>
    </div>
</section>
<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg pull-left"><strong>Pending Bookings</strong></h5>
        <form method="POST" id="p_b_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="p_b_date2" name="p_b_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="p_b_date1" name="p_b_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="chart4wrapper">
            <canvas id="myChart4" width="400" height="100"></canvas>
        </div>
    </div>
</section>
<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg pull-left"><strong>Transactions</strong></h5>
        <form method="POST" id="b_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="t_date2" name="t_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="t_date1" name="t_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="chart5wrapper">
            <canvas id="myChart5" width="400" height="100"></canvas>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            NProgress.start();
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontStyle = 'bold';
            Chart.defaults.global.defaultFontSize = 14;
            user_registration();
            hotel_registration();
            completed_bookings();
            pending_bookings();
            transactions();
            $('.flatpickr').flatpickr({
                onChange: function() {
                    u_r_withdates();
                    h_r_withdates();
                    cb_withdates();
                    pb_withdates();
                }
            });
            NProgress.done();
        });

        function user_registration(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Users', 
                            fill: false,  
                            tension: 0.4,                          
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
                            spanGaps: true,                          
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
            ajx.open('GET','{{route('user.r.chart')}}',true);
            ajx.send();
        }

        function hotel_registration(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Hotels',
                            fill: false,  
                            tension: 0.4,                          
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
            ajx.open('GET','{{route('hotel.r.chart')}}',true);
            ajx.send();
        }

        function completed_bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Completed Bookings', 
                            fill: false,  
                            tension: 0.4,                          
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
                            data:res.completed,
                            spanGaps: true,                          
                        }],
                    }
                    //Start Chart plotting.
                    var ctx = $('#myChart3');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('complete.booking.chart')}}',true);
            ajx.send();
        }

        function pending_bookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Pending Bookings',
                            fill: false,  
                            tension: 0.4,                          
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
                            data:res.pending,
                            spanGaps: true,
                        }],
                    }
                    //Start Chart plotting.
                    var ctx = $('#myChart4');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('pending.booking.chart')}}',true);
            ajx.send();
        }

        function u_r_withdates(){
            var date1 = document.getElementById("u_r_date1").value;
            var date2 = document.getElementById("u_r_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("u_r_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                    if (ajx.readyState == 4 && ajx.status == 200) {
                            var res = JSON.parse(ajx.responseText);                                        
                            var data = {
                                labels: res.dateLabel,
                                datasets:[{
                                    label:'Users', 
                                    fill: false, 
                                    tension: 0.4,                           
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
                                    spanGaps: true,                          
                                }],
                            }
                            $('#myChart1').remove();
                            $('#chart1wrapper').append('<canvas id="myChart1" width="400" height="100"></canvas>');
                            //Start Chart plotting.
                            var ctx = $('#myChart1');
                            var myLineChart = new Chart(ctx, {
                                type:'line',
                                data:data
                            });
                    }
                };
                ajx.open("POST", '{{route('user.r.dates')}}', true);
                // ajx.setRequestHeader("Content-type", "application/json");
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }

        function h_r_withdates(){
            var date1 = document.getElementById("h_r_date1").value;
            var date2 = document.getElementById("h_r_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("h_r_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                    if (ajx.readyState == 4 && ajx.status == 200) {
                            var res = JSON.parse(ajx.responseText);                                        
                            var data = {
                                labels: res.dateLabel,
                                datasets:[{
                                    label:'Hotels', 
                                    fill: false, 
                                    tension: 0.4,                           
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
                                    data:res.hotels,
                                    spanGaps: true,                          
                                }],
                            }
                            $('#myChart2').remove();
                            $('#chart2wrapper').append('<canvas id="myChart2" width="400" height="100"></canvas>');
                            //Start Chart plotting.
                            var ctx = $('#myChart2');
                            var myLineChart = new Chart(ctx, {
                                type:'line',
                                data:data
                            });
                    }
                };
                ajx.open("POST", '{{route('hotel.r.dates')}}', true);
                // ajx.setRequestHeader("Content-type", "application/json");
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }

        function cb_withdates(){
            var date1 = document.getElementById("c_b_date1").value;
            var date2 = document.getElementById("c_b_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("c_b_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                    if (ajx.readyState == 4 && ajx.status == 200) {
                            var res = JSON.parse(ajx.responseText);                                        
                            var data = {
                                labels: res.dateLabel,
                                datasets:[{
                                    label:'Completed',
                                    fill: false, 
                                    tension: 0.4,                           
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
                                    data:res.completed,
                                    spanGaps: true,
                                }],
                            }

                            $('#myChart3').remove();
                            $('#chart3wrapper').append('<canvas id="myChart3" width="400" height="100"></canvas>');
                            //Start Chart plotting.
                            var ctx = $('#myChart3');
                            var myLineChart = new Chart(ctx, {
                                type:'line',
                                data:data
                            });
                    }
                };
                ajx.open("POST", "{{route('cb.dates')}}", true);
                // ajx.setRequestHeader("Content-type", "application/json");
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }

        function pb_withdates(){
            var date1 = document.getElementById("p_b_date1").value;
            var date2 = document.getElementById("p_b_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("p_b_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                    if (ajx.readyState == 4 && ajx.status == 200) {
                            var res = JSON.parse(ajx.responseText);                                        
                            var data = {
                                labels: res.dateLabel,
                                datasets:[{
                                    label:'Pending',
                                    fill: false, 
                                    tension: 0.4,                           
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
                                    data:res.pending,
                                    spanGaps: true,
                                }],
                            }

                            $('#myChart4').remove();
                            $('#chart4wrapper').append('<canvas id="myChart4" width="400" height="100"></canvas>');
                            //Start Chart plotting.
                            var ctx = $('#myChart4');
                            var myLineChart = new Chart(ctx, {
                                type:'line',
                                data:data
                            });
                    }
                };
                ajx.open("POST", "{{route('pb.dates')}}", true);
                // ajx.setRequestHeader("Content-type", "application/json");
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }

        function transactions(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Transactions',
                            fill: false,    
                            tension: 0.4,                        
                            backgroundColor: "#00857B",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
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
                            data:res.transactions,
                            spanGaps: true,
                        }],
                    }
                    //Start Chart plotting.
                    var ctx = $('#myChart3');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('t.chart')}}',true);
            ajx.send();
        }
    </script>
@endsection
@endif

@if(Auth()->user()->role == 3)
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
        <a class="a_tag" href="{{route('hotelbookings')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$accepted}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-ok"></i> Accepted Bookings</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('hotelbookings')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$declined}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-del"></i> Declined Bookings</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('h.s.room')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$rooms->king_room}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-player-subtitres"></i> King Rooms</div>
            </section>
        </a>
    </div>
    <div class="col-sm-3">
        <a class="a_tag" href="{{route('h.d.room')}}">
            <section class="widget widget-simple-sm-fill" style="background:#00857B !important;">
                <div class="widget-simple-sm-icon">
                    {{$rooms->queen_room}}
                </div>
                <div class="widget-simple-sm-fill-caption"><i class="font-icon font-icon-player-subtitres"></i> Two-Queens Rooms</div>
            </section>
        </a>
    </div>
</div>

<section class="card box-typical">
    <div class="card-block">
        <h5 class="m-t-lg"><strong>Bookings</strong></h5>
        <form method="POST" id="h_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="h_date2" name="h_date2" type="text" placeholder="Select Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="h_date1" name="h_date1" type="text" placeholder="Select Date">
                </div>
            </div>
        </form>
        <div id="chartwrapper">
            <canvas id="hotelbookings" width="400" height="100"></canvas>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'block';
            document.getElementById('fade').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('fade').style.display = 'none';
        }

        $(document).ready(function(){
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontStyle = 'bold';
            Chart.defaults.global.defaultFontSize = 14;
            hotelbookings();
            $('.flatpickr').flatpickr({
                onChange: function() {
                    h_withdates();
                }
            });
        });
        
        function hotelbookings(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Completed',
                            fill: false,                            
                            backgroundColor: "#00857B",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
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
                            data:res.completed,
                            spanGaps: true,
                        },{
                            label:'Cancelled', 
                            fill: false,                            
                            backgroundColor: "rgb(167, 105, 0)",
                            borderColor: "rgb(167, 105, 0)",
                            borderCapStyle: 'butt',
                            borderDash: [0,0],
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
                            data:res.cancelled,
                            spanGaps: false,                          
                        }],
                    }
                    //Start Chart plotting.
                    var ctx = $('#hotelbookings');
                    var myLineChart = new Chart(ctx, {
                        type:'line',
                        data:data
                    })
                }
            }
            ajx.open('GET','{{route('hotelbooking.chart')}}',true);
            ajx.send();
        }

        function h_withdates(){
            var date1 = document.getElementById("h_date1").value;
            var date2 = document.getElementById("h_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("h_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                    if (ajx.readyState == 4 && ajx.status == 200) {
                            var res = JSON.parse(ajx.responseText);                                        
                            var data = {
                                labels: res.dateLabel,
                                datasets:[{
                                    label:'Completed',
                                    fill: false, 
                                    tension: 0.4,                           
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
                                    data:res.completed,
                                    spanGaps: true,
                                },{
                                    label:'Cancelled', 
                                    fill: false, 
                                    tension: 0.4,                           
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
                                    data:res.cancelled,
                                    spanGaps: false,                          
                                }],
                            }

                            $('#hotelbookings').remove();
                            $('#chartwrapper').append('<canvas id="hotelbookings" width="400" height="100"></canvas>');
                            //Start Chart plotting.
                            var ctx = $('#hotelbookings');
                            var myLineChart = new Chart(ctx, {
                                type:'line',
                                data:data
                            });
                    }
                };
                ajx.open("POST", "{{route('hbooking.chart.dates')}}", true);
                // ajx.setRequestHeader("Content-type", "application/json");
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }
    </script>
@endsection
@endif