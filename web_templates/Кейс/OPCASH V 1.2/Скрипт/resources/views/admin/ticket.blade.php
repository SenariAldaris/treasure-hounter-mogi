@extends('admin.layout')

@section('content')



    <div class="top-bar">
        <h3>Ticket #{{$ticket->id}}</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/ticketsave" class="form-horizontal">
            <input  name="id" value="{{$ticket->id}}"  type="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">



            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Name</label>
                <div class="controls">
                    <input type="text" name="name" value="{{$ticket->name}}" placeholder="..." class="input-block-level">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Price</label>
                <div class="controls">
                    <input type="number" name="price" value="{{$ticket->price}}" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputInline">Places</label>
                <div class="controls">
                    <input type="number" name="places" value="{{$ticket->places}}" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputInline">Jackpot</label>
                <div class="controls">
                    <input type="number" name="jackpot" value="{{$ticket->jackpot}}" placeholder="..." class="input-block-level">
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
