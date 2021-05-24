@props(['name', 'label', 'value' => '', 'data' => null, 'placeholder' => '', 'disabled' => '', 'readonly' => ''])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input id="{{$name}}" type="text" name="{{$name}}" autocomplete="off" value="{{old($name) ?? $data[$name] ?? $value ?? ''}}"
            {{ $attributes->merge(['class' => " form-control ". ($errors->has($name) ? ' is-invalid' : '')]) }} placeholder="{{$placeholder}}"{{ $data != null ? $disabled : ''}} {{ $data != null ? $readonly : ''}}>
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>
