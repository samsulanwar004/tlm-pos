@if(isset($editRoute))
    <a href="{{ $editRoute }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-edit"></i> Edit</a>
@endif
@if(isset($deleteRoute))
	<a href="{{ $deleteRoute }}" class="btn btn-danger btn-sm text-white datatable-delete-btn"><i class="fa fa-trash"></i> Delete</a>
@endif
@if(isset($assesmentRoute))
	<a href="{{ $assesmentRoute }}" class="btn btn-success btn-sm text-white"><i class="fas fa-clipboard-check"></i> Assesment</a>
@endif
@if(isset($approveRoute))
	<a href="{{ $approveRoute }}" class="btn btn-success btn-sm text-white"><i class="fas fa-clipboard-check"></i> Approve</a>
@endif
@if(isset($showRoute))
    <a href="{{ $showRoute }}" class="btn btn-success btn-sm text-white"><i class="fa fa-eye"></i> Show</a>
@endif