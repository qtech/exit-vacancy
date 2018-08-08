@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">User Queries</h3>
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
                <th>Subject</th>
                <th>Email</th>
                <th>Message</th>
                <th>Number</th>
            </tr>
            </thead>
            <tbody>
                @foreach($queries as $value)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$value->subject}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->message}}</td>
                    <td>{{$value->number or "Not provided"}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection