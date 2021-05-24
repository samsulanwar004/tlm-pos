<x-page.form title="Edit Permission">
    <form action="{{route("administrator.permission.update", $data->id)}}" method="POST" class="form-horizontal">
        @method('PUT')
        @include('administrator.permission.form', ['data' => $data])
    </form>
</x-page.form>
