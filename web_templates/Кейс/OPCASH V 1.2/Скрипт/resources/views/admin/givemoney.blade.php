@extends('admin.layout')

@section('content')
    <div class="top-bar">
        <h3>Пользователь {{$user->username}}</h3>

    </div>
    <div class="well no-padding">
        <!-- Forms: Form -->
        <form method="post" action="/admin/givemoney/{{$user->id}}" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Сумма перевода</label>
                <div class="controls">
                    <input type="text" name="money" placeholder="..." class="input-block-level">
                </div>
            </div>
            <!-- Forms: Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
  </div>
</div>

@endsection
