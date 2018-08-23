@extends('admin.layout')

@section('content')



<input id="dp5" type="text" data-slider-min="-5" data-slider-max="20" data-slider-step="1" data-slider-value="0"/>
    <div class="top-bar">
        <h3>Последние 20 выигрышей</h3>

    </div>

    <div class="well no-padding">


        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Пользователь</th>
                <th>Кейс</th>
                <th>Выиграл</th>
                <th>Потратил</th>
            </tr>
            </thead>
            <tbody>

            @foreach($drop as $i)
                <tr>
                    <td>{{$i->id}}</td>
                    <td><a href="/profile/{{$i->user_id}}">{{$i->username}}</a></td>
                    <td><a href="/cases/{{$i->case_id}}">Кейс #{{$i->case_id}}</a></td>
                    <td>{{$i->price}}</td>
                    <td>{{$i->case_price}}</td>
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
