<x-page.form title="Create Permission">
    <form action="{{route("administrator.permission.store")}}" method="POST" class="form-horizontal">
        @include('administrator.permission.form', ['data' => null])
    </form>
</x-page.form>
