@csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-4">
            <x-input.text label="Name" name="name" :data="$data" required placeholder="Input name permission"/>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="float-right">
        <a href="{{ route('administrator.permission.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>


