<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            หน่วยฝึก {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
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
                                        <input type="text" class="form-control" name="department_name" value="{{$department->department_name }} " required>
                                        @error('department_name')
                                          <div class="my-2">
                                            <span class="text-red-600 text">{{$message}}</span>
                                          </div>
                                        @enderror
                                        <label for="dep_index">ลำดับหน่วย</label>
                                        <input type="number" class="form-control" name="dep_index" value="{{$department->dep_index }}">
                                        <br>
                                        <button type="submit" value="อัพเดท" class="text-black btn btn-primary">อัพเดท</button>
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
