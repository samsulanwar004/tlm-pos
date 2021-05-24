@props(['name', 'label', 'value' => '', 'data' => null, 'placeholder' => ''])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input id="{{$name}}" type="date" name="{{$name}}" value="{{old($name) ?? $data[$name] ?? $value ?? ''}}"
            {{ $attributes->merge(['class' => " form-control ". ($errors->has($name) ? ' is-invalid' : '')]) }} placeholder="{{$placeholder}}">
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>
