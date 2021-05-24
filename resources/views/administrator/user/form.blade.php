@csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-4">
            @if($data)
                @if(Auth::user()->hasAnyRole(['super-admin']))
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" name="role">
                        @foreach($roles as $role)
                            <option value="{{$role->name}}" {{$role->name == $data->role_name ? 'selected' : ''}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <input type="hidden" name="role" value="admin">
                @endif
            @else

                @if(Auth::user()->hasAnyRole(['super-admin']))
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" name="role">
                        @foreach($roles as $role)
                            <option {{ old('role') == $role->name ? 'selected' : '' }} {{ 'admin' == $role->name ? 'selected' : '' }} value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                @else 
                    <input type="hidden" name="role" value="admin">
                @endif
            @endif
            <x-input.text label="Name" name="name" :data="$data" placeholder="Input name"/>
            <x-input.text label="Username" name="username" :data="$data" placeholder="Input username"/>
            <x-input.password label="Password" name="password" placeholder="Input password"/>
        </div>
        <div class="col-sm-4">
            <x-input.select label="Company" name="companyid" :data="$data" :option="$company"/>
            <x-input.select label="Site" name="siteid" :data="$data"/>
            <x-input.select label="Position" name="jabatanid" :data="$data"/>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="float-right">
        <a href="{{ route('administrator.user.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

@section('footer_scripts')
<script type="text/javascript">
    $(function () {
        let selectCompany = $('#companyid');
        let selectSite = $('#siteid');
        let selectJabatan = $('#jabatanid');

        let companyid = '{{ old('companyid') ?? $data['companyid'] ?? ''}}';
        let siteid = '{{ old('siteid') ?? $data['siteid'] ?? ''}}';
        let jabatanid = '{{ old('jabatanid') ?? $data['jabatanid'] ?? ''}}';
        let user = @json($user);

        selectCompany.select2({
            theme: 'bootstrap4',
            placeholder: 'Select Company'
        });

        selectSite.select2({
            theme: 'bootstrap4',
            placeholder: 'Select Site'
        });

        selectJabatan.select2({
            theme: 'bootstrap4',
            placeholder: 'Select Position'
        });

        selectCompany.val(companyid).trigger('change');

        selectCompany.on('select2:select', function (e) {
            let companyid = e.params.data.id;
            site(companyid);
            position(companyid);
        });

        if (companyid != '') {
            site(companyid);
            position(companyid);
        }

        function site(companyid) {
            
            $.ajax({
              type:"GET",
              dataType: "json",
              beforeSend : function() {
              },
              url: '{{url('api/ref/site/company')}}'+'/'+companyid+'?siteid='+user.siteid,
              success:function(res){
                selectSite.empty().select2({
                    theme: 'bootstrap4',
                    placeholder: 'Select Site',
                    data: $.map(res.data, function (o) {
                        o.id = o.siteid;
                        o.text = o.sitename;
                        return o;
                    }),
                });
                selectSite.val(siteid).trigger('change');
              },
              error:function(){

              }
            });
        }

        function position(companyid) {
            
            $.ajax({
              type:"GET",
              dataType: "json",
              beforeSend : function() {
              },
              url: '{{url('api/ref/position/company')}}'+'/'+companyid,
              success:function(res){
                selectJabatan.empty().select2({
                    theme: 'bootstrap4',
                    placeholder: 'Select Position',
                    data: $.map(res.data, function (o) {
                        o.id = o.jabatanid;
                        o.text = o.jabatan;
                        return o;
                    }),
                });
                selectJabatan.val(jabatanid).trigger('change');
              },
              error:function(){

              }
            });
        }
    });
</script>
@endsection
