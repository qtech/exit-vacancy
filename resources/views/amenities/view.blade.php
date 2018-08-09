@extends('layout.layout')

@section('content')
<style>
    .border-custom{
        border: 1px solid #00857B !important;
    }
</style>
<section class="card box-typical-full-height">
    <div class="card-block">
    <h5 class="m-t-lg">Add Amenities</h5>
    <form id="myform" method="POST">
        <div class="col-lg-5 pull-left">
            <textarea id="tags-editor-textarea" id="amenities" name="amenities[]"></textarea>
        </div>
        <div class="col-lg-5 pull-left">
            <input onclick="addamenity(); event.preventDefault();" type="submit" class="btn btn-custom" value="Add">
        </div>
    </form>
    </div>
    <div class="card-block">
        <h5 class="m-t-lg">Available Amenities</h5>
        <div class="row">
            <div class="col-sm-12">
                <div id="demo" class="row">

                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function(){
        getdata();
    });

function getdata(){
    var ajx = new XMLHttpRequest();
    ajx.onreadystatechange = function () {
        if (ajx.readyState == 4 && ajx.status == 200) {
            var demo = JSON.parse(ajx.responseText);
            document.getElementById("demo").innerHTML = "";
            demo.data.forEach(function(data){ 
                if(data.status == 1)
                {
                    document.getElementById("demo").innerHTML +=
                    `<div class="col-sm-3">
                        <section class="widget widget-simple-sm border-custom">
                            <div class="widget-simple-sm-fill-caption" style="position:relative; top:10px;">
                                <strong>${data.amenity_name}</strong>
                            </div>
                            <a onclick="disableamenity(${data.amenity_id});" style="border-bottom:none;position:relative; top:-20px; right:-100px">
                                <i class="fa fa-ban" style="color:#00857B; font-size:1.0em;"></i>
                            </a>
                        </section>
                    </div>`
                }
                else{
                    document.getElementById("demo").innerHTML +=
                    `<div class="col-sm-3">
                        <section class="widget widget-simple-sm border-custom">
                            <div class="widget-simple-sm-fill-caption" style="position:relative; top:10px;">
                                <strong>${data.amenity_name}</strong>
                            </div>
                            <a href="#" onclick="disableamenity(${data.amenity_id});" style="border-bottom:none;">
                                <i class="fa fa-check" style="color:#00857B; font-size:1.0em; position:relative; top:-20px; right:-100px"></i>
                            </a>
                        </section>
                    </div>`
                }
            });
        }
    };
    ajx.open("GET", "{{route('getamenities')}}", true);
    ajx.send();
}

function disableamenity(id){
    var formdata = new FormData();
    formdata.append('id',id);
    formdata.append('_token','{{csrf_token()}}');
    var ajx = new XMLHttpRequest();
    ajx.onreadystatechange = function () {
        if (ajx.readyState == 4 && ajx.status == 200) {
            var demo = JSON.parse(ajx.responseText);
            if(demo.status == 1)
            {
                getdata();
                notification('success',demo.msg);
            }
            else
            {
                notification('danger',demo.msg);
            }
        }
    };

    ajx.open("POST", "{{route('disableamenity')}}", true);
    ajx.send(formdata);
}

function addamenity(){
    var form = document.getElementById("myform");
    var formData = new FormData(form);
    formData.append('_token','{{csrf_token()}}');
    
    var ajx = new XMLHttpRequest();
    ajx.onreadystatechange = function () {
        if (ajx.readyState == 4 && ajx.status == 200) {
            var demo = JSON.parse(ajx.responseText);
            if(demo.status == 1)
            {
                getdata();
                notification('success',demo.msg);
            }
            else
            {
                notification('danger',demo.msg);
            }
        }
    };
    ajx.open("POST", "{{route('addamenity')}}", true);
    // ajx.setRequestHeader("Content-type", "application/json");
    ajx.send(formData);
}
</script>
</section>
@endsection