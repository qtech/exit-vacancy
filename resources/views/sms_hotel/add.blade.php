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
    </form>
</div>

<section class="card">
    <div class="card-block">
            <h3>Hotels</h3>
        <br>
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><input type="checkbox" id="select_all"></th>
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
                    <td>
                        <input type="checkbox" class="checkbox" name="sms[]" value="{{$value->user_id}}">
                    </td>
                    <td>{{$value->hotel->hotel_name}}</td>
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
                    <td>
                        @if($value->user_status == 1)
                            <a href="#"><label class="label label-success">Active</label></a>
                        @else
                            <a href="#"><label class="label label-danger">In-Active</label></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <input onclick="addsms(); event.preventDefault();" type="submit" class="btn btn-custom" value="Send SMS">
                <a href="{{route('h.sms')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function addsms(){
        var temp = [];
        var message = document.getElementById("message").value;
        var users = document.getElementsByClassName("checkbox");
        
        for(let i=0;i<users.length;i++)
        {
            var demo = document.getElementsByClassName("checkbox")[i].checked;
            if(demo)
            {
                temp.push(document.getElementsByClassName("checkbox")[i].value);
            }
        }

        var param = {
            "message":message,
            "sms":temp,
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
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                 $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
</script>
@endsection