@props(['name', 'label', 'value' => '', 'data' => null, 'placeholder' => '', 'disabled' => ''])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input id="{{$name}}" type="number" name="{{$name}}" autocomplete="off" value="{{old($name) ?? $data[$name] ?? $value ?? ''}}"
            {{ $attributes->merge(['class' => " form-control ". ($errors->has($name) ? ' is-invalid' : '')]) }} placeholder="{{$placeholder}}" {{ $data != null ? $disabled : ''}}>
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>
