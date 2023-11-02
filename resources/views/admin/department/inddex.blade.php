<x-app-layout>
    <x-slot name="header" >
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            จัดการหน่วย
            <b class="float-end"> ผู้ใช้ : <span class="text-black">{{Auth::user()->name}}</span></b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                    <div class="col-md-8 ">
                        <div class="card ">
                            <div class="card-header">ตารางข้อมูลหน่วยฝึก</div>
                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รหัสหน่วย</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col">กองพัน</th>
                                    <th scope="col">เรียงลำดับ</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $batArr=Array();
                                        // ตำแหน่งที่ 0 ใน อาเรย์ ไปใส่ใน val
                                        foreach ($battalion as $key => $val) {
                                            $batArr[$val->battalion_id]= $val->battalion_name;
                                                            // / "D1"       ="njv"
                                            // $batArr=Array("D1"=>"=njv","D2"=>"ASSA");
                                        }
                                    @endphp
                                    @foreach ( $departments as $row )
                                  <tr class="text-center">
                                    <th scope="row">{{$departments->firstItem()+$loop->index}}</th>

                                    <td>{{$row->dep_id}}</td>
                                    <td>{{$row->department_name}}</td>
                                    <td>{{$batArr[$row->battalion_id]}}</td>
                                    <td>{{$row->dep_index}}</td>
                                    <td><a href="{{url('/department/edit/'.$row->dep_id)}}{{ "?page=".Request::get('page') }}" class="btn btn-danger" > แก้ไข</a></td>
                                    <td><a href="{{url('/department/softdelete/'.$row->dep_id)}}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{$departments->links()}}
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="card">
                            <div class="bg-purple-500 card-header "><b>แบบฟอร์ม</b></div>
                            <div class="card-body">
                                <form action="{{route('addDepartment')}}" method="POST">
                                    @csrf
                                    <label for="battalion_id">เลือกกองพัน</label>
                                    <!-- <input type="hidden" class="form-control" name="department_id"> -->
                                    <!-- เลือกกองพัน -->
                                    <!-- php จะอ้างอิงจากชื่อ name เท่านั้น-->
                                    <select class=" form-control form-select" aria-label="battalion_id" name="battalion_id" required>

                                        <option value="">คลิกเพื่อเลือก</option>
                                        @foreach ( $battalion as $row )
                                        <option value="{{$row->battalion_id}}">{{$row->battalion_name}}</option>
                                        @endforeach

                                     </select>

                                    @error('department_id')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    </div>
                                    @enderror
                                    <label for="dep_id">รหัสหน่วยฝึก</label>
                                    <input type="text" class="form-control" name="dep_id"  id="dep_id" required>
                                    @error('dep_id')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror

                                    <label for="department_name">ขื่อหน่วยฝึก</label>
                                    <input type="text" class="form-control" name="department_name" id="department_name"required>
                                    @error('department_name')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror

                                    <br>
                                    <button type="submit" value="บันทึก" class="text-black btn btn-primary">บันทึก</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (count($trashDepartment)>0)
                    <div class="my-4 col-md-8">
                        <div class="card ">
                            <div class="card-header">ถังขยะ
                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col">User</th>
                                    <th scope="col">กู้คืนข้อมูล</th>
                                    <th scope="col">ลบถาวร</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $trashDepartment  as $row )
                                  <tr class="text-center">
                                    <th scope="row">{{$departments->firstItem()+$loop->index}}</th>
                                    <td>{{ $row->dep_id}}</td>
                                    <td>{{$row->department_name}}</td>
                                    <td><a href="{{url('/department/restore/'.$row->dep_id)}}" class="btn btn-danger"> กู้ข้อมูล</a></td>
                                    <td><a href="{{url('/department/delete/'.$row->dep_id)}}" class="btn btn-warning"> ลบถาวร</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{$trashDepartment->links()}}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
