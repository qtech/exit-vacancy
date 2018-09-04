@extends('layout.layout')

@section('content')
<section class="card">
    <div class="card-block">
        <h5 class="m-t-lg"><strong>Transactions</strong></h5>
        <br>
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('all_transactions')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-new'}}">All Transactions</a>
                <a href="{{route('all_transactions',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-new'}}">Today</a>
                <a href="{{route('all_transactions',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-new'}}">This Week</a>
                <a href="{{route('all_transactions',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-new'}}">This Month</a>
                @if($id == '')
                    <a href="#" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 1)
                    <a href="#" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 2)
                    <a href="#" class="btn btn-custom pull-right">Export</a>
                @endif
                @if($id == 3)
                    <a href="#" class="btn btn-custom pull-right">Export</a>
                @endif
            </div>
        </div>
        <br>
        <form method="POST" id="t_Form">
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>To:</strong><input class="flatpickr form-control" id="t_date2" name="t_date2" type="text" placeholder="Date">
                </div>
            </div>
            <div class="col-3 pull-right">
                <div class="form-group">
                    <strong>From:</strong><input class="flatpickr form-control" id="t_date1" name="t_date1" type="text" placeholder="Date">
                </div>
            </div>
        </form>
        <div id="chart1wrapper">
            <canvas id="myChart1" width="400" height="100"></canvas>
        </div>
        <br><br>
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>User Name</th>
                <th>Hotel Name</th>
                <th>Room Type</th>
                <th>Total Amount</th>
                <th>Commission</th>
                <th>Hotel Payment</th>
            </tr>
            </thead>
            <tbody>
                @foreach($transactions as $value)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>{{$value->user->fname}} {{$value->user->lname}}</td>
                    <td>{{$value->hotel->hotel_name}}</td>
                    <td>{{$value->roomtype}}</td>
                    <td>${{$value->total_amount}}</td>
                    <td>{{$value->admin_commission}}%</td>
                    <td>${{$value->hotel_payment}}</td>
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
            Chart.defaults.global.defaultFontSize = 13;
            $('.flatpickr').flatpickr({
                onChange: function() {
                    t_withdates();
                }
            });
        });

        var all = "{{route('all_transactions')}}";
        var today = "{{route('all_transactions',['id' => 1])}}";
        var week = "{{route('all_transactions',['id' => 2])}}";
        var month = "{{route('all_transactions',['id' => 3])}}";

        if(window.location.href == all) {
            transactions();
        }
        
        if(window.location.href == today) {
            t_transactions();
        }

        if(window.location.href == week) {
            w_transactions();
        }

        if(window.location.href == month) {
            m_transactions();
        }

        function t_withdates(){
            var date1 = document.getElementById("t_date1").value;
            var date2 = document.getElementById("t_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("t_Form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');

                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                    if (ajx.readyState == 4 && ajx.status == 200) {
                            var res = JSON.parse(ajx.responseText);                                        
                            var data = {
                                labels: res.dateLabel,
                                datasets:[{
                                    label:'Transactions',
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
                                    data:res.transactions,
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
                ajx.open("POST", "{{route('wd.transactions')}}", true);
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
                            fill: true,    
                            tension: 0.4,                        
                            backgroundColor: "#54bcb4",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
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
                            data:res.transactions,
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
                    })
                }
            }
            ajx.open('GET','{{route('t.chart')}}',true);
            ajx.send();
        }

        function t_transactions(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Transactions',
                            fill: true,    
                            tension: 0.4,                        
                            backgroundColor: "#54bcb4",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
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
                            data:res.transactions,
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
                    })
                }
            }
            ajx.open('GET','{{route('t.transactions')}}',true);
            ajx.send();
        }

        function w_transactions(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Transactions',
                            fill: true,    
                            tension: 0.4,                        
                            backgroundColor: "#54bcb4",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
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
                            data:res.transactions,
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
                    })
                }
            }
            ajx.open('GET','{{route('w.transactions')}}',true);
            ajx.send();
        }

        function m_transactions(){
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function() {
                if(ajx.readyState == 4 && ajx.status == 200){
                    var res = JSON.parse(ajx.responseText);                                        
                    var data = {
                        labels: res.dateLabel,
                        datasets:[{
                            label:'Transactions',
                            fill: true,    
                            tension: 0.4,                        
                            backgroundColor: "#54bcb4",
                            borderColor: "#00857B", // The main line color
                            borderCapStyle: 'square',
                            borderDash: [0,0], // try [5, 15] for instance
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
                            data:res.transactions,
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
                    })
                }
            }
            ajx.open('GET','{{route('m.transactions')}}',true);
            ajx.send();
        }
    </script>
@endsection