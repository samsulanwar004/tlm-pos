<x-page.form title="Create User">
    <form action="{{route("administrator.user.store")}}" method="POST" class="form-horizontal">
        @include('administrator.user.form', ['data' => null])
    </form>
</x-page.form>