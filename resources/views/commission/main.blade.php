@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h4 class="m-t-lg with-border">Admin Commission</h4>
    <form id="myform" method="POST">
        <div class="form-group">
            <div class="col-lg-9">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="bookings">Set number of Bookings</label>
                    <input type="number" class="form-control" name="bookings" id="bookings" value="{{$admin->bookings}}">
                    <small class="text-muted"><b>Initial commission</b> will be applied in payments for specific number of bookings you set. After this specific number of bookings accepted by hotels, <b>Default commission</b> will be applied in payments.</small>
                </fieldset>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-5">
                    <div class="col-lg-10">
                        <h3><u>Initial Commission</u></h3>
                        <br>
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="commission_type">Select Type</label> 
                                <select class="custom-select" id="commission_type" name="commission_type">
                                    <option @if($admin->commission_type == 1) selected @endif value="1">Amount</option>
                                    <option @if($admin->commission_type == 2) selected @endif value="2">Percentage</option>
                                </select>   
                        </fieldset>
                    </div>
                    <br>
                    <div class="col-lg-10">
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="rate">Amount / Percentage</label>
                            <input type="number" class="form-control" name="rate" id="rate" value="{{$admin->commission}}">
                            <small class="text-muted">Set your <b>INITIAL</b> commission in payments</small>
                        </fieldset>
                    </div>
                </div>
                <div style="border-left: 3px solid #00857B; height: 280px; margin-left:50px; margin-right:20px;"></div>
                <div class="col-lg-5">
                    <div class="col-lg-10">
                        <h3><u>Default Commission</u></h3>
                        <br>
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="default_commission_type">Select Type</label>
                            <select class="custom-select" id="default_commission_type" name="default_commission_type">
                                <option @if($admin->default_commission_type == 1) selected @endif value="1">Amount</option>
                                <option @if($admin->default_commission_type == 2) selected @endif value="2">Percentage</option>
                            </select>
                        </fieldset>
                    </div>
                    <br>
                    <div class="col-lg-10">
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="default_rate">Amount / Percentage</label>
                            <input type="number" class="form-control" name="default_rate" id="default_rate" value="{{$admin->default_commission}}">
                            <small class="text-muted">Set your <b>DEFAULT</b> commission in payments</small>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <input onclick="updatecommission(); event.preventDefault();" type="submit" class="btn btn-custom" value="Update">
                </fieldset>
            </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function updatecommission(){
        var form = document.getElementById("myform");
        var formData = new FormData(form);
        formData.append('_token','{{csrf_token()}}');

        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    notification('success',demo.msg);
                    document.getElementById('rate').value = demo.data.commission;
                    document.getElementById('default_rate').value = demo.data.default_commission;
                    document.getElementById('bookigns').value = demo.data.bookings;
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('updatecommission')}}", true);
        //ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection