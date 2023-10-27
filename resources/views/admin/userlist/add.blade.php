<x-app-layout>
    <x-slot name="header" >
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            จัดการหน่วย
            <b class="float-end"> ผู้ใช้ : <span class="text-black">{{Auth::user()->name}}</span></b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                    <div class="col-md-8 ">
                        <div class="card ">
                            <div class="card-header">ตารางกองพัน</div>
                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col">User</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if ($userdep)

                                    @php $i=0; @endphp
                                    @foreach ( $userdep as $row )
                                  <tr class="text-center">
                                    <th scope="row">{{$i=$i+1;}}</th>
                                    <td>{{$row->dep_id}}</td>
                                    <td></td>
                                    <td><a href="{{url('/userlist/edit/'.$row->user_id.'?dep_id='.$row->dep_id)}}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td><a href="{{url('/userlist/delete/'.$row->user_id.'?dep_id='.$row->dep_id)}}" class="btn btn-warning"> ลบ</a></td>
                                  </tr>
                                    @endforeach
                                  @endif
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="card">
                            <div class="card-header bg-purple-500 "><b>แบบฟอร์ม</b></div>
                            <div class="card-body">
                                <form action="{{route('userlist.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user_id}}">
                                    <div class="my-2">
                                    <div class="form-group my-2">
                                        <label for="dep_id">หน่วย กองร้อย</label>
                                         <select class="form-control" name="dep_id" id="dep_id" required>
                                         @foreach ( $Department as $key=>$row )
                                         <option value="{{$row->dep_id}}">{{$row->department_name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    @error('dep_id')
                                    <div class="my-2">
                                        <span class="text text-red-600">{{$message}}</span>
                                    </div>
                                    @enderror
                                     </div>
                                    <br>
                                    <input type="submit" value="บันทึก" class="btn btn-primary text-black">
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
