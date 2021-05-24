<x-page.form title="Create Tenant">
    <form action="{{route("master.tenant.store")}}" method="POST" class="form-horizontal">
        @include('master.tenant.form', ['data' => null])
    </form>
</x-page.form>