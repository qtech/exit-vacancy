@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h4 class="m-t-lg with-border">Hotel Profile</h4>
    <form id="myform" method="POST">
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Number</label>
                    <input type="text" class="form-control" name="number" id="number" value="{{$getdetails['details']->hotel->number}}">
                    <small class="text-muted">Update number for your Hotel</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Hotel Class</label>
                    <input type="number" class="form-control" name="hotelclass" id="hotelclass" value="{{$getdetails['details']->hotel->stars}}">
                    <small class="text-muted">Update class for your Hotel</small>
                </fieldset>
            </div>
        </div>
        @php    
            $split = explode(",", $getdetails['details']->hotel->amenities);
        @endphp
        <div class="form-group">
            <div class="col-md-12">
                <label class="form-label semibold" for="title">Select Amenities</label>
                <select class="select2" name="amenities[]" id="amenities" multiple="multiple">
                    @foreach($getdetails['amenities'] as $tmp)
                        <option
                        @if(in_array($tmp->amenity_name, $split))
                            selected
                        @endif
                        value="{{$tmp->amenity_name}}">{{$tmp->amenity_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Amenities</label>
                    @foreach($split as $value)
                        <label class="label label-secondary">{{$value}}</label>
                    @endforeach
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Rooms Available</label>
                        @if($getdetails['details']->hotel->king_room > 0)
                            <label class="label label-info">{{$getdetails['details']->hotel->king_room}} King Rooms</label>
                        @endif 
                        @if($getdetails['details']->hotel->queen_room > 0)
                            <label class="label label-warning">{{$getdetails['details']->hotel->queen_room}} Two-Queen Rooms</label>
                        @endif
                </fieldset>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <input onclick="editprofile(); event.preventDefault();" type="submit" class="btn btn-primary" value="Update">
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function editprofile(){
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
                    setTimeout(function(){
                        window.location.href = '{{route("hotelprofile")}}';
                    },1500);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('updatehotelprofile')}}", true);
        // ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection