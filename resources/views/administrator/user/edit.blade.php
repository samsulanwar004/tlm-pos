<x-page.form title="Edit User">
    <form action="{{route("administrator.user.update",$data['id'])}}" method="POST" class="form-horizontal">
        @method('PUT')
        @include('administrator.user.form', ['data' => $data])
    </form>
</x-page.form>
