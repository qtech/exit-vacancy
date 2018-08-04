@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h5 class="m-t-lg with-border">Send SMS</h5>
    <form>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="message">Message</label>
                    <textarea rows="4" name="message" id="message" class="form-control" placeholder="Textarea"></textarea>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input onclick="addsms(); event.preventDefault();" type="submit" class="btn btn-primary" value="Add">
                <a href="{{route('h.sms')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function addsms(){
        var message = document.getElementById("message").value;
        var param = {
            "message":message,
            "_token":'{{csrf_token()}}'
        }

        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    notification('success',demo.msg);
                    setTimeout(function(){
                        window.location.href = '{{route("h.sms")}}';
                    },1500);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('h.storesms')}}", true);
        ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(JSON.stringify(param));
    }
</script>
@endsection