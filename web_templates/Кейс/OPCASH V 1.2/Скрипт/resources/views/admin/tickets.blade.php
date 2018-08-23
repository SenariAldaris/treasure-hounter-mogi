@extends('admin.layout')

@section('content')


<style>
td {
        white-space: nowrap;
        word-wrap: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }</style>


<div class="top-bar">
    <h3>Tickets</h3>

</div>

<div class="well no-padding">


    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Places</th>
            <th>Jackpot</th>
        </tr>
        </thead>
        <tbody>


        @foreach($tickets as $i)


        <tr>
            <td>{{$i->id}}</td>
            <td>{{$i->name}}</td>
            <td><span class="label label-success">{{$i->price}}</span></td>
            <td><span class="label label-important">{{$i->places}}</span></td>
            <td><span class="label label-success">{{$i->jackpot}}</span></td>
            <td><a href="/admin/ticket/{{$i->id}}">Редактировать</a></td>
        </tr>
        @endforeach


        </tbody>
    </table>
    <!-- / Add News: WYSIWYG Edior -->

</div>
<!-- / Add News: Content -->


</div>

</div>




@endsection
