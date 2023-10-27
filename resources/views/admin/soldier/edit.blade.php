<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            หน่วยฝึก {{Auth::user()->name}}
        </h2>
    </x-slot>
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}

    <link rel="stylesheet" href="/css/datepicker/jquery-ui.css">
    <script src="/css/datepicker/jquery-3.6.0.js"></script>
    <script src="/css/datepicker/jquery-ui.js"></script>

    <script>
    $( function() {
      $( ".soldier-date" ).datepicker(
        { dateFormat: 'dd-mm-yy' }
      );
    } );
    </script>


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
                                <div class="card-header">แก้ไขข้อมูลประจำตัว</div>
                                     <div class="card-body">
                                        <form action="{{url('/soldier/update/'.$soldier->soldier_id )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="my-3 form-group">
                                                <!--  ภาพเก่า -->
                                                <br>
                                                <input type="hidden" name="old_image" value="{{$soldier->soldier_image}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="soldier_id" value="{{$soldier->soldier_id}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="page" value="{{$page}}">

                                                <div class="form-group">
                                                </div>
                                                <label for="soldier_image">อัพโหลดภาพโปรไฟล์</label>
                                                <input type="file" class="form-control" name="soldier_image" value="{{$soldier->soldier_image}}">
                                                </div>
                                                @error('service_image')
                                                    <div class="my-2">
                                                        <span class="text-danger">{{$message}}</span>
                                                    </div>
                                                @enderror

                                                <label for="soldier_name">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" name="soldier_name" value="{{$soldier->soldier_name }}" disabled>
                                                @error('soldier_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เลขประชาชน -->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_id">เลขประชาชน</label>
                                                    <input type="text" class="form-control" name="soldier_id"  value =" {{$soldier->soldier_id}}" placeholder="ตัวอย่าง :เลข 13 หลัก" disabled>
                                                </div>
                                                @error('soldier_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                  <!--เลขประจำตัวทหาร -->
                                                  <div class="my-2 form-group">
                                                    <label for="soldier_rtanumber">เลขประจำตัวทหาร</label>
                                                    <input type="text" class="form-control" name="soldier_rtanumber" placeholder="ตัวอย่าง :เลข 10 หลัก" value ="{{isset($soldier->soldier_rtanumber) ? $soldier->soldier_rtanumber : ''}}">
                                                </div>
                                                @error('soldier_rtanumber')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ภูมิลำเนา-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_address">ภูมิลำเนา</label>
                                                    <input type="text" class="form-control" name="soldier_address"placeholder="ตัวอย่าง : 118 หมู่ 7 ต.โพธิ์สัย อ.ศรัสมเด็จ" value ="{{isset($soldier->soldier_address) ? $soldier->soldier_address : ''}}" >
                                                </div>
                                                @error('soldier_address')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--จังหวัด-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_state">จังหวัด</label>
                                                    <input type="text" class="form-control" name="soldier_state"placeholder="ระบุเต็มให้ถูกต้อง ตัวอย่าง :  อุลราชธาณี , ร้อยเอ็ด , มหาสารคาม , นครราชสีมา " value ="{{isset($soldier->soldier_state) ? $soldier->soldier_state: ''}}" >
                                                </div>
                                                @error('soldier_state')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ผลัดที่/ปี -->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_intern">ผลัดที่/ปี</label>
                                                    <input type="text" class="form-control" name="soldier_intern" placeholder="ตัวอย่าง : 1/66 , 2/66" value ="{{isset($soldier->soldier_intern) ? $soldier->soldier_intern : ''}}" >
                                                </div>
                                                @error('soldier_intern')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เหล่า -->
                                                @php
                                                    $unitArr = array();
                                                    $unitArr=['ร.','ม.','ป.','ช','ส.','สพ','สบ.','กส','สห.',]
                                                @endphp
                                                <div class="my-2 form-group">
                                                    <label for="soldier_corp" class="form-label">เหล่า</label>
                                                    <select class="form-select" id="soldier_corp"  name="soldier_corp">
                                                    <option value ="{{isset($soldier->soldier_corp) ? $soldier->soldier_corp : ''}}" >{{isset($soldier->soldier_corp) ? $soldier->soldier_corp : ''}}</option>
                                                        @foreach ( $unitArr as $row )
                                                      <option value="{{ $row}}">{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>

                                                @error('soldier_corp')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                @php
                                                    $unitArr = array();
                                                    $unitArr=['ประถม','ม.ต้น','ม.ปลาย','ปวช','ปวส.','ป.ตรี','ป.โท','ป.เอก',]
                                                @endphp
                                                <!--วุฒิการศึกษา -->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_education" class="form-label">วุฒิการศึกษา</label>
                                                    <select class="form-select" id="soldier_education" name="soldier_education">
                                                        <option value ="{{isset($soldier->soldier_education) ? $soldier->soldier_education : '' }} " >{{isset($soldier->soldier_education) ? $soldier->soldier_education : ''}}</option>
                                                        @foreach ( $unitArr as $row )
                                                      <option value="{{ $row}}">{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('soldier_education')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ความถนัดทางวิชาชีพ-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_skill">ความถนัดทางวิชาชีพ</label>
                                                    <input type="text" class="form-control" name="soldier_skill" placeholder="ตัวอย่าง : คอมพิวเตอร์ , ข่างไฟ , ช่างก่อสร้าง" value ="{{isset($soldier->soldier_skill) ? $soldier->soldier_skill : ''}}" >
                                                </div>
                                                @error('soldier_skill')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--วันที่ เข้าประจำการ-->

                                                <div class="my-2 form-group">
                                                    <label for="soldier_startdate">วันที่ เข้าประจำการ</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control soldier-date"  name="soldier_startdate" value ="{{isset($soldier->soldier_startdate) ? \Carbon\Carbon::parse($soldier->soldier_startdate )->format('d-m-Y'): ''}}" >
                                                    </div>
                                                </div>
                                                @error('soldier_startdate')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--วันที่ ปลดประจำการ-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_enddate">วันที่ ปลดประจำการ</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control soldier-date" name="soldier_enddate" value ="{{isset($soldier->soldier_enddate) ?\Carbon\Carbon::parse($soldier->soldier_enddate )->format('d-m-Y')  : ''}}" >
                                                    </div>
                                                </div>
                                                @error('soldier_enddate')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                <!--เบอร์โทรศัพท์-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_phone">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="soldier_phone" value ="{{isset($soldier->soldier_phone) ? $soldier->soldier_phone : ''}}" >
                                                </div>
                                                @error('soldier_phone')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--หมายเหตุ-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_about">หมายเหตุ</label>
                                                    <input type="text" class="form-control" name="soldier_about" value ="{{isset($soldier->soldier_about) ? $soldier->soldier_about : ''}}" >
                                                </div>
                                                @error('service_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                {{-- <!--หน่วย-->
                                                <div class="my-2 form-group">
                                                    <label for="soldier_dep_id">หน่วย กองร้อย</label>
                                                     <select class="form-control" name="soldier_dep_id" id="soldier_dep_id" required>
                                                     @foreach ( $Department as $key=>$row )
                                                     <option value="{{$row->dep_id}}">{{$row->department_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('soldier_dep_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                <!--กองพัน-->
                                                <div class="my-2 form-group">
                                                    <label for="service_name">หน่วย กองพัน</label>
                                                    <input type="text" class="form-control" name="soldier_name">
                                                </div>
                                                @error('service_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror --}}



                                                <div class="relative max-w-sm">
                                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                      </svg>
                                                    </div>
                                                    <input datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                                  </div>


                                            <br>
                                            <input type="submit" value="อัพเดท" class="text-black btn btn-primary">
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body">
                                <img src="{{isset($soldier->soldier_image) ? asset($soldier->soldier_image) : '/storage/logo1.png'}}" alt="{{ isset($soldier->soldier_image) ? asset($soldier->soldier_image) : '' }}" alt="imageshow" width="200px" height="200px">
                                <label for="imageshow">{{$soldier->soldier_name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
$(document).ready(function() {

});
</script>
