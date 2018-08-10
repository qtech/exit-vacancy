@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h4 class="m-t-lg with-border">Commission Rate</h4>
    <form id="myform" method="POST">
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="rate">Commission</label>
                    <input type="number" class="form-control" name="rate" id="rate" value="{{$admin->lname}}">
                    <small class="text-muted">Set commission % in payments</small>
                </fieldset>
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
                    document.getElementById('rate').value = demo.data.lname;
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