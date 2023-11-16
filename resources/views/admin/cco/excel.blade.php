<x-app-layout>
    <x-slot name="header3">
        <h2 class="text-xl font-semibold leading-tight text-white">
            เพิ่มข้อมูลนายทหาร ด้วย excel
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
                    @if (session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                     @endif
                    <div class="col-md-12">
                        <div class=" card">
                            <div class="card">
                                <div class="card-header">Import ข้อมูลนายยทหาร</div>
                                     <div class="card-body">
                                        <form action="{{ url('/cco/excel/import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="flex-row-reverse d-flex justify-content-end ">


                                            </div>
                                                <div class="my-3 form-group">
                                                    <!--รูปภาพ -->
                                                    <div class="form-group">
                                                    </div>
                                                    <label for="soldier_image">อัพโหลด excel </label>
                                                    <input type="file" class="form-control"  name="excel_import" required >
                                                </div>
                                                    @error('success')
                                                        <div class="my-2">
                                                            <span class="text-danger">{{session('success')}}</span>
                                                        </div>
                                                    @enderror

                                                <!--  ภาพเก่า -->
                                                <br>
                                                {{-- <input type="hidden" name="old_image" value=""> --}}
                                                <!--ชื่อสกุล -->
                                                {{-- <input type="hidden" name="soldier_id" value=""> --}}

                                         <br>
                                         <a href="/cco/all" class="btn btn-danger "><i class="fa fa-arrow-left"></i> กลับ</a>
                                         <button type="submit" class="mx-auto text-black btn btn-primary ">เพิ่มข้อมูล</button>

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


