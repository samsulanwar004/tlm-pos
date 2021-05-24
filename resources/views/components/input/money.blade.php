@props(['name', 'label', 'value' => '', 'data' => null])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Rp</span>
        </div>
        <input id="{{$name}}" type="text" name="{{$name}}" autocomplete="off" value="{{number_format(str_replace(',', '', old($name) ?? $data[$name] ?? $value ?? ''))}}"
            {{ $attributes->merge(['class' => " form-control money". ($errors->has($name) ? ' is-invalid' : '')]) }}>
    </div>
    @if($errors->has($name))
    <span style="color:red">{{ $errors->first($name) }}</span>
    @endif
</div>

@push('footer_scripts')
    <script>
        $(document).on('keyup', '.money', function() {
            var regex = /^[0-9.]+$/;
            if (regex.test(this.value) !== true)
                this.value = this.value.replace(/[^0-9,]+/, '');
            {
                if($(this).val()!=''){
                    $(this).val( $(this).val());
                }
            }
            this.value = this.value.replace(/,/g,"");
            this.value = this.value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    </script>
@endpush
