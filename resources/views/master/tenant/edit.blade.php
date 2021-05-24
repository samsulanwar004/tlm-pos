<x-page.form title="Edit Tenant">
    <form action="{{route("master.tenant.update",$data['id'])}}" method="POST" class="form-horizontal">
        @method('PUT')
        @include('master.tenant.form', ['data' => $data])
    </form>
</x-page.form>
