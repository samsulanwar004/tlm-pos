@csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-4">
            <x-input.text label="Name" name="name" :data="$data" readonly="readonly" required placeholder="Input name role"/>
            @if(!$data)
            <div class="form-group">
              <label for="input-normal">Permissions</label>
              <select class="form-control select2-permission" name="permission[]" multiple="multiple" data-placeholder="Select Permission" required>
                @foreach($permissions as $permission)
                  <option value="{{$permission->name}}">{{$permission->name}}</option>
                @endforeach
              </select>
            </div>
            @else
            <div class="form-group">
              <label for="input-normal">Permissions</label>
              <select class="form-control select2-permission" name="permission[]" multiple="multiple" data-placeholder="Select Permission" required>
                @foreach($permissions as $permission)
                  <option {{collect($selectedPermission)->has($permission->name) ? 'selected' : ''}} value="{{$permission->name}}">{{$permission->name}}</option>
                @endforeach
              </select>
              @foreach($selectedPermission as $selected)
                <input type="hidden" name="old_selected[]" value="{{$selected}}">
              @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="float-right">
        <a href="{{ route('administrator.role.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

@section('footer_scripts')
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2-permission').select2({
      theme: 'bootstrap4'
    });
  });
</script>
@endsection


    