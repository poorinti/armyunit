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
                    <div class="col-md-12 ">
                        <div class="card ">
                            <div class="card-header">ตารางข้อมูลรหัสหน่วย</div>
                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รหัสหน่วย</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col">กองพัน</th>
                                    <th scope="col">เรียงลำดับ</th>

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
                                </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{$departments->links()}}
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
