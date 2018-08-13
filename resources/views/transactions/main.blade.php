@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <section class="card box-typical">
            <div class="card-block">
                <h5 class="m-t-lg pull-left"><strong>Transactions</strong></h5>
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
            </div>
        </section>
    </div>
</div>
<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="#" class="btn btn-custom">All Transactions</a>
                <a href="#" class="btn btn-custom">Today</a>
                <a href="#" class="btn btn-custom">This Week</a>
                <a href="#" class="btn btn-custom">This Month</a>
                {{-- @if($id == '')
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
                @endif --}}
            </div>
        </div>
        <br>
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>User Name</th>
                <th>Customer Name</th>
                <th>Room Type</th>
                <th>Price</th>
                <th>Commission</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
                {{-- @foreach($hotelusers as $value) --}}
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                {{-- @endforeach --}}
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
            transactions();
            $('.flatpickr').flatpickr({
                onChange: function() {
                    t_withdates();
                }
            });
        });

        function t_withdates(){
            var date1 = document.getElementById("t_date1").value;
            var date2 = document.getElementById("t_date2").value;
            if(date1 != '' && date2 != '')
            {
                var form = document.getElementById("b_Form");
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
                                    data:res.transactions,
                                    spanGaps: true,
                                }],
                            }

                            $('#myChart1').remove();
                            $('#chart1wrapper').append('<canvas id="myChart1" width="400" height="200"></canvas>');
                            //Start Chart plotting.
                            var ctx = $('#myChart1');
                            var myLineChart = new Chart(ctx, {
                                type:'line',
                                data:data
                            });
                    }
                };
                ajx.open("POST", "#", true);
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
    </script>
@endsection