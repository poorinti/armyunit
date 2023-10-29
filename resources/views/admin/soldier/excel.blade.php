@if(session('success'))
    <strong>{{session('success')}}</strong>
@endif

<form method="post" action="{{ url('/soldier/excel/import') }}" enctype="multipart/form-data">
    <p>
        <input type="file" name="users" required />
    </p>
    <input type="submit" name="submit" value="Import Users">
    <p>
        <a href="{{ url('/soldier/excel/export') }}">Export Users</a>
    </p>
    @csrf
</form>
