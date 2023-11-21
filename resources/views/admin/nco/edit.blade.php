<x-app-layout>
    <x-slot name="header2">
        <h2 class="text-xl font-semibold leading-tight text-white">
            ข้อมูลนายสิบ
        </h2>
    </x-slot>
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}
    <script src="/js/jquery-1.4.4.min.js"></script>
    <link rel="stylesheet" href="/css/datepicker/jquery-ui.css">

    <script src="/css/datepicker/jquery-3.6.0.js"></script>
    <script src="/css/datepicker/jquery-ui.js"></script>

    <link rel="stylesheet" href="https://www.codopa.com/web/DatePicker/css/ui-lightness/jquery-ui-1.8.10.custom.css">
    <style>
        .ui-datepicker-month {
            color: #000000;
        }
        .ui-datepicker-year{
            color: #000000;
        }
    </style>
    <script type="text/javascript">
        $(function () {
          var d = new Date();
          var toDay = d.getDate() + '/'
      + (d.getMonth() + 1) + '/'
      + (d.getFullYear() + 543);

              // Datepicker
            $(".soldier-date" ).datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
            dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
            monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
            monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
            $("#datepicker-en").datepicker({ dateFormat: 'dd/mm/yy'});
            $("#inline").datepicker({ dateFormat: 'dd/mm/yy', inline: true });
          });
      </script>
    {{-- <script>

    $( function() {
      $( ".soldier-date" ).datepicker(
        { dateFormat: 'dd-mm-yy' }
      );
    } );
    </script> --}}
 @php   $url='/nco/all?';
 $url .=isset($page)? 'page='.$page :'';
 $url .=isset($search) ? '&search='.$search : '' ;
 $url .=isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' ;
 @endphp

    <div class="py-12">

        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="col-md-4">
                        <div class="card">
                            <a href="{{ '/nco/all?page='.request()->page.'&search='.request()->search.'&nco_dep_id='.request()->nco_dep_id.'&nco_provinces='.request()->nco_provinces.'&nco_education='.request()->nco_education.'&nco_disease='.request()->nco_disease  }}{{isset($nco_rank) ? '&nco_rank='.$nco_rank : '' }}" class="text-black bg-purple-700 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>
                            <div class="bg-slate-200 card-header ">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body ">
                                <img src="{{isset($nco->nco_image) ? asset($nco->nco_image) : '/image/logo/logo1.png'}}" alt="{{ isset($nco->nco_image) ? asset($nco->nco_image) : '' }}" alt="imageshow" width="200px" height="200px">
                                {{-- <label for="imageshow">{{$soldier->soldier_name }}</label> --}}
                            </div>

                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class=" card">
                            <div class="card">
                                <div class="bg-slate-200 card-header">แก้ไขข้อมูลประจำตัว</div>
                                     <div class="card-body">
                                        <form action="{{url('/nco/update/'.$nco->nco_id )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="my-3 form-group">
                                                <!--  ภาพเก่า -->
                                                <br>
                                                <input type="hidden" name="old_image" value="{{$nco->nco_image}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="nco_id" value="{{$nco->nco_id}}">

                                                <!-- เพจ -->
                                                <input type="hidden" name="page" value="{{$page}}">

                                                {{-- <input type="hidden" name="nco_dep_id" value="{{$nco_dep_id}}"> --}}
                                                {{-- <input type="hidden" name="search" value="{{$search}}"> --}}
                                                <input type="hidden" name="nco_provinces" value="{{isset($nco_provinces) ? $nco_provinces :'' }}">


                                                <div class="form-group">
                                                </div>
                                                <label for="nco_image">อัพโหลดภาพโปรไฟล์</label>
                                                <input type="file" class="form-control" name="nco_image" value="{{$nco->nco_image}}">
                                                </div>
                                                @error('nco_image')
                                                        <div class="my-2">
                                                            <span class="text-danger">{{$message}}</span>
                                                        </div>
                                                    @enderror
                                                 <!--ยศ -->
                                                 <div class="my-2 form-group">
                                                    <label for="nco_rank">ยศ/คำนำหน้า</label>
                                                     <select class="form-control" name="nco_rank" id="nco_rank" required>
                                                     @foreach ( $rank as $key=>$row )
                                                     <option value="{{$row->rank_name}}"{{ $row->rank_name==$nco->nco_rank ? 'selected' : ''}}>{{$row->rank_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('nco_rank')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ชื่อ -->
                                                <label for="nco_name">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" name="nco_name" value="{{$nco->nco_name}}" >
                                                @error('nco_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เลขประจำตัวทหาร  -->
                                                <div class="my-2 form-group">
                                                    <label for="nco_id">เลขประจำตัวทหาร </label>
                                                    <input type="text" class="form-control" name="nco_id"  value =" {{$nco->nco_id}}" placeholder="ตัวอย่าง :เลข 13 หลัก" disabled>
                                                </div>
                                                @error('nco_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ภูมิลำเนา-->
                                                <div class="my-2 form-group">
                                                    <label for="nco_address">ภูมิลำเนา</label>
                                                    <input type="text" class="form-control" name="nco_address"placeholder="ตัวอย่าง : 118 หมู่ 7 ต.โพธิ์สัย" value ="{{isset($nco->nco_address) ? $nco->nco_address : ''}}" >
                                                </div>
                                                @error('nco_address')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <div class="my-2 form-group">
                                                    <label for="nco_province">จังหวัด</label>
                                                    <select id="nco_province" name="nco_province" class="form-select"  >
                                                        <option value="">กรุณาเลือกจังหวัด</option>
                                                        @foreach($provinces as $item)
                                                        <option value="{{ $item->province }}" {{ $item->province==$nco->nco_province ? 'selected' : ''}}>{{ $item->province }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="my-2 form-group">
                                                    <label for="nco_amphoe">เขต/อำเภอ</label>
                                                    <select id="nco_amphoe"  name="nco_amphoe"  class="form-select" >
                                                        <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                                        @foreach($amphoes as $item)
                                                        <option value="{{ $item->amphoe }}" {{ $item->amphoe==$nco->nco_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                                                        @endforeach
                                                        </select>
                                                </div>

                                                <!--เหล่า -->
                                                @php
                                                    $unitArr = array();
                                                    $unitArr=['ร.','ม.','ป.','ช.','ส.','ขส.','สพ.','พธ.','สห.','สบ.','กง.','สบ.','กง.','ธน.','พ','ผท','กส.','ดย.','ขว.']
                                                @endphp
                                                <div class="my-2 form-group">
                                                    <label for="nco_corp" class="form-label">เหล่า</label>
                                                    <select class="form-select" id="nco_corp"  name="nco_corp">
                                                    <option value ="{{isset($nco->nco_corp) ? $nco->nco_corp : ''}}" >{{isset($nco->nco_corp) ? $nco->nco_corp : ''}}</option>
                                                        @foreach ( $unitArr as $row )
                                                      <option value="{{ $row}}">{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('nco_corp')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                @php
                                                    $bornArr = array();
                                                    $bornArr=['นนส.','กองหนุน']
                                                @endphp
                                                {{-- <!--กำหนดเนิด -->
                                                <div class="my-2 form-group">
                                                    <label for="nco_intern" class="form-label">กำหนดเนิด</label>
                                                    <select class="form-select" id="nco_intern" name="nco_intern">
                                                        <option value ="{{isset($nco->nco_intern) ? $nco->nco_intern : '' }} " >{{isset($nco->nco_born) ? $nco->nco_born : ''}}</option>
                                                        @foreach ( $bornArr as $row )
                                                      <option value="{{$row}}"{{ $row == $nco->nco_intern ? 'selected' : ''}}>{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('nco_intern')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror --}}



                                                <!--วันที่ เข้าประจำการ-->
                                                {{-- <div class="flex flex-auto"> --}}

                                                        {{-- <div class="my-2 form-group">
                                                            <label for="nco_startdate">วันที่เข้ารับราชการ</label>
                                                            <div class="w-64">
                                                                <input type="text" class="form-control soldier-date"  name="nco_startdate" value ="{{ isset($nco->nco_startdate) ? Carbon\Carbon::parse($nco->nco_startdate)->format('d/m').'/'.Carbon\Carbon::parse($nco->nco_startdate)->format('Y')+543 : ''}}" >
                                                            </div>
                                                        </div>
                                                        @error('nco_startdate')
                                                        <div class="my-2">
                                                            <span class="text-red-600 text">{{$message}}</span>
                                                        </div>
                                                        @enderror --}}
                                                        <!--หน่วย -->
                                                    <div class="my-2 form-group">
                                                        <label for="nco_dep_name">หน่วย</label>
                                                        <input type="text" class="form-control" name="nco_dep_name" placeholder="" value ="{{isset($nco->nco_dep_name) ? $nco->nco_dep_name : ''}}" disabled >
                                                    </div>
                                                    @error('nco_dep_name')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--วุฒิการศึกษา -->
                                                    <div class="my-2 form-group">
                                                        <label for="nco_education">วุฒิการศึกษา </label>
                                                        <input type="text" class="form-control" name="nco_education" placeholder="" value ="{{isset($nco->nco_education) ? $nco->nco_education : ''}}" >
                                                    </div>
                                                    @error('cco_education')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--สาขา -->
                                                    <div class="my-2 form-group">
                                                        <label for="nco_education_study">สาขา</label>
                                                        <input type="text" class="form-control" name="nco_education_study" placeholder="" value ="{{isset($nco->nco_education_study) ? $nco->nco_education_study: ''}}" >
                                                    </div>
                                                    @error('nco_education_study')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--ความต้องการพิเศษ -->
                                                    <div class="my-2 form-group">
                                                        <label for="nco_wantto">ความต้องการพิเศษ</label>
                                                        <input type="text" class="form-control" name="nco_wantto" placeholder="" value ="{{isset($nco->nco_wantto) ? $nco->nco_wantto : ''}}" >
                                                    </div>
                                                    @error('nco_wantto')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--โรคประจำตัว -->
                                                    <div class="my-2 form-group">
                                                        <label for="nco_health">โรคประจำตัว</label>
                                                        <input type="text" class="form-control" name="nco_health" placeholder="" value ="{{isset($nco->nco_health) ? $nco->nco_health : ''}}" >
                                                    </div>
                                                    @error('nco_health')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror

                                                <!--เบอร์โทรศัพท์-->
                                                <div class="my-2 form-group">
                                                    <label for="nco_phone">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="nco_phone" value ="{{isset($nco->nco_phone) ? $nco->nco_phone : ''}}" >
                                                </div>
                                                @error('nco_phone')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--หมายเหตุ-->
                                                <div class="my-2 form-group">
                                                    <label for="nco_about">หมายเหตุ</label>
                                                    <input type="text" class="form-control" name="nco_about" value ="{{isset($nco->nco_about) ? $nco->nco_about: ''}}" >
                                                </div>
                                                @error('nco_about')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                {{-- <div class="my-4 card ">
                                                    <div class="text-white bg-slate-500 card-header">ข้อมูล บุพพการี</div>
                                                        <div class=" card-body bg-slate-100">
                                                            {{-- <!--ความต้องการพิเศษ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_id">เลขบัตรประชานผู้พิการ</label>
                                                                    <input type="text" class="form-control" name="nco_law_id" placeholder=" " value ="{{isset($nco->nco_law_id) ? $nco->nco_law_id : ''}}" >
                                                                </div>
                                                                @error('nco_law_id')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--อาการป่วย-->
                                                                @php
                                                                    $unitArr = array();
                                                                    $unitArr=['ไม่มี','มี',]
                                                                @endphp

                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_rank" class="form-label">มีบุพพการี ป่วยหรือไม่</label>
                                                                    <select class="form-select" id="nco_law_rank" name="nco_law_rank">

                                                                        @foreach ( $unitArr as $row )
                                                                    <option value="{{$row}}"{{ $row == $nco->nco_law_rank ? 'selected' : ''}}>{{$row}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('nco_law_rank')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                {{-- <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_name">ชื่อ-สกุล</label>
                                                                    <input type="text" class="form-control" name="nco_law_name" placeholder="" value ="{{isset($nco->nco_law_name) ? $nco->nco_law_name : ''}}" >
                                                                </div>
                                                                @error('nco_law_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--ลักษณะทางความพิการ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_defective">ลักษณะทางความพิการ</label>
                                                                    <input type="text" class="form-control" name="nco_law_defective" placeholder="" value ="{{isset($nco->nco_law_defective) ? $nco->nco_law_defective : ''}}" >
                                                                </div>
                                                                @error('nco_law_defective')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--สาเหตุความพิการเกิดจาก-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_defective_about">สาเหตุความพิการเกิดจาก</label>
                                                                    <input type="text" class="form-control" name="nco_law_defective_about" placeholder="" value ="{{isset($nco->nco_law_defective_about) ? $nco->nco_law_defective_about : ''}}" >
                                                                </div>
                                                                @error('nco_law_defective_about')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--ประวัติการเข้าร่วม ม.35(3)-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_m3_join">ประวัติการเข้าร่วม ม.35(3)</label>
                                                                    <input type="text" class="form-control" name="nco_law_m3_join" placeholder="" value ="{{isset($nco->nco_law_m3_join) ? $nco->nco_law_m3_join : ''}}" >
                                                                </div>
                                                                @error('nco_law_m3_join')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                 <!--ประวัติการเข้าร่วม ม.35(7)-->
                                                                 <div class="my-2 form-group">
                                                                    <label for="nco_law_m7_join">ประวัติการเข้าร่วม ม.35(3)</label>
                                                                    <input type="text" class="form-control" name="nco_law_m7_join" placeholder="" value ="{{isset($nco->nco_law_m7_join) ? $nco->nco_law_m7_join : ''}}" >
                                                                </div>
                                                                @error('nco_law_m7_join')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--สิทธิอื่นๆที่รับ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_reward">สิทธิอื่นๆที่รับ</label>
                                                                    <input type="text" class="form-control" name="nco_law_reward" placeholder="" value ="{{isset($nco->nco_law_reward) ? $nco->nco_law_reward : ''}}" >
                                                                </div>
                                                                @error('nco_law_reward')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_parent">ระบุ(ถ้ามี)</label>
                                                                    <input type="text" class="form-control" name="nco_law_parent" placeholder="" value ="{{isset($nco->nco_law_parent) ? $nco->nco_law_parent : ''}}" >
                                                                </div>
                                                                @error('nco_law_parent')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                        </div>
                                                </div> --}}
                                                <div class="my-4 card ">
                                                    <div class="text-white bg-slate-500 card-header">ข้อมูล อาชีพเสริม</div>
                                                        <div class=" card-body bg-slate-100">

                                                                <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_skill_work">อาชีพเสริม</label>
                                                                    <input type="text" class="form-control" name="nco_skill_work" placeholder="" value ="{{isset($nco->nco_skill_work) ? $nco->nco_skill_work : ''}}" >
                                                                </div>
                                                                @error('nco_skill_work')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_skill">ความสามารถพิเศษ</label>
                                                                    <input type="text" class="form-control" name="nco_skill" placeholder="" value ="{{isset($nco->nco_skill) ? $nco->nco_skill : ''}}" >
                                                                </div>
                                                                @error('nco_skill')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror


                                                        </div>
                                                </div>
                                                <div class="my-4 card ">
                                                    <div class="text-white bg-green-900 card-header">ข้อมูล ครอบครัว</div>
                                                        <div class=" card-body bg-slate-100">
                                                                <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_wife_name">ชื่อภรรยา</label>
                                                                    <input type="text" class="form-control" name="nco_wife_name" placeholder="" value ="{{isset($nco->nco_wife_name) ? $nco->nco_wife_name : ''}}" >
                                                                </div>
                                                                @error('nco_wife_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror

                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_child_name1">ชื่อบุตรคนที่ 1</label>
                                                                    <input type="text" class="form-control" name="nco_child_name1" placeholder="" value ="{{isset($nco->nco_child_name1) ? $nco->nco_child_name1 : ''}}" >
                                                                </div>
                                                                @error('nco_child_name1')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_child_name2">ชื่อบุตรคนที่ 2</label>
                                                                    <input type="text" class="form-control" name="nco_child_name2" placeholder="" value ="{{isset($nco->nco_child_name2) ? $nco->nco_child_name2 : ''}}" >
                                                                </div>
                                                                @error('nco_child_name2')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_child_name3">ชื่อบุตรคนที่ 3</label>
                                                                    <input type="text" class="form-control" name="nco_child_name3" placeholder="" value ="{{isset($nco->nco_child_name3) ? $nco->nco_child_name3 : ''}}" >
                                                                </div>
                                                                @error('nco_child_name3')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_child_name4">ชื่อบุตรคนที่ 4</label>
                                                                    <input type="text" class="form-control" name="nco_child_name4" placeholder="" value ="{{isset($nco->nco_child_name4) ? $nco->nco_child_name4 : ''}}" >
                                                                </div>
                                                                @error('cco_child_name4')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_child_name5">ชื่อบุตรคนที่ 5</label>
                                                                    <input type="text" class="form-control" name="nco_child_name5" placeholder="" value ="{{isset($nco->nco_child_name5) ? $nco->nco_child_name5 : ''}}" >
                                                                </div>
                                                                @error('nco_child_name5')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                        </div>
                                                </div>

                                            <br>
                                             <a href="{{ '/nco/all?page='.request()->page.'&search='.request()->search.'&nco_dep_id='.request()->soldier_dep_id.'&nco_provinces='.request()->nco_provinces.'&nco_education='.request()->nco_education.'&nco_disease='.request()->nco_disease  }}{{isset($nco_rank) ? '&nco_rank='.$nco_rank : '' }}" class="text-black bg-yellow-400 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>

                                            <button type="submit" value="อัพเดท" class="text-black bg-blue-300 btn btn-primary">อัพเดท </button>
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


<script>
$(document).ready(function() {

});


function showAmphoes() {

    let nco_province = document.querySelector("#nco_province");
        let url = "/nco/amphoes?province=" + nco_province.value;
        console.log( url );
        // if(soldier_province.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let nco_amphoe = document.querySelector("#nco_amphoe");
                nco_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ ครับ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe;
                    nco_amphoe.appendChild(option);
                }
                //QUERY AMPHOES
                showTambons();
            });
    }
// เมื่อเลือกจังหวัดเกิดการเปลี่ยนแปลง
    document.querySelector('#nco_province').addEventListener('change', (event) => {
        showAmphoes();
    });


</script>
