@csrf
<div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <x-input.text label="Name" name="name" :data="$data" placeholder="Input tenant name"/>
            <x-input.text label="Username" name="username" :data="$data" placeholder="Input username"/>
            <x-input.password label="Password" name="password" placeholder="Input password"/>
            <x-input.select label="Status" name="status" :data="$data" :option="$status"/>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="float-right">
        <a href="{{ route('master.tenant.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>


