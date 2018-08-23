@extends('admin.layout')

@section('content')



    <div class="top-bar">
        <h3>Новый предмет</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/addItem" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Цена</label>
                <select class="input-block-level" name="price" style="margin-left:30px;">
                  @foreach($number as $c)
                      <option value="{{$c->number}}">{{$c->number}} rub</option>
                  @endforeach
                </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNormal">Категория</label>
                <div class="controls">
                    <select class="span6 m-wrap" name="case">
                        @foreach($cases as $c)
                            <option value="{{$c->id}}">Кейс #{{$c->id}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputNormal">Изображение</label>
                <select class="input-block-level" name="img"style="margin-left:30px;">
                  @foreach($number as $c)
                      <option value="/uploads/coin-{{$c->number}}.svg">{{$c->number}} rub</option>
                  @endforeach
                </select>
            </div>
            <!-- / Forms: Form Textarea -->


            <!-- Forms: Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>

            </div>
            <!-- / Forms: Form Actions -->

        </form>
        <!-- / Forms: Form -->


        <!-- / Add News: WYSIWYG Edior -->

    </div>
    <!-- / Add News: Content -->




    </div>

    </div>

@endsection
