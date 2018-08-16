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
                                {{$hoteluser->hotel->hotel_name}}
                            </div>
                        </div>
                        <div class="tbl-cell tbl-cell-date">
                            <strong>Last Login:</strong> {{$hoteluser->last_login}}
                            <a href="{{route('hotelusers')}}" class="btn btn-sm btn-custom" style="margin-left:25px;">BACK</a>
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
                                <div class="tbl-cell" style="font-size:14px;">{{date('d-M-Y', strtotime($hoteluser->created_at))}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Owner</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->fname}} {{$hoteluser->lname}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Class</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->stars}}
                                        <i class="font-icon font-icon-star" style="color:orange;"></i>
                                </div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Email</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->email}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Number</div>
                                <div class="tbl-cell" style="font-size:14px;">+{{$hoteluser->hotel->number}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Ratings</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->ratings}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Bookings</div>
                                <div class="tbl-cell" style="font-size:14px;"><strong>{{$hoteluser->bookings}}</strong></div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Amenities</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->amenities}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Address</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->building}}, {{$hoteluser->hotel->street}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">City</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->city}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">State</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->state}}</div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell tbl-cell-lbl">Country</div>
                                <div class="tbl-cell" style="font-size:14px;">{{$hoteluser->hotel->country}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="hotelwrapper">
                            <canvas id="hotelChart" width="400" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <section class="proj-page-section proj-page-people">
                <header class="proj-page-subtitle padding-sm">
                    <h3>Images</h3>
                </header>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="{{$hoteluser->hotel->image}}">
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
                        <th>Name</th>
                        <th>Room Type</th>
                        <th>Room Price</th>
                        <th>Status</th>
                        <th>Arrived</th>
                        <th>Arrival Time</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $value)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$value->user->fname}} {{$value->user->lname}}</td>
                            <td>{{$value->roomtype}}</td>
                            <td>${{$value->roomprice}}</td>
                            <td style="text-align:center;">
                                @if($value->status == 1)
                                    <label class="label label-success">Accepted</label>
                                @else
                                    <label class="label label-danger">Declined</label>
                                @endif
                            </td>
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
            hotelbookings();
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontStyle = 'bold';
            Chart.defaults.global.defaultFontSize = 13;
        });

        function hotelbookings(){
            
            var param = {
                "id":'{{$hoteluser->user_id}}',
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

                        $('#hotelChart').remove();
                        $('#hotelwrapper').append('<canvas id="hotelChart" width="400" height="200"></canvas>');
                        //Start Chart plotting.
                        var ctx = $('#hotelChart');
                        var myLineChart = new Chart(ctx, {
                            type:'line',
                            data:data
                        });
                }
            };
            ajx.open("POST", "{{route('h.bookingchart')}}", true);
            ajx.setRequestHeader("Content-type", "application/json");
            ajx.send(JSON.stringify(param));
        }
    </script>
@endsection