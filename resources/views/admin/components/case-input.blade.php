<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="title_r">Родительный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $field }}_r" name="{{ $field }}_r" 
               value="{{ old($field . '_r', $element->$case_field['r'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_r_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $field }}_r_morpher">
            {{ 'в ' . Gliss::case($element->$field, 'П') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_d">Дательный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $field }}_d" name="{{ $field }}_d" 
               value="{{ old($field . '_d', $element->$case_field['d'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_d_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $field }}_d_morpher">
            {{ Gliss::case($element->$field, 'Д') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_v">Винительный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $field }}_v" name="{{ $field }}_v" 
               value="{{ old($field . '_v', $element->$case_field['v'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_v_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $field }}_v_morpher">
            {{ 'в ' .  Gliss::case($element->$field, 'В') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_t">Творительный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $field }}_t" name="{{ $field }}_t" 
               value="{{ old($field . '_t', $element->$case_field['t'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_t_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $field }}_t_morpher">
            {{ Gliss::case($element->$field, 'Т') }}
        </p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_p">Предложный падеж</label>
        <input type="text" class="form-control m-input m-input--square" id="{{ $field }}_p" name="{{ $field }}_p" 
               value="{{ old($field . '_p', $element->$case_field['p'] ?? '') }}">
    </div>
    <div class="col-md-6 col-xs-12">
        <label for="{{ $field }}_p_morpher">Морфер</label>
        <p class="form-control-static m-input m-input--square" id="{{ $field }}_p_morpher">
            {{ 'о ' . Gliss::case($element->$field, 'П') }}
        </p>
    </div>
</div>