<x-page.form title="Edit Role">
    <form action="{{route("administrator.role.update", $data->id)}}" method="POST" class="form-horizontal">
        @method('PUT')
        @include('administrator.role.form', ['data' => $data])
    </form>
</x-page.form>
