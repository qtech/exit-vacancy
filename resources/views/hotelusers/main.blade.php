@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <section class="card box-typical">
            <div class="card-block">
                <h5 class="m-t-lg pull-left"><strong>Hotel Registrations</strong></h5>
                <form method="POST" id="h_r_Form">
                    <div class="col-3 pull-right">
                        <div class="form-group">
                            <strong>To:</strong><input class="flatpickr form-control" id="h_r_date2" name="h_r_date2" type="text" placeholder="Date">
                        </div>
                    </div>
                    <div class="col-3 pull-right">
                        <div class="form-group">
                            <strong>From:</strong><input class="flatpickr form-control" id="h_r_date1" name="h_r_date1" type="text" placeholder="Date">
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
            <div class="col-sm-12">
                <h5 class="m-t-lg pull-left"><strong>Hotels</strong></h5>
                <a href="{{route('e.hotelusers')}}" class="btn btn-custom pull-right">Export</a>
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
                @foreach($hotelusers as $value)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>
                        <a style="border-bottom:none !important; color:#00857b;" href="{{route('hoteldetails',['id' => $value->user_id])}}">{{$value->hotel->hotel_name}}</a>
                    </td>
                    <td>{{$value->email}}</td>
                    <td>+{{$value->hotel->number}}</td>
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
                    <td style="text-align:center;"><strong>{{count($value->hotelbookings)}}</strong></td>
                    <td class="text-center">
                        @if($value->user_status == 1)
                            <a class="btn btn-sm btn-rounded btn-primary" href="{{route('disablehotel',['id' => $value->user_id])}}">Active</a>
                        @else
                            <a class="btn btn-sm btn-rounded btn-danger" href="{{route('enablehotel',['id' => $value->user_id])}}">In-Active</a>
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
                            label:'Hotels',
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
                            data:res.hotels,
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
            ajx.open('GET','{{route('hotel.r.chart')}}',true);
            ajx.send();
        }

        function r_withdates(){
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
                                    data:res.hotels,
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
                ajx.open("POST", '{{route('hotel.r.dates')}}', true);
                // ajx.setRequestHeader("Content-type", "application/json");
                ajx.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
                ajx.send(formData);
            }
        }
    </script>
@endsection