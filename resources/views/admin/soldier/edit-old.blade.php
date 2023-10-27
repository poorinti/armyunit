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
                                        <form action="{{url('/service/update/'.$service->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label for="service_name">ขื่อหน่วยฝึก</label>
                                            <input type="text" class="form-control" name="service_name" value="{{$service->service_name }}">
                                            @error('service_name')
                                            <div class="my-2">
                                                <span class="text text-red-600">{{$message}}</span>
                                            </div>
                                            @enderror

                                            <div class="form-group my-3">
                                                <label for="service_image">ภาพประกอบ</label>
                                                <input type="file" class="form-control" name="service_image" value="{{$service->service_image}}">
                                            </div>
                                            @error('service_image')
                                                <div class="my-2">
                                                    <span class="text-danger">{{$message}}</span>
                                                </div>
                                            @enderror
                                            <br>
                                                <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                                <div class="form-group">
                                                <img src="{{asset($service->service_image)}}" alt="" width="400px" height="400px">
                                            </div>

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
