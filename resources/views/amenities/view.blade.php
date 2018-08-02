@extends('layout.layout')

@section('content')
<section class="card box-typical-full-height">
    <div class="card-block">
    <h5 class="with-border m-t-lg">Add Amenities</h5>
        <div class="col-lg-5 pull-left">
            <textarea id="tags-editor-textarea"></textarea>
        </div>
        <div class="col-lg-5 pull-left">
            <input onclick="addamenity(); event.preventDefault();" type="submit" class="btn btn-primary" value="Add">
        </div>
    </div>
</section>
@endsection