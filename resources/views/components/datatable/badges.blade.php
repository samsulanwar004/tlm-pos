@if(isset($permissions))
	@foreach($permissions as $permission)
		<span class="badge badge-primary">{{$permission->name}}</span>
	@endforeach
@endif

@if(isset($role))
	<span class="badge badge-primary">{{$role[0]}}</span>
@endif

@if(isset($status) && $status == 'Waiting')
	<span class="badge badge-warning">{{$status}}</span>
@endif

@if(isset($status) && $status == 'Approved')
	<span class="badge badge-success">{{$status}}</span>
@endif

@if(isset($status) && $status == 'Rejected')
	<span class="badge badge-danger">{{$status}}</span>
@endif

@if(isset($status) && $status == 'Pending')
	<span class="badge badge-warning">{{$status}}</span>
@endif

@if(isset($status) && $status == 'Assign')
	<span class="badge badge-primary">{{$status}}</span>
@endif

@if(isset($status) && $status == 'On Process')
	<span class="badge badge-success">{{$status}}</span>
@endif

@if(isset($status) && $status == 'Done')
	<span class="badge badge-success">{{$status}}</span>
@endif