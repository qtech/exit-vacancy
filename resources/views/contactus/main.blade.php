@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h4 class="m-t-lg with-border">Contact Us</h4>
    <form id="myform" method="POST">
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{$contact->email}}">
                    <small class="text-muted">Add Email address for users to contact you</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{$contact->address}}">
                    <small class="text-muted">Add Address for users to contact you</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="number">Number</label>
                    <input type="number" class="form-control" name="phone" id="phone" value="{{$contact->number}}">
                    <small class="text-muted">Add Number for users to contact you</small>
                </fieldset>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <input onclick="updatecontactus(); event.preventDefault();" type="submit" class="btn btn-custom" value="Update">
                </fieldset>
            </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function updatecontactus(){
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
                    document.getElementById('email').value = demo.data.email;
                    document.getElementById('address').value = demo.data.address;
                    document.getElementById('phone').value = demo.data.number;
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('updatecontactus')}}", true);
        //ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection