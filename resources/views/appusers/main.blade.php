@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <section class="card box-typical">
            <div class="card-block">
                <h5 class="m-t-lg pull-left"><strong>User Registrations</strong></h5>
                <form method="POST" id="u_r_Form">
                    <div class="col-3 pull-right">
                        <div class="form-group">
                            <strong>To:</strong><input class="flatpickr form-control" id="u_r_date2" name="u_r_date2" type="text" placeholder="Date">
                        </div>
                    </div>
                    <div class="col-3 pull-right">
                        <div class="form-group">
                            <strong>From:</strong><input class="flatpickr form-control" id="u_r_date1" name="u_r_date1" type="text" placeholder="Date">
                        </div>
                    </div>
                </form>
                <div id="chart1wrapper">
                    <canvas id="myChart1" width="400" height="100"></canvas>
                </div>
            </div>
        </section>
    </div>
</div>
<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('appusers')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-new'}}">All Users</a>
                <a href="{{route('appusers',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-new'}}">No Bookings</a>
                <a href="{{route('appusers',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-new'}}">Bookings this month</a>
                <a href="{{route('appusers',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-new'}}">More than 5 Bookings</a>
                <a href="{{route('appusers',['id' => 4])}}" class="btn {{$id == 4 ? 'btn-custom' : 'btn-new'}}">Registered this month</a>
                @if($id == '')
                    <a href="{{route('e.appusers')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 1)
                    <a href="{{route('e.usernobookings')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 2)
                    <a href="{{route('e.userbookingsmonth')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 3)
                    <a href="{{route('e.userbookingsfive')}}" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 4)
                    <a href="{{route('e.userregister')}}" class="btn btn-custom pull-right">Export</a>
                @endif
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
                <th>Bookings</th>
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
                        <a style="border-bottom:none !important; color:#00857b;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname or $value->user->fname}}</a>
                    </td>
                    <td>{{$value->email or $value->user->email}}</td>
                    <td>+{{$value->customer->number}}</td>
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
                    <td style="text-align:center;"><strong>{{$value->bookings}}</strong></td>
                    <td class="text-center">
                        @if($value->user_status == 1 || @$value->user->user_status == 1)
                            <a class="btn btn-sm btn-rounded btn-primary" href="{{route('disableuser',['id' => $value->user_id])}}">Active</a>
                        @else
                            <a class="btn btn-sm btn-rounded btn-danger" href="{{route('enableuser',['id' => $value->user_id])}}">In-Active</a>
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
            Chart.defaults.global.defaultFontStyle = 'bold';
            Chart.defaults.global.defaultFontSize = 12;
            registration();
            $('.flatpickr').flatpickr({
                onChange: function() {
                    r_withdates();
                }
            });
        });

        function registration(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Users',
                            fill: true,   
                            tension: 0.4,                         
                            backgroundColor: "#54bcb4",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [], // try [5, 15] for instance
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "white",
                            pointBackgroundColor: "black",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "brown",
                            pointHoverBorderColor: "black",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data:res.users,
                            spanGaps: true,
                        }]
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

        function r_withdates(){
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
                                    fill: true, 
                                    tension: 0.4,                           
                                    backgroundColor: "#c48758",
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
                                }]
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
    </script>
@endsection