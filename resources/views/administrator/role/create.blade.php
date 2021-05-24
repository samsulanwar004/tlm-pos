<x-page.form title="Create Role">
    <form action="{{route("administrator.role.store")}}" method="POST" class="form-horizontal">
        @include('administrator.role.form', ['data' => null])
    </form>
</x-page.form>
