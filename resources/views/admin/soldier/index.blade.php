<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ข้อมูลกำลังพล
        </h2>
</x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <form action="/soldier/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf
                <div class="my-3 row">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search : '' }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/soldier/startadd')}}" class="text-white bg-purple-700 btn btn-primary"> เพิ่มกำลังพล</a>
                    </div>
                </div>
                </form>
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">ตารางข้อมูลกำลังพล</div>
                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อกำลังพล</th>
                                    <th scope="col">เลขบัตรประชาชน</th>
                                    <th scope="col">ผลัด/ปี</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $soldier as $row )
                                  <tr class="text-center ">
                                    <th> {{$soldier->firstItem()+$loop->index}}</th>
                                    <td >
                                        {{-- isset จากฐานข้อมูล ถ้าไม่มีภาพ ให้ดึงเอา โลโก้มา --}}
                                        <img src="{{isset($row->soldier_image) ? asset($row->soldier_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->soldier_image) ? asset($row->soldier_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                    </td>
                                    <td>{{$row->soldier_name}}</td>
                                    <td>{{$row->soldier_id }}</td>
                                    <td>{{$row->soldier_intern}}</td>
                                    <td>{{$row->soldiers_dep_name}}</td>
                                    <td><a href="{{url('/soldier/edit/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td><a href="{{url('/soldier/delete/'.$row->soldier_id)}}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{$soldier->links()}}
                        </div>
                    </div>

                     {{-- <div class="col-md-4 ">
                        <div class="card">
                            <div class="card-header">แบบฟอร์มข้อมูลกำลังพล</div>
                            <div class="card-body">
                                <form action="{{route('addService')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="service_name">ขื่อกำลังพล</label>
                                    <input type="text" class="form-control" name="service_name">
                                    @error('service_name')<!-- ชื่อแท็ก name-->
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror
                                    <br>

                                    <label for="service_image">ภาพประกรอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                    @error('service_image')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror
                                    <br>
                                    <a href="{{url('/service/startup')}}" class="btn btn-danger"> เพิ่มกำลังพล</a>

                                    <input type="submit" value="บันทัก" class="text-black btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

