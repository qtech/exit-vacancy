@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">Hotel SMS</h3>
                <a href="{{route('h.addsms')}}" class="btn btn-custom pull-right">Send SMS</a>
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
                <th>Date</th>
                <th>Time</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($sms as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->created_at->format('d-m-y')}}</td>
                    <td>{{$value->created_at->format('H:i')}}</td>
                    <td>{{$value->message}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection