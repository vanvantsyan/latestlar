<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="title_r">Родительный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $pattern }}_r" name="{{ $cases }}[r]" 
               value="{{ old("{$cases}.r", $element->$cases['r'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_r_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $pattern }}_r_morpher">
            {{ 'в ' . Gliss::case($element->$pattern, 'П') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_d">Дательный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $pattern }}_d" name="{{ $cases }}[d]" 
               value="{{ old("{$cases}.d", $element->$cases['d'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_d_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $pattern }}_d_morpher">
            {{ Gliss::case($element->$pattern, 'Д') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_v">Винительный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $pattern }}_v" name="{{ $cases }}[v]" 
               value="{{ old("{$cases}.v", $element->$cases['v'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_v_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $pattern }}_v_morpher">
            {{ 'в ' .  Gliss::case($element->$pattern, 'В') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_t">Творительный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $pattern }}_t" name="{{ $cases }}[t]" 
               value="{{ old("{$cases}.t", $element->$cases['t'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_t_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $pattern }}_t_morpher">
            {{ Gliss::case($element->$pattern, 'Т') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_p">Предложный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $pattern }}_p" name="{{ $cases }}[p]" 
               value="{{ old("{$cases}.p", $element->$cases['p'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $pattern }}_p_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $pattern }}_p_morpher">
            {{ 'о ' . Gliss::case($element->$pattern, 'П') }}
        </p>
    </div>
</div>