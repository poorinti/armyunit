<x-app-layout>
    <x-slot name="header" >
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            จัดการหน่วยหลัก
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
                            <div class="card-header">ตารางหน่วยหลัก</div>
                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รหัส</th>
                                    <th scope="col">หน่วยหลัก</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>

                                    @foreach ( $battalion as $row )
                                  <tr class="text-center">
                                    <th scope="row">{{$battalion->firstItem()+$loop->index}}</th>
                                    <td>{{$row->battalion_id}}</td>
                                    <td>{{$row->battalion_name}}</td>
                                    <td><a href="{{url('/battalion/edit/'.$row->battalion_id)}}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td><a href="{{url('/battalion/delete/'.$row->battalion_id)}}" class="btn btn-warning"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{$battalion->links()}}
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="card">
                            <div class="card-header bg-purple-500 "><b>แบบฟอร์ม</b></div>
                            <div class="card-body">
                                <form action="{{route('addBattalion')}}" method="POST">
                                    @csrf
                                    <label for="battalion_id">รหัสหน่วยหลัก</label>
                                    <input type="text" class="form-control" name="battalion_id" required>
                                    @error('battalion_id')
                                      <div class="my-2">
                                        <span class="text text-red-600">{{$message}}</span>
                                      </div>
                                    @enderror
                                    <div class="my-2">
                                    <label for="battalion_name">ขื่อหน่วยหลัก</label>
                                    <input type="text" class="form-control" name="battalion_name" required>
                                    @error('battalion_name')
                                      <div class="my-2">
                                        <span class="text text-red-600">{{$message}}</span>
                                      </div>
                                    @enderror
                                     </div>
                                    <br>
                                    <button type="submit"  class="btn btn-primary text-black">บันทึก</button>
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
