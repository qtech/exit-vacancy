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
            <input onclick="addamenity(); event.preventDefault();" type="submit" class="btn btn-primary" value="Add">
        </div>
    </form>
    </div>
    <div class="card-block">
        <h5 class="m-t-lg">Available Amenities</h5>
        <div class="row">
            <div class="col-sm-12">
                <div id="demo">

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
                document.getElementById("demo").innerHTML += 
                `<div class="col-sm-3">
                    <section class="widget widget-simple-sm border-custom">
                        <div class="widget-simple-sm-fill-caption" style="position:relative; top:10px;">
                            ${data.amenity_name}
                        </div>
                        <a href="#" style="border-bottom:none;" data-toggle="modal" data-target="#myModal${data.amenity_id}">
                            <i class="fa fa-trash" style="color:#00857B; font-size:1.0em; position:relative; top:-20px; right:-100px"></i>
                        </a>
    <div class="modal fade" id="myModal${data.amenity_id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="myModalLabel">Confirm Action</h4>
				</div>
				<div class="modal-body">
					<h6>Are you sure you want to delete this amenity: <code>${data.amenity_name}</code> ?</h6>
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
                    <a href="#" onclick="deleteamenity(${data.amenity_id});" class="btn btn-rounded btn-danger" data-dismiss="modal">Delete</a>
                </div>
			</div>
		</div>
	</div>
                    </section>
                </div>`
            });
        }
    };
    ajx.open("GET", "{{route('getamenities')}}", true);
    ajx.send();
}

function deleteamenity(id){
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

    ajx.open("POST", "{{route('deleteamenity')}}", true);
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