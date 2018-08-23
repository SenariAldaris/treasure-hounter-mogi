@extends('admin.layout')

@section('content')
    <div class="top-bar">
        <h3>Новый кейс</h3>
    </div>
    <div class="well no-padding">
        <form method="post" action="/admin/addCase" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="control-group">
                <label class="control-label" for="inputNormal">Минимальная цена вещей (для вида)</label>
                <div class="controls">
                    <input type="number" name="minPrice" value="" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputNormal">Максимальная цена вещей (для вида)</label>
                <div class="controls">
                    <input type="number" name="maxPrice" value="" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputNormal">Цена кейса</label>
                <div class="controls">
                    <input type="number" name="Price" value="" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputNormal">Item</label>

                <select class="input-block-level" name="img"style="margin-left:30px;">
                  @foreach($number as $c)
                      <option value="/uploads/coin-{{$c->number}}.svg">{{$c->number}} rub</option>
                  @endforeach
                        <option value="/uploads/gift-steam-g.png">Steam Gift</option>
                        <option value="/uploads/gift-psn-g.png">PSN Gift</option>
                        <option value="/uploads/gift-itunes-g.png">Itunes Gift</option>
                        <option value="/uploads/gift-google-g.png">Google Play Gift</option>
                        <option value="/uploads/gift-g2a-g.png">G2A Gift</option>
                </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNormal">Предметы через запятую</label>
                <div class="controls">
                    <input type="text" name="items" value="" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNormal">Type</label>

                <select class="input-block-level" name="type" style="margin-left:30px;">
                      <option value="money">Money</option>
                      <option value="gift">Gift</option>
                </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputInline">% на выпадение дропа меньше стоимости кейса(1-100)</label>
                <div class="controls">
                    <input type="text" name="bad" value="" placeholder="..." class="input-block-level">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNormal">Цена на 10% шанс</label>
                <div class="controls">
                    <input type="number" name="x10" value="" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputNormal">Цена на 20% шанс</label>
                <div class="controls">
                    <input type="number" name="x20" value="" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputNormal">Цена на 30% шанс</label>
                <div class="controls">
                    <input type="number" name="x30" value="" placeholder="..." class="input-block-level">
                </div>
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
