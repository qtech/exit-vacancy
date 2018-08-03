@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h5 class="m-t-lg with-border">Add Notification</h5>
    <form>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                    <small class="text-muted">Please give a title to your notification</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="message">Description</label>
                    <textarea rows="4" name="message" id="message" class="form-control" placeholder="Textarea"></textarea>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input onclick="addnotification(); event.preventDefault();" type="submit" class="btn btn-primary" value="Add">
                <a href="{{route('h.notifications')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function addnotification(){
        var title = document.getElementById("title").value;
        var message = document.getElementById("message").value;
        var param = {
            "title":title,
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
                        window.location.href = '{{route("h.notifications")}}';
                    },1500);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('h.storenotification')}}", true);
        ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(JSON.stringify(param));
    }
</script>
@endsection