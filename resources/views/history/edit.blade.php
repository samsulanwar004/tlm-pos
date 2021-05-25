<x-page.form title="Detail History">
    <form action="{{route("history.update",$data['id'])}}" method="POST" class="form-horizontal">
        @method('PUT')
        @include('history.form', ['data' => $data])
    </form>
</x-page.form>
