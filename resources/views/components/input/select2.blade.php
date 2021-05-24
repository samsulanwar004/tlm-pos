@props([
'name', 'label', 'value', 'helper', 'data', 'option-value', 'option-label',
'remote', // url to the endpoint that has a datatable response
'required' => false,
'placeholder' => "-- ".__('Select')." --"
])

@php
$value = old($name) ?? $data[$name] ?? $value ?? null;
$attributes = $attributes->merge(['class' => " form-control ". ($errors->has($name) ? ' is-invalid' : '')]);
@endphp

<div class="row form-group">
    <label for="{{$name}}" class="col-lg-3 text-lg-right">{{$label}}</label>
    <div class="col-lg-8 col-xl-6">
        <select id="{{$name}}" name="{{$name}}" {{$required ? "required" : ''}} {{ $attributes }}>
        </select>
        @if($errors->has($name))
        <div class="invalid-feedback">
            <i class="fa fa-exclamation-circle fa-fw"></i> {{ $errors->first($name) }}
        </div>
        @elseif(isset($helper))
        <small class="form-text text-muted">{{$helper}}</small>
        @endif
    </div>
</div>

@push('header_script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('footer_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush

@push('script')
<script>
    $(document).ready(function () {
        $("#{{$name}}").select2({
            placeholder: "{{$placeholder}}",
            allowClear: {{$required ? 'false' : 'true'}},
            ajax: {
                cache: true,
                url: "{{$remote}}",
                dataType: "json",
                delay: 300,
                data: function (params) {
                return {
                    search: {
                        value: params.term,
                        regex: false,
                    },
                    start: (params.page || 1) - 1,
                    length: 25,
                    columns: [{
                        name: "{{$optionLabel}}",
                        searchable: true,
                    }],
                };
                },
                processResults: function (response, params) {
                    params.page = params.page || 1;
                    const total = _.get(response, "recordsFiltered", 0);
                    const more = (params.page * 25) < total;
                    const results = _.get(response, "data", []).map((data) => ({
                        id: data["{{$optionValue}}"],
                        text: data["{{$optionLabel}}"],
                    }));

                    return {
                        results: results,
                        pagination: {
                            more:  more,
                        },
                    };
                },
            }
        });

        @if($value)
            $.ajax({
                type: "GET",
                url: "{{$remote}}",
                data: {
                    search: {
                        value: "{{$value}}",
                        regex: false,
                    },
                    start: 0,
                    length: 1,
                    columns: [{
                        name: "{{$optionValue}}",
                        searchable: true,
                    }],
                },
                success: function (response) {
                    const options = _.get(response, "data", []).map((data) => {
                        return new Option(data["{{$optionLabel}}"], data["{{$optionValue}}"], true, true);
                    });

                    for (let index = 0; index < options.length; index++) {
                        $("#{{$name}}").append(options[index]).trigger('change');
                    }
                }
            });
        @endif
    });
</script>
@endpush
