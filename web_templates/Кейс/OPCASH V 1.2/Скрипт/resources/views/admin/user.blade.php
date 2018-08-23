@extends('admin.layout')

@section('content')



    <div class="top-bar">
        <h3>Пользователь {{$user->username}}</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/userdit" class="form-horizontal">
            <input  name="id" value="{{$user->id}}"  type="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">



            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Name</label>
                <div class="controls">
                    <input type="text" name="username" value="{{$user->username}}" placeholder="..." class="input-block-level">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Баланс</label>
                <div class="controls">
                    <input type="text" name="money" value="{{$user->money}}" placeholder="..." class="input-block-level">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Админ</label>
                <div class="controls">

                    <select class="span6 m-wrap" name="is_admin">
                        <option value="1" @if($user->is_admin == 1) selected @endif>Да</option>
                        <option value="0" @if($user->is_admin == 0) selected @endif>Нет</option>
                    </select>


                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">Youtuber</label>
                <div class="controls">

                    <select class="span6 m-wrap" name="is_yt">
                        <option value="1" @if($user->is_yt == 1) selected @endif>Да</option>
                        <option value="0" @if($user->is_yt == 0) selected @endif>Нет</option>
                    </select>

                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>

            </div>
        </form>
    </div>
    </div>

    </div>

@endsection
