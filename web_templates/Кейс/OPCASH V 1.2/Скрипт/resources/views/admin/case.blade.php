@extends('admin.layout')

@section('content')



    <div class="top-bar">
        <h3>Кейс {{$case->id}}-го уровня</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/casedit" class="form-horizontal">
            <input  name="id" value="{{$case->id}}"  type="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">



            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Min</label>
                <div class="controls">
                    <input type="text" name="min" value="{{$case->price_min}}" placeholder="..." class="input-block-level">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Max</label>
                <div class="controls">
                    <input type="number" name="max" value="{{$case->price_max}}" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">Price</label>
                <div class="controls">
                    <input type="number" name="price" value="{{$case->price}}" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">x10</label>
                <div class="controls">
                    <input type="number" name="x10" value="{{$case->x10}}" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">x20</label>
                <div class="controls">
                    <input type="number" name="x20" value="{{$case->x20}}" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">x30</label>
                <div class="controls">
                    <input type="number" name="x30" value="{{$case->x30}}" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNormal">Type</label>

                <select class="input-block-level" name="type" style="margin-left:30px;">
                      <option value="money" @if($case->type == 'money') selected @endif>Money</option>
                      <option value="gift" @if($case->type == 'gift') selected @endif>Gift</option>
                </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">Предметы через запятую</label>
                <div class="controls">
                    <input type="text" name="items" value="{{$case->items}}" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">% на выпадение дропа меньше стоимости кейса</label>
                <div class="controls">
                    <input type="text" name="bad" value="{{$case->bad_procent}}" placeholder="..." class="input-block-level">
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
