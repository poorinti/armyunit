@if(session('success'))
    <strong>{{session('success')}}</strong>
@endif

<form method="post" action="{{ url('/soldier/excel/import') }}" enctype="multipart/form-data" >
    <p>
        <input type="file" name="excel_import" required />
         <!--หน่วย-->
         <div class="form-group my-2">
            <label for="soldier_dep_id">หน่วย กองร้อย</label>
             <select class="form-control" name="soldier_dep_id" id="soldier_dep_id" required>
             @foreach ( $Department as $key=>$row )
             <option value="{{$row->dep_id}}">{{$row->department_name}}</option>
            @endforeach
            </select>
        </div>
    </p>
    <input type="submit" name="submit" value="Import Users">
    <p>
        <a href="{{ url('/soldier/excel/export') }}">Export Users</a>
    </p>
    @csrf

</form>
