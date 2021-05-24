@props(['name', 'label', 'value' => '', 'data' => null, 'option' => []])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    @foreach($option as $key => $value)
        @php 
            $sel = isset($data[$name]) ? $data[$name] : '';

            $checked  = $sel == $key ? 'checked' : '';

            if (old($name) == $key) {
                $checked = 'checked';
            }
            
        @endphp
        <div class="icheck-primary d-inline">
            <input type="radio" name="{{$name}}" value="{{$key}}" {{$checked}} id="{{$value}}">
            <label for="{{$value}}">
                {{$value}}
            </label>
        </div>
    @endforeach
</div>
