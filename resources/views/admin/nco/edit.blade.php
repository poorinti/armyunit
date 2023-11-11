<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
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
 @php   $url='/soldier/all?';
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

                            <div class="bg-yellow-100 card-header ">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body ">
                                <img src="{{isset($nco->nco_image) ? asset($nco->nco_image) : '/image/logo/logo1.png'}}" alt="{{ isset($nco->nco_image) ? asset($nco->nco_image) : '' }}" alt="imageshow" width="200px" height="200px">
                                {{-- <label for="imageshow">{{$soldier->soldier_name }}</label> --}}
                            </div>

                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class=" card">
                            <div class="card">
                                <div class="bg-yellow-100 card-header">แก้ไขข้อมูลประจำตัว</div>
                                     <div class="card-body">
                                        <form action="{{url('/nco/update/' )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="my-3 form-group">
                                                {{-- <!--  ภาพเก่า -->
                                                <br>
                                                <input type="hidden" name="old_image" value="{{$nco->nco_image}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="nco_id" value="{{$nco->nco_id}}">

                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="page" value="{{$page}}">

                                                <input type="hidden" name="nco_dep_id" value="{{$nco_dep_id}}">
                                                <input type="hidden" name="search" value="{{$search}}">
                                                <input type="hidden" name="nco_provinces" value="{{isset($nco_provinces) ? $nco_provinces :'' }}"> --}}


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
                                                <label for="nco_rank">ยศ</label>
                                                <input type="text" class="form-control" name="nco_rank" value="{{$nco->nco_rank}}" >
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
                                                <!--เลขประชาชน -->
                                                <div class="my-2 form-group">
                                                    <label for="nco_id">เลขประชาชน</label>
                                                    <input type="text" class="form-control" name="nco_id"  value =" {{$nco->nco_id}}" placeholder="ตัวอย่าง :เลข 13 หลัก" disabled>
                                                </div>
                                                @error('nco_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                  <!--เลขประจำตัวทหาร -->
                                                  <div class="my-2 form-group">
                                                    <label for="nco_rtanumber">เลขประจำตัวทหาร</label>
                                                    <input type="text" class="form-control" name="nco_rtanumber" placeholder="ตัวอย่าง :เลข 10 หลัก" value ="{{isset($nco->nco_rtanumber) ? $nco->nco_rtanumber : ''}}">
                                                </div>
                                                @error('nco_rtanumber')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ภูมิลำเนา-->
                                                <div class="my-2 form-group">
                                                    <label for="nco_address">ภูมิลำเนา</label>
                                                    <input type="text" class="form-control" name="nco_address"placeholder="ตัวอย่าง : 118 หมู่ 7 ต.โพธิ์สัย อ.ศรัสมเด็จ" value ="{{isset($nco->nco_address) ? $nco->nco_address : ''}}" >
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


                                                <!--ผลัดที่/ปี -->
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
                                                <!--กำหนดเนิด -->
                                                <div class="my-2 form-group">
                                                    <label for="nco_born" class="form-label">กำหนดเนิด</label>
                                                    <select class="form-select" id="nco_born" name="nco_born">
                                                        <option value ="{{isset($nco->nco_born) ? $nco->nco_born : '' }} " >{{isset($nco->nco_born) ? $nco->nco_born : ''}}</option>
                                                        @foreach ( $bornArr as $row )
                                                      <option value="{{ $row}}">{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('nco_born')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror



                                                <!--วันที่ เข้าประจำการ-->
                                                {{-- <div class="flex flex-auto"> --}}

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
                                                <div class="my-4 card ">
                                                    <div class="text-white bg-slate-500 card-header">ข้อมูล ม.35</div>
                                                        <div class=" card-body bg-slate-100">
                                                            <!--ความต้องการพิเศษ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_id">เลขบัตรประชานผู้พิการ</label>
                                                                    <input type="text" class="form-control" name="nco_law_id" placeholder=" " value ="{{isset($nco->nco_law_id) ? $nco->nco_law_id : ''}}" >
                                                                </div>
                                                                @error('nco_law_id')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--ยศ-->
                                                                @php
                                                                    $unitArr = array();
                                                                    $unitArr=['ไม่มี','มี',]
                                                                @endphp

                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_rank" class="form-label">คำนำหน้า</label>
                                                                    <select class="form-select" id="nco_law_rank" name="nco_law_rank">
                                                                        <option value ="{{isset($nco->nco_law_rank) ? $nco->nco_law_rank : '' }} " >{{isset($nco->nco_law_rank) ? $nco->nco_law_rank : ''}}</option>
                                                                        @foreach ( $unitArr as $row )
                                                                    <option value="{{ $row}}">{{ $row}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('nco_law_rank')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--ชื่อ-สกุล-->
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
                                                                <!--ความเกี่ยวข้องกับกำลังพล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="nco_law_parent">ความเกี่ยวข้องกับกำลังพล</label>
                                                                    <input type="text" class="form-control" name="nco_law_parent" placeholder="" value ="{{isset($nco->nco_law_parent) ? $nco->nco_law_parent : ''}}" >
                                                                </div>
                                                                @error('nco_law_parent')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                        </div>
                                                    </div>

                                            <br>
                                             <a href="{{ '/soldier/all?page='.request()->page.'&search='.request()->search.'&soldier_dep_id='.request()->soldier_dep_id.'&soldier_provinces='.request()->soldier_provinces.'&soldier_education='.request()->soldier_education.'&soldier_disease='.request()->soldier_disease  }}" class="text-black bg-yellow-400 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>

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

    let soldier_province = document.querySelector("#soldier_province");
        let url = "/soldier/amphoes?province=" + soldier_province.value;

        // if(soldier_province.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let soldier_amphoe = document.querySelector("#soldier_amphoe");
                soldier_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe;
                    soldier_amphoe.appendChild(option);
                }
                //QUERY AMPHOES
                showTambons();
            });
    }
// เมื่อเลือกจังหวัดเกิดการเปลี่ยนแปลง
    document.querySelector('#soldier_province').addEventListener('change', (event) => {
        showAmphoes();
    });


</script>
