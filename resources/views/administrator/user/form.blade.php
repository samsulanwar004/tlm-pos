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
    </div>
</div>
<div class="card-footer">
    <div class="float-right">
        <a href="{{ route('administrator.user.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>
