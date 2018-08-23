@extends('admin.layout')

@section('content')



        <div class="top-bar">
            <h3>Последние запросы на вывод</h3>

        </div>



        <div class="well no-padding">


            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Пользователь</th>
                    <th>Case id</th>
                    <th>Login</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($a as $b)
                    <tr>
                        <td>{{$b->id}}</td>
                        <td><a href="/profile/{{$b->user}}">{{$b->username}}</a></td>
                        <td><a href="/cases/{{$b->case_id}}">{{$b->case_id}}</a></td>
                        <td><a href="http://www.vk.com/{{$b->login}}">{{$b->login}}</a></td>
                        <td><a href="/admin/vivodclosegift/{{$b->id}}">Нажми чтобы закрыть</a></td>
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
