@props(['name', 'label', 'value' => '', 'data' => null])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <div class="input-group">
        <input id="{{$name}}" type="text" name="{{$name}}" autocomplete="off" value="{{old($name) ?? $data[$name] ?? $value ?? ''}}"
                {{ $attributes->merge(['class' => " form-control percent". ($errors->has($name) ? ' is-invalid' : '')]) }}>
        <div class="input-group-prepend">
            <span class="input-group-text">%</span>
        </div>
    </div>
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>

@push('scripts')
    <script>
        $(document).on('keyup', '.percent', function() {
            var regex = /^[0-9.]+$/;
            if (regex.test(this.value) !== true)
                this.value = this.value.replace(/[^0-9.]+/, '');
            {
                if($(this).val()!=''){
                    if($(this).val()>100){
                        $(this).val(100);
                    }else{
                        $(this).val( $(this).val());
                    }
                }
            }
        });
    </script>
@endpush
