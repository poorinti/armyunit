<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            หน่วยฝึก {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="col-md-8">
                        <div class=" card">
                            <div class="card">
                                <div class="card-header">แก้ไขรายชื่อหน่วยฝึก</div>
                                <div class="card-body">
                                    <form action="{{url('/department/update/'.$department->dep_id)}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="page" id="page" value="{{ isset($page) ? $page :'' }}">
                                        <label for="battalion_id">เลือกกองพัน</label>
                                        <!-- <input type="hidden" class="form-control" name="department_id"> -->
                                        <!-- เลือกกองพัน -->
                                        <!-- php จะอ้างอิงจากชื่อ name เท่านั้น-->

                                        <select class=" form-control form-select" aria-label="battalion_id" name="battalion_id" disabled>

                                            <option selected>คลิกเพื่อเลือก</option>
                                            @foreach ( $battalion as $row )
                                            <option value="{{$row->battalion_id}}" {{ $row->battalion_id== $department->battalion_id ? 'selected' :''}} >{{$row->battalion_name}}</option>
                                            @endforeach

                                         </select>

                                        <label for="department_name">ขื่อหน่วยฝึก</label>
                                        <input type="text" class="form-control" name="department_name" value="{{$department->department_name }}">
                                        @error('department_name')
                                          <div class="my-2">
                                            <span class="text text-red-600">{{$message}}</span>
                                          </div>
                                        @enderror
                                        <br>
                                        <input type="submit" value="อัพเดท" class="btn btn-primary text-black">
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
