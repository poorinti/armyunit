<x-app-layout>
    <x-slot name="header" >
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            เพิ่มข้อมูลสรุป
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
                    {{-- {{dd($ansShow);}} --}}
                    <div class="col-md-8 ">

                                <form action="/ans/all"  name="frmsearch" id="frmsearch" method="post">
                                    @csrf
                                    @php
                                    $dataArr= array();
                                    $dataArr=['ข้อมูลพลทหาร','ข้อมูลนายสิบ','ข้อมูลนายทหาร','ข้อมูลม.35','ข้อมูลผู้รับสิทธิ์']
                                @endphp
                                {{-- {{dd($ans_dep_id );}} --}}
                                 <div class="my-1 input-group">
                                    <button class="mx-1 btn btn-success" style="font-weight: 800;" >เลือกประเภท</button>
                                <!-- <input type="hidden" class="form-control" name="department_id"> -->
                                <!-- เลือกกองพัน -->
                                <!-- php จะอ้างอิงจากชื่อ name เท่านั้น-->
                                <select class=" form-control form-select" aria-label="ans_name" name="ans_name" >

                                    <option value="">คลิกเพื่อเลือก</option>
                                    @foreach (  $dataArr as $row )
                                    <option value="{{$row}}"{{ $row == $ans_name ? 'selected' : ''}}>{{$row}}</option>
                                    @endforeach

                                </select>

                                <button class="mx-1 btn btn-success" style="font-weight: 800;" >เลือกดูหน่วย</button>
                                <!-- <input type="hidden" class="form-control" name="department_id"> -->
                                <!-- เลือกกองพัน -->
                                <!-- php จะอ้างอิงจากชื่อ name เท่านั้น-->
                                <select class=" form-control form-select" aria-label="ans_dep_id" name="ans_dep_id" >

                                    <option value="">คลิกเพื่อเลือก</option>
                                    @foreach ( $departments as $key=>$row )

                                    <option value="{{$row->dep_id}}"{{ $row->dep_id == $ans_dep_id ? 'selected' : ''}}>{{$row->department_name}}</option>
                                    @endforeach

                                 </select>
                                 <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                                </div>
                                    </form>
                        <div class="card ">
                            <div class="card-header">ตารางข้อมูลหน่วยฝึก</div>
                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รหัสหน่วย</th>
                                    <th scope="col">ชื่อหน่วย</th>
                                    <th scope="col">ภาพ</th>
                                    <th scope="col">ประเภท</th>
                                    <th scope="col">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $batArr=Array();
                                        // ตำแหน่งที่ 0 ใน อาเรย์ ไปใส่ใน val
                                        foreach ($battalion as $key => $val) {
                                            $batArr[$val->battalion_id]= $val->battalion_name;
                                                            // / "D1"       ="njv"
                                            // $batArr=Array("D1"=>"=njv","D2"=>"ASSA");
                                        }
                                    @endphp --}}

                                    @foreach ( $ansShow as $row )
                                  <tr class="text-center">
                                    <th scope="row">{{$row->ans_index}}</th>
                                    <td>{{$row->ans_id}}</td>
                                    <td>{{$row->ans_dep_name}}</td>
                                    <td>
                                        <img src="{{isset($row->ans_image) ? asset($row->ans_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->ans_image) ? asset($row->ans_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                    </td>
                                    <td>{{$row->ans_name}}</td>
                                    <td><a href="{{url('/ans/delete/'.$row->ans_id)}}{{isset($ans_name) ? '?ans_image='.$ans_name : '' }}{{isset($ans_dep_id) ? '&ans_dep_id='.$ans_dep_id : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{$ansShow->links()}}
                        </div>
                    </div>
                    {{-- @php
                         $ans_name_chk= isset($ans_name) ? $ans_name  : '';
                    @endphp --}}

                    <div class="col-md-4 ">
                        <div class="card">
                            <div class="bg-purple-500 card-header "><b>แบบฟอร์ม</b></div>
                            <div class="card-body">
                                <form action="{{route('addans')}}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                    @php
                                        $dataArr= array();
                                        $dataArr=['ข้อมูลพลทหาร','ข้อมูลนายสิบ','ข้อมูลนายทหาร','ข้อมูลม.35','ข้อมูลผู้รับสิทธิ์']
                                    @endphp
                                    <label for="ans_name">เลือกประเภท</label>
                                    <!-- <input type="hidden" class="form-control" name="department_id"> -->
                                    <!-- เลือกกองพัน -->
                                    <!-- php จะอ้างอิงจากชื่อ name เท่านั้น-->

                                    <select class=" form-control form-select" aria-label="ans_name" name="ans_name" required>

                                        <option value="">คลิกเพื่อเลือก</option>
                                        @foreach (  $dataArr as $row )
                                        <option value="{{$row}}" {{$row == $ans_name? 'selected' : ''}}>{{$row}}</option>
                                        @endforeach

                                     </select>
                                    <label for="ans_dep_id">เลือกหน่วย</label>
                                    <!-- <input type="hidden" class="form-control" name="department_id"> -->
                                    <!-- เลือกกองพัน -->
                                    <!-- php จะอ้างอิงจากชื่อ name เท่านั้น-->
                                    <select class=" form-control form-select" aria-label="ans_dep_id" name="ans_dep_id" required>

                                        <option value="">คลิกเพื่อเลือก</option>
                                        @foreach ( $departments as $row )
                                        <option value="{{$row->dep_id}}"{{ $row->dep_id == $ans_dep_id ? 'selected' : ''}}>{{$row->department_name}}</option>
                                        @endforeach

                                     </select>

                                    @error('ans_dep_id')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    </div>
                                    @enderror
                                    @php
                                        $iArr= array();
                                        $iArr=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
                                    @endphp
                                    <label for="ans_index">เรียงลำดับ</label>
                                    <select class=" form-control form-select" aria-label="ans_index" name="ans_index" required>

                                        <option value="">คลิกเพื่อเลือก</option>
                                        @foreach ( $iArr as $row )
                                        <option value="{{$row}}">{{$row}}</option>
                                        @endforeach

                                     </select>
                                    @error('ans_id')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror
                                    <div class="my-3 form-group">
                                        <!--รูปภาพ -->
                                        <div class="form-group">
                                        </div>
                                        <label for="ans_image">อัพโหลดภาพ</label>
                                        <input type="file" class="form-control" name="ans_image" >
                                    </div>
                                        @error('ans_image')
                                            <div class="my-2">
                                                <span class="text-danger">{{$message}}</span>
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
                                    <td><a href="{{url('/department/restore/'.$row->dep_id)}}{{isset($soldier_wantto) ? '?soldier_wantto='.$soldier_wantto : '' }}" class="btn btn-danger"> กู้ข้อมูล</a></td>
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
