@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">Hotel Details</h3>
                <a href="{{route('hotelusers')}}" class="btn btn-custom pull-right">Back</a>
            </div>
        </div>
    </div>
</header>
<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Star</th>
                    <th>Base Price</th>
                    <th>Ratings</th>
                    <th>Image</th>
                    <th>Amenities</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($details as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->hotel_name}}</td>
                    <td>{{$value->stars}} <span class="font-icon font-icon-star" style="color:orange;"></span></td>
                    <td>${{$value->price}}</td>
                    <td>{{$value->ratings}}</td>
                    <td>
                        <img height="30px;" width="60px;" src="{{$value->image}}">    
                    </td>
                    <td>
                        <label class="label label-info">{{$value->amenities}}</label>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection