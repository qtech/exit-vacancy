@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-xxl-12 col-lg-12 col-xl-12 col-md-12">
        <section class="box-typical proj-page">
            <section class="proj-page-section proj-page-header">
                <div class="tbl proj-page-team">
                    <div class="tbl-row">
                        <div class="tbl-cell tbl-cell-admin">
                            <div class="avatar-preview avatar-preview-32">
                                <a href="#">
                                    <img src="{{asset('user.png')}}" alt="">
                                </a>
                            </div>
                            <div class="title">
                                &nbsp;{{$user->fname}} {{$user->lname}}
                            </div>
                        </div>
                        <div class="tbl-cell tbl-cell-date">
                            <strong>Last Login:</strong> {{$user->last_login}}
                            <a href="{{route('appusers')}}" class="btn btn-sm btn-custom" style="margin-left:25px;">BACK</a>
                        </div>
                    </div>
                </div>
            </section><!--.proj-page-section-->

            <section class="proj-page-section proj-page-people">
                    <header class="proj-page-subtitle padding-sm">
                        <h3>Details</h3>
                    </header>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tbl tbl-people">
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">Joined</div>
                                    <div class="tbl-cell" style="font-size:14px;">{{date('d-M-Y', strtotime($user->created_at))}}</div>
                                </div>
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">Email</div>
                                    <div class="tbl-cell" style="font-size:14px;">{{$user->email}}</div>
                                </div>
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">Number</div>
                                    <div class="tbl-cell" style="font-size:14px;">+{{$user->customer->number}}</div>
                                </div>
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">Address</div>
                                    <div class="tbl-cell" style="font-size:14px;">{{$user->customer->building}}, {{$user->customer->street}}</div>
                                </div>
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">City</div>
                                    <div class="tbl-cell" style="font-size:14px;">{{$user->customer->city}}</div>
                                </div>
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">State</div>
                                    <div class="tbl-cell" style="font-size:14px;">{{$user->customer->state}}</div>
                                </div>
                                <div class="tbl-row">
                                    <div class="tbl-cell tbl-cell-lbl">Country</div>
                                    <div class="tbl-cell" style="font-size:14px;">{{$user->customer->country}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-top:-15px;">
                            <div id="userwrapper">
                                <canvas id="userChart" width="400" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

            <section class="proj-page-section proj-page-people">
                <header class="proj-page-subtitle padding-sm">
                    <h3>Bookings</h3>
                </header>
                <br>
                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Hotel Name</th>
                        <th>Hotel Class</th>
                        <th>Room Type</th>
                        <th>Price</th>
                        <th>Booking Time</th>
                        <th>Arrived</th>
                        <th>Arrived Time</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $value)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$value->hotel->hotel_name}}</td>
                            <td style="text-align:center;">
                                <strong>{{$value->hotel->stars}}</strong> 
                                    <i class="font-icon font-icon-star" style="color:orange;"></i>
                            </td>
                            <td>{{$value->roomtype}}</td>
                            <td>${{$value->roomprice}}</td>
                            <td>{{$value->status_time or 'Not available'}}</td>
                            <td style="text-align:center;">
                                @if($value->is_visited == 1)
                                    <label class="label label-success">YES</label>
                                @else
                                    <label class="label label-danger">NO</label>
                                @endif
                            </td>
                            <td>{{$value->visited_time or 'Not available'}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section><!--.proj-page-section-->
        </section><!--.proj-page-->
    </div>
</div><!--.row-->
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            userbookings();
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontStyle = 'bold';
            Chart.defaults.global.defaultFontSize = 11;
        });

        function userbookings(){
            
            var param = {
                "id":'{{$user->user_id}}',
                "_token":'{{csrf_token()}}'
            }
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
                                label:'Pending', 
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
                                data:res.pending,
                                spanGaps: false,                          
                            },{
                                label:'Cancelled', 
                                fill: false, 
                                tension: 0.4,                           
                                backgroundColor: "red",
                                borderColor: "red",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "white",
                                pointBackgroundColor: "black",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "black",
                                pointHoverBorderColor: "brown",
                                pointHoverBorderWidth: 2,
                                pointRadius: 4,
                                pointHitRadius: 10,
                                data:res.cancelled,
                                spanGaps: false,                          
                            }],
                        }

                        $('#userChart').remove();
                        $('#userwrapper').append('<canvas id="userChart" width="400" height="200"></canvas>');
                        //Start Chart plotting.
                        var ctx = $('#userChart');
                        var myLineChart = new Chart(ctx, {
                            type:'line',
                            data:data
                        });
                }
            };
            ajx.open("POST", "{{route('u.bookingchart')}}", true);
            ajx.setRequestHeader("Content-type", "application/json");
            ajx.send(JSON.stringify(param));
        }
    </script>
@endsection