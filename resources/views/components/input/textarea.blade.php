@props(['name', 'label', 'value' => '', 'data' => null, 'placeholder' => '', 'disabled' => '', 'readonly' => '', 'rows' => 3])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <textarea id="{{$name}}" rows="{{$rows}}" name="{{$name}}" autocomplete="off"
            {{ $attributes->merge(['class' => " form-control ". ($errors->has($name) ? ' is-invalid' : '')]) }} placeholder="{{$placeholder}}"{{ $data != null ? $disabled : ''}} {{ $data != null ? $readonly : ''}}>{{old($name) ?? $data[$name] ?? $value ?? ''}}</textarea>
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>