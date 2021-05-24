@props(['name', 'label', 'value' => '', 'data' => null, 'option' => [], 'multi' => false])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <select id="{{$name}}" name="{{$name}}{{$multi ? '[]' : ''}}" class="form-control">
        @foreach($option as $key => $value)
            @php 
                $sel = old($name) ?? $data[$name] ?? '';
                $selected  = $sel == $key ? 'selected' : '';
            @endphp
            <option value="{{$key}}" {{$selected}}>{{$value}}</option>
        @endforeach
    </select>
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>
