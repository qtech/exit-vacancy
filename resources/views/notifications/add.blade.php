@extends('layout.layout')

@section('content')
<style>
    .btn-custom{
        background-color: #00857B;
        border-color: #00857B;
    } 
    .btn-custom:hover{
        background-color: #00857ba8;
        border-color: #00857B;
    }   
</style>
<div class="box-typical" style="padding-left:25px;">
    <h5 class="m-t-lg with-border">Send Notification</h5>
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
    </form>
</div>

<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <a href="{{route('addnotification')}}" class="btn {{$id == '' ? 'btn-custom' : 'btn-default'}}">All Users</a>
                <a href="{{route('addnotification',['id' => 1])}}" class="btn {{$id == 1 ? 'btn-custom' : 'btn-default'}}">No Bookings</a>
                <a href="{{route('addnotification',['id' => 2])}}" class="btn {{$id == 2 ? 'btn-custom' : 'btn-default'}}">Bookings this month</a>
                <a href="{{route('addnotification',['id' => 3])}}" class="btn {{$id == 3 ? 'btn-custom' : 'btn-default'}}">More than 5 Bookings</a>
                <a href="{{route('addnotification',['id' => 4])}}" class="btn {{$id == 4 ? 'btn-custom' : 'btn-default'}}">Registered this month</a>
            </div>
        </div>
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
                <th>User Status</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($users as $value)
                <tr>
                    <td>
                        <input type="checkbox" class="checkbox" name="notifications[]" value="{{$value->user_id}}">
                    </td>
                    <td>
                        <a style="border-bottom:none !important; color:black;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname or $value->user->fname}} {{$value->lname or $value->user->lname}}</a>
                    </td>
                    <td>{{$value->email or $value->user->email}}</td>
                    <td>{{$value->customer->number}}</td>
                    <td>
                        @if($value->is_email_verify == 1 || @$value->user->is_email_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->is_mobile_verify == 1 || @$value->user->is_mobile_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->user_status == 1 || @$value->user->user_status == 1)
                            <a href="{{route('disableuser',['id' => $value->user_id])}}"><label class="label label-success">Active</label></a>
                        @else
                            <a href="{{route('enableuser',['id' => $value->user_id])}}"><label class="label label-danger">In-Active</label></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <input onclick="addnotification(); event.preventDefault();" type="submit" class="btn btn-primary" value="Send">
                <a href="{{route('notifications')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function addnotification(){
        var temp = [];
        var title = document.getElementById("title").value;
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
            "title":title,
            "message":message,
            "notifications":temp,
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
                        window.location.href = '{{route("notifications")}}';
                    },1500);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('storenotification')}}", true);
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