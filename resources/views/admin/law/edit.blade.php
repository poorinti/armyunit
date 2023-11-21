<x-app-layout>
    <x-slot name="header4">
        <h2 class="text-xl font-semibold leading-tight text-white">
             ข้อมูลผู้พิการ
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
 @php   $url='/law/all?';
 $url .=isset($page)? 'page='.$page :'';
 $url .=isset($search) ? '&search='.$search : '' ;
 $url .=isset($law_dep_id) ? '&law_dep_id='.$law_dep_id : '' ;
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
                            <a href="{{ '/law/all?page='.request()->page.'&search='.request()->search.'&law_dep_id='.request()->law_dep_id.'&law_provinces='.request()->law_provinces.'&law_education='.request()->law_education.'&law_disease='.request()->law_disease  }}{{isset($law_rank) ? '&law_rank='.$law_rank : '' }}{{isset($law_lawchk) ? '&law_lawchk='.$law_lawchk: '' }}" class="text-black bg-purple-700 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>
                            <div class="bg-slate-200 card-header ">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body ">
                                <img src="{{isset($law->law_image) ? asset(lawo->law_image) : '/image/logo/logo1.png'}}" alt="{{ isset($law->law_image) ? asset($law->law_image) : '' }}" alt="imageshow" width="200px" height="200px">
                                {{-- <label for="imageshow">{{$soldier->soldier_name }}</label> --}}
                            </div>

                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class=" card">
                            <div class="card">
                                <div class="bg-slate-200 card-header">แก้ไขข้อมูลประจำตัว</div>
                                     <div class="card-body">
                                        <form action="{{url('/law/update/'.$law->law_id )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="my-3 form-group">
                                                <!--  ภาพเก่า -->
                                                <br>
                                                <input type="hidden" name="old_image" value="{{$law->law_image}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="law_id" value="{{$law->law_id}}">

                                                <!-- เพจ -->
                                                <input type="hidden" name="page" value="{{$page}}">

                                                <input type="hidden" name="law_dep_id" value="{{$law_dep_id}}">
                                                <input type="hidden" name="search" value="{{$search}}">
                                                <input type="hidden" name="law_index" value="{{$law->law_index}}">
                                                <input type="hidden" name="law_rank_index" value="{{$law->law_rank_index}}">
                                                <input type="hidden" name="law_provinces" value="{{isset($law_provinces) ? $law_provinces :'' }}">


                                                <div class="form-group">
                                                </div>
                                                <label for="law_image">อัพโหลดภาพโปรไฟล์</label>
                                                <input type="file" class="form-control" name="law_image" value="{{$law->law_image}}">
                                                </div>
                                                @error('law_image')
                                                        <div class="my-2">
                                                            <span class="text-danger">{{$message}}</span>
                                                        </div>
                                                    @enderror
                                                 <!--ยศ -->
                                                 <div class="my-2 form-group">
                                                    <label for="law_rank">ยศ/คำนำหน้า</label>
                                                     <select class="form-control" name="law_rank" id="law_rank" required>
                                                     @foreach ( $rank as $key=>$row )
                                                     <option value="{{$row->rank_name}}" {{ $row->rank_name==$law->law_rank ? 'selected' : ''}}>{{$row->rank_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('law_rank')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ชื่อ -->
                                                <label for="law_name">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" name="law_name" value="{{$law->law_name}}" >
                                                @error('law_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เลขประชาชน -->
                                                <div class="my-2 form-group">
                                                    <label for="law_id">เลขบัตรประชนผู้พิการ</label>
                                                    <input type="text" class="form-control" name="law_id"  value =" {{$law->law_id}}" placeholder="ตัวอย่าง :เลข 13 หลัก" disabled>
                                                </div>
                                                @error('law_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                @php
                                                $lawArr = array();
                                                $lawArr=['พิการทางการมองเห็น','พิการทางการได้ยินหรือสื่อความหมาย','พิการทางการเคลื่อนไหวหรือทางร่างกาย','พิการทางจิตใจ หรือพฤติกรรม','พิการทางการสติปัญญา','พิการทางการเรียนรู้','พิการทางออทิสติก','อื่นๆ']
                                                @endphp

                                                <!--ลักษณะการพิการ -->
                                               <div class="my-2 form-group">
                                                  <label for="law_defective" class="form-label">ลักษณะการพิการ</label>
                                                  <select class="form-select" id="law_defective" name="law_defective">
                                                    {{-- <option value ="{{isset($law->law_index) ? $law->law_index : 0 }}" >เข้าร่วมทั้งสอง</option> --}}
                                                    @foreach (  $lawArr as $row )
                                                  <option value="{{$row}}"{{ $law->law_defective == $row ? 'selected' : ''}}>{{$row}}</option>
                                                  @endforeach
                                                  </select>
                                              </div>
                                              @error('law_index')
                                              <div class="my-2">
                                                <span class="text-red-600 text">{{$message}}</span>
                                              </div>
                                               @enderror
                                                <!--สาเหตุความพิการเกิดจาก-->
                                                <div class="my-2 form-group">
                                                    <label for="law_defective_about">สาเหตุความพิการเกิดจาก</label>
                                                    <input type="text" class="form-control" name="law_defective_about" placeholder="" value ="{{isset($law->law_defective_about) ? $law->law_defective_about : ''}}" >
                                                </div>
                                                @error('law_defective_about')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                @php
                                                $lawArr = array();
                                                $lawArr=[0,3,7]
                                                @endphp
                                                <!--เคยเข้าร่วม -->
                                               <div class="my-2 form-group">
                                                  <label for="law_index" class="form-label">เคยเข้าร่วม</label>
                                                  <select class="form-select" id="law_index" name="law_index">
                                                    {{-- <option value ="{{isset($law->law_index) ? $law->law_index : 0 }}" >เข้าร่วมทั้งสอง</option> --}}
                                                    @foreach (  $lawArr as $row )
                                                  <option value="{{$row}}"{{ $law->law_index == $row ? 'selected' : ''}}>{{$row == 0 ? 'เข้าร่วมทั้งสอง' : 'ม.35('.$row.')'}}</option>
                                                  @endforeach
                                                  </select>
                                              </div>
                                              @error('law_index')
                                              <div class="my-2">
                                                <span class="text-red-600 text">{{$message}}</span>
                                              </div>
                                               @enderror
                                                <!--ประวัติการเข้าร่วม ม.35(3)-->
                                                <div class="my-2 form-group">
                                                    <label for="law_m3_join">ประวัติการเข้าร่วม ม.35(3)</label>
                                                    <input type="text" class="form-control" name="law_m3_join" placeholder="" value ="{{isset($nco->law_m3_join) ? $nco->law_m3_join : ''}}" >
                                                </div>
                                                @error('law_m3_join')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                 <!--ประวัติการเข้าร่วม ม.35(7)-->
                                                 <div class="my-2 form-group">
                                                    <label for="law_m7_join">ประวัติการเข้าร่วม ม.35(7)</label>
                                                    <input type="text" class="form-control" name="law_m7_join" placeholder="" value ="{{isset($nco->law_m7_join) ? $nco->law_m7_join : ''}}" >
                                                </div>
                                                @error('law_m7_join')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--สิทธิอื่นๆที่รับ-->
                                                <div class="my-2 form-group">
                                                    <label for="law_reward">สิทธิอื่นๆที่รับ</label>
                                                    <input type="text" class="form-control" name="law_reward" placeholder="" value ="{{isset($nco->law_reward) ? $nco->law_reward : ''}}" >
                                                </div>
                                                @error('law_reward')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                  {{-- <!--เลขประจำตัวทหาร -->
                                                  <div class="my-2 form-group">
                                                    <label for="nco_rtanumber">เลขประจำตัวทหาร</label>
                                                    <input type="text" class="form-control" name="nco_rtanumber" placeholder="ตัวอย่าง :เลข 10 หลัก" value ="{{isset($nco->nco_rtanumber) ? $nco->nco_rtanumber : ''}}">
                                                </div>
                                                @error('nco_rtanumber')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror --}}
                                                <!--ภูมิลำเนา-->
                                                <div class="my-2 form-group">
                                                    <label for="law_address">ภูมิลำเนา</label>
                                                    <input type="text" class="form-control" name="law_address"placeholder="ตัวอย่าง : 118 หมู่ 7 ต.โพธิ์สัย อ.ศรัสมเด็จ" value ="{{isset($law->law_address) ? $law->law_address : ''}}" >
                                                </div>
                                                @error('law_address')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <div class="my-2 form-group">
                                                    <label for="law_province">จังหวัด</label>
                                                    <select id="law_province" name="law_province" class="form-select"  >
                                                        <option value="">กรุณาเลือกจังหวัด</option>
                                                        @foreach($provinces as $item)
                                                        <option value="{{ $item->province }}" {{ $item->province==$law->law_province ? 'selected' : ''}}>{{ $item->province }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="my-2 form-group">
                                                    <label for="law_amphoe">เขต/อำเภอ</label>
                                                    <select id="law_amphoe"  name="law_amphoe"  class="form-select" >
                                                        <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                                        @foreach($amphoes as $item)
                                                        <option value="{{ $item->amphoe }}" {{ $item->amphoe==$law->nco_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                                                        @endforeach
                                                        </select>
                                                </div>


                                                {{-- <!--ผลัดที่/ปี -->
                                                <div class="my-2 form-group">
                                                    <label for="nco_intern">รุ่น</label>
                                                    <input type="text" class="form-control" name="nco_intern" placeholder="ตัวอย่าง : 1/66 , 2/66" value ="{{isset($soldier->soldier_intern) ? $soldier->soldier_intern : ''}}" >
                                                </div>
                                                @error('nco_intern')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เหล่า -->
                                                @php
                                                    $unitArr = array();
                                                    $unitArr=['ร.','ม.','ป.','ช.','ส.','ขส.','สพ.','พธ.','สห.','สบ.','กง.','สบ.','กง.','ธน.','พ','ผท','กส.','ดย.','ขว.']
                                                @endphp --}}
                                                {{-- <div class="my-2 form-group">
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
                                                <!--กำหนดเนิด -->
                                                <div class="my-2 form-group">
                                                    <label for="nco_intern" class="form-label">กำหนดเนิด</label>
                                                    <select class="form-select" id="nco_intern" name="nco_intern">
                                                        <option value ="{{isset($nco->nco_intern) ? $nco->nco_intern : '' }} " >{{isset($nco->nco_born) ? $nco->nco_born : ''}}</option>
                                                        @foreach ( $bornArr as $row )
                                                      <option value="{{$row}}">{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('nco_born')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror --}}


{{--
                                                <!--วันที่ เข้าประจำการ-->


                                                        <div class="my-2 form-group">
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

                                                <!--เบอร์โทรศัพท์-->
                                                <div class="my-2 form-group">
                                                    <label for="law_phone">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="law_phone" value ="{{isset($law->law_phone) ? $law->law_phone : ''}}" >
                                                </div>
                                                @error('law_phone')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--หมายเหตุ-->
                                                <div class="my-2 form-group">
                                                    <label for="law_about">หมายเหตุ</label>
                                                    <input type="text" class="form-control" name="law_about" value ="{{isset($law->law_about) ? $law->law_about: ''}}" >
                                                </div>
                                                @error('law_about')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                <div class="my-4 card ">
                                                    <div class="text-white bg-slate-500 card-header">ข้อมูลผู้เกี่ยวข้อง</div>
                                                        <div class=" card-body bg-slate-100">
                                                            @php
                                                            $lawArr = array();
                                                            $lawArr=['คู่สมรส','บุตร','บิดา','มารดา','ปู่','ย่า','ตา','ยาย','พี่','น้อง','อื่นๆ']
                                                            @endphp
                                                            <!--ความเกี่ยวข้องกับกำลังพล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="law_parent_about" class="form-label">ความเกี่ยวข้องกับกำลังพล</label>
                                                                    <select class="form-select" id="law_parent_about" name="law_parent_about">
                                                                        {{-- <option value ="{{isset($law->law_index) ? $law->law_index : 0 }}" >เข้าร่วมทั้งสอง</option> --}}
                                                                        @foreach (  $lawArr as $row )
                                                                    <option value="{{$row}}"{{ $law->law_parent_about == $row ? 'selected' : ''}}>{{$row}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('law_index')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror

                                                            <!--ยศ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="law_parent_rank">ยศ/คำนำหน้า</label>
                                                                    <select class="form-control" name="law_parent_rank" id="law_parent_rank" required>
                                                                    @foreach ( $rank as $key=>$row )
                                                                    <option value="{{$row->rank_name}}"{{ $row->rank_name==$law->law_parent_rank ? 'selected' : ''}}>{{$row->rank_name}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('law_parent_rank')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                {{-- <!--เลขบัตรประชานผู้เกี่ยวข้อง-->
                                                                <div class="my-2 form-group">
                                                                    <label for="law_parent_id">เลขบัตรประชน</label>
                                                                    <input type="text" class="form-control" name="law_parent_id" placeholder=" " value ="{{isset($law->law_parent_id) ? $law->law_parent_id : ''}}" >
                                                                </div>
                                                                @error('law_parent_id')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror --}}
                                                              <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="law_parent_name">ชื่อ-สกุล</label>
                                                                    <input type="text" class="form-control" name="law_parent_name" placeholder="" value ="{{isset($law->law_parent_name) ? $law->law_parent_name : ''}}" >
                                                                </div>
                                                                @error('law_parent_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หน่วย-->
                                                                <div class="my-2 form-group">
                                                                    <label for="law_dep_name">หน่วย</label>
                                                                    <input type="text" class="form-control" name="law_dep_name" placeholder="" value ="{{isset($law->law_dep_name) ? $law->law_dep_name : ''}}" >
                                                                </div>
                                                                @error('law_dap_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                 <!--เบอร์-->
                                                                 <div class="my-2 form-group">
                                                                    <label for="law_phone">เบอร์</label>
                                                                    <input type="text" class="form-control" name="law_phone" placeholder="" value ="{{isset($law->law_phone) ? $law->law_phone : ''}}" >
                                                                </div>
                                                                @error('law_phone')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror

                                                        </div>
                                                    </div>

                                            <br>
                                             <a href="{{ '/law/all?page='.request()->page.'&search='.request()->search.'&law_dep_id='.request()->law_dep_id.'&law_provinces='.request()->law_provinces.'&law_education='.request()->law_education.'&law_disease='.request()->law_disease  }}{{isset($law_rank) ? '&law_rank='.$law_rank : '' }}" class="text-black bg-yellow-400 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>

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

    let nco_province = document.querySelector("#law_province");
        let url = "/law/amphoes?province=" + law_province.value;
        console.log( url );
        // if(soldier_province.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let law_amphoe = document.querySelector("#law_amphoe");
                law_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ ครับ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe;
                    law_amphoe.appendChild(option);
                }
                //QUERY AMPHOES
                showTambons();
            });
    }
// เมื่อเลือกจังหวัดเกิดการเปลี่ยนแปลง
    document.querySelector('#law_province').addEventListener('change', (event) => {
        showAmphoes();
    });


</script>

