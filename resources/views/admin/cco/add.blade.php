<x-app-layout>
    <x-slot name="header3">
        <h2 class="text-xl font-semibold leading-tight text-white">
            เพิ่มข้อมูล นายทหาร
        </h2>
    </x-slot>
    <script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="form-validation.js"></script>

    <div class="py-12">
        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="col-md-12">
                        <div class=" card">
                            <div class="card">
                                <div class="bg-red-200 card-header">บันทึกข้อมูลประจำตัว นายทหาร</div>
                                     <div class="card-body">
                                        <form action="{{route('addCco')}}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="flex-row-reverse d-flex justify-content-end ">


                                            </div>
                                                <div class="my-3 form-group">
                                                    <!--รูปภาพ -->
                                                    <div class="form-group">
                                                    </div>
                                                    <label for="cco_image">อัพโหลดภาพโปรไฟล์</label>
                                                    <input type="file" class="form-control" name="cco_image" >
                                                </div>
                                                    @error('cco_image')
                                                        <div class="my-2">
                                                            <span class="text-danger">{{$message}}</span>
                                                        </div>
                                                    @enderror

                                                <!--  ภาพเก่า -->
                                                <br>
                                                {{-- <input type="hidden" name="old_image" value=""> --}}
                                                <!--ชื่อสกุล -->
                                                {{-- <input type="hidden" name="soldier_id" value=""> --}}
                                                <!--หน่วย-->
                                                <div class="my-2 form-group">
                                                    <label for="cco_rank">ยศ/คำนำหน้า</label>
                                                     <select class="form-control" name="cco_rank" id="cco_rank" required>
                                                     @foreach ( $rankcco as $key=>$row )
                                                     <option value="{{$row->nco_rank_index}}">{{$row->rank_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('cco_rank')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <label for="cco_name">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" name="cco_name" value="" required>
                                                @error('cco_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เลขประชาชน -->
                                                <div class="my-2 form-group">
                                                    <label for="cco_id">เลขประจำตัวทหาร</label>
                                                    <input type="text" class="form-control" name="cco_id" placeholder="ตัวอย่าง :เลข 13 หลัก" required>
                                                </div>
                                                @error('cco_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                 <!--หน่วย-->
                                                 <div class="my-2 form-group">
                                                    <label for="cco_dep_id">หน่วย กองร้อย</label>
                                                     <select class="form-control" name="cco_dep_id" id="cco_dep_id" required>
                                                     @foreach ( $Department as $key=>$row )
                                                     <option value="{{$row->dep_id}}">{{$row->department_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('cco_dep_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                         <br>
                                         <a href="/cco/all" class="btn-info btn-yellow-warnnig "><i class="fa fa-arrow-left"></i> กลับ</a>
                                         <button type="submit" class="mx-auto text-black btn btn-primary ">บันทึกข้อมูล</button>

                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body">
                                <img src="" alt="imageshow" width="200px" height="200px">
                                <label for="imageshow"></label>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


