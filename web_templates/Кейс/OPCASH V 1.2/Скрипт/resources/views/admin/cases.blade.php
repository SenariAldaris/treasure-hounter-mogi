@extends('admin.layout')

@section('content')


<style>td {
        white-space: nowrap;
        word-wrap: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }</style>


<div class="top-bar">
    <h3>Cases</h3>

</div>


<div class="well no-padding">


    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Min</th>
            <th>Max</th>
            <th>Price</th>
            <th>x10</th>
            <th>x20</th>
            <th>x30</th>
            <th>% дропа < ceni </th>
        </tr>
        </thead>
        <tbody>


        @foreach($cases as $i)


        <tr>
            <td>{{$i->id}} <img src="{{$i->img}}" alt="{{$i->id}}" style="width: 50px;heigth:50px;" class="userpic"></img></td>
            <td>{{$i->price_min}}</td>
            <td>{{$i->price_max}}</td>
            <td>{{$i->price}}</td>
            <td>{{$i->x10}}</td>
            <td>{{$i->x20}}</td>
            <td>{{$i->x30}}</td>
            <td><span class="label label-success">{{$i->bad_procent}}</span></td>
            <td><a href="/admin/cases/{{$i->id}}">Редактировать</a></td>
        </tr>
        @endforeach


        </tbody>
    </table>


    {{$cases->render()}}
    <!-- / Add News: WYSIWYG Edior -->

</div>
<!-- / Add News: Content -->


</div>

</div>


@endsection
