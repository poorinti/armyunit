<x-app-layout>
    <x-slot name="header3">
        <h2 class="text-xl font-semibold leading-tight text-white">
            ข้อมูลนายทหาร
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
                            <a href="{{ '/cco/all?page='.request()->page.'&search='.request()->search.'&cco_dep_id='.request()->cco_dep_id.'&cco_provinces='.request()->cco_provinces.'&cco_education='.request()->cco_education.'&cco_disease='.request()->cco_disease.'&cco_amphoe='.request()->cco_amphoe  }}{{isset($cco_rank) ? '&cco_rank='.$cco_rank : '' }}" class="text-black bg-purple-700 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>
                            <div class="bg-slate-200 card-header ">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body ">
                                <img src="{{isset($cco->cco_image) ? asset($cco->cco_image) : '/image/logo/logo1.png'}}" alt="{{ isset($cco->cco_image) ? asset($cco->cco_image) : '' }}" alt="imageshow" width="200px" height="200px">
                                {{-- <label for="imageshow">{{$soldier->soldier_name }}</label> --}}
                            </div>

                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class=" card">
                            <div class="card">
                                <div class="bg-slate-200 card-header">แก้ไขข้อมูลประจำตัว</div>
                                     <div class="card-body">
                                        <form action="{{url('/cco/update/'.$cco->cco_id )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="my-3 form-group">
                                                <!--  ภาพเก่า -->
                                                <br>
                                                <input type="hidden" name="old_image" value="{{$cco->cco_image}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="cco_id" value="{{$cco->cco_id}}">

                                                <!-- เพจ -->
                                                <input type="hidden" name="page" value="{{$page}}">

                                                <input type="hidden" name="cco_dep_id" value="{{$cco_dep_id}}">
                                                <input type="hidden" name="search" value="{{$search}}">
                                                <input type="hidden" name="cco_provinces" value="{{isset($cco_provinces) ? $cco_provinces :'' }}">


                                                <div class="form-group">
                                                </div>
                                                <label for="cco_image">อัพโหลดภาพโปรไฟล์</label>
                                                <input type="file" class="form-control" name="cco_image" value="{{$cco->cco_image}}">
                                                </div>
                                                @error('cco_image')
                                                        <div class="my-2">
                                                            <span class="text-danger">{{$message}}</span>
                                                        </div>
                                                    @enderror
                                                 <!--ยศ -->
                                                 <div class="my-2 form-group">
                                                    <label for="cco_rank">ยศ/คำนำหน้า</label>
                                                     <select class="form-control" name="cco_rank" id="cco_rank" required>
                                                     @foreach ( $rank as $key=>$row )
                                                     <option value="{{$row->rank_name}}"{{ $row->rank_name==$cco->cco_rank ? 'selected' : ''}}>{{$row->rank_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('cco_rank')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ชื่อ -->
                                                <label for="cco_name">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" name="cco_name" value="{{$cco->cco_name}}" >
                                                @error('cco_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เลขประชาชน -->
                                                <div class="my-2 form-group">
                                                    <label for="cco_id">เลขประจำตัวทหาร</label>
                                                    <input type="text" class="form-control" name="cco_id"  value =" {{$cco->cco_id}}" placeholder="ตัวอย่าง :เลข 13 หลัก" disabled>
                                                </div>
                                                @error('cco_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ภูมิลำเนา-->
                                                <div class="my-2 form-group">
                                                    <label for="cco_address">ภูมิลำเนา</label>
                                                    <input type="text" class="form-control" name="cco_address"placeholder="ตัวอย่าง : 118 หมู่ 7 ต.โพธิ์สัย" value ="{{isset($cco->cco_address) ? $cco->cco_address : ''}}" >
                                                </div>
                                                @error('cco_address')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <div class="my-2 form-group">
                                                    <label for="cco_province">จังหวัด</label>
                                                    <select id="cco_province" name="cco_province" class="form-select"  >
                                                        <option value="">กรุณาเลือกจังหวัด</option>
                                                        @foreach($provinces as $item)
                                                        <option value="{{ $item->province }}" {{ $item->province==$cco->cco_province ? 'selected' : ''}}>{{ $item->province }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="my-2 form-group">
                                                    <label for="cco_amphoe">เขต/อำเภอ</label>
                                                    <select id="cco_amphoe"  name="cco_amphoe"  class="form-select" >
                                                        <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                                        @foreach($amphoes as $item)
                                                        <option value="{{ $item->amphoe }}" {{ $item->amphoe==$cco->cco_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                                                        @endforeach
                                                        </select>
                                                </div>
                                                <!--เหล่า -->
                                                @php
                                                    $unitArr = array();
                                                    $unitArr=['ร.','ม.','ป.','ช.','ส.','ขส.','สพ.','พธ.','สห.','สบ.','กง.','สบ.','กง.','ธน.','พ','ผท','กส.','ดย.','ขว.']
                                                @endphp
                                                <div class="my-2 form-group">
                                                    <label for="cco_corp" class="form-label">เหล่า</label>
                                                    <select class="form-select" id="cco_corp"  name="cco_corp">
                                                    {{-- <option value ="{{isset($cco->cco_corp) ? $cco->nco_corp : ''}}" >{{isset($cco->cco_corp) ? $cco->cco_corp : ''}}</option> --}}
                                                        @foreach ( $unitArr as $row )
                                                      <option value="{{$row}}"{{ $row==$cco->cco_amphoe ? 'selected' : ''}}>{{ $row}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('cco_corp')
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
                                                            <label for="cco_startdate">วันที่เข้ารับราชการ</label>
                                                            <div class="w-64">
                                                                <input type="text" class="form-control soldier-date"  name="cco_startdate" value ="{{ isset($cco->cco_startdate) ? Carbon\Carbon::parse($cco->cco_startdate)->format('d/m').'/'.Carbon\Carbon::parse($cco->cco_startdate)->format('Y')+543 : ''}}" >
                                                            </div>
                                                        </div>
                                                        @error('cco_startdate')
                                                        <div class="my-2">
                                                            <span class="text-red-600 text">{{$message}}</span>
                                                        </div>
                                                        @enderror --}}
                                                    <!--หน่วย -->
                                                    <div class="my-2 form-group">
                                                        <label for="cco_dep_name">หน่วย</label>
                                                        <input type="text" class="form-control" name="cco_dep_name" placeholder="" value ="{{isset($cco->cco_dep_name) ? $cco->cco_dep_name : ''}}" disabled >
                                                    </div>
                                                    @error('cco_dep_name')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--วุฒิการศึกษา -->
                                                    <div class="my-2 form-group">
                                                        <label for="cco_education">วุฒิการศึกษา </label>
                                                        <input type="text" class="form-control" name="cco_education" placeholder="" value ="{{isset($cco->cco_education) ? $cco->cco_education : ''}}" >
                                                    </div>
                                                    @error('cco_education')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--สาขา -->
                                                    <div class="my-2 form-group">
                                                        <label for="cco_education_study">สาขา</label>
                                                        <input type="text" class="form-control" name="cco_education_study" placeholder="" value ="{{isset($cco->cco_education_study) ? $cco->cco_education_study: ''}}" >
                                                    </div>
                                                    @error('cco_education_study')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--ความต้องการพิเศษ -->
                                                    <div class="my-2 form-group">
                                                        <label for="cco_wantto">ความต้องการพิเศษ</label>
                                                        <input type="text" class="form-control" name="cco_wantto" placeholder="" value ="{{isset($cco->cco_wantto) ? $cco->cco_wantto : ''}}" >
                                                    </div>
                                                    @error('cco_wantto')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror
                                                    <!--โรคประจำตัว -->
                                                    <div class="my-2 form-group">
                                                        <label for="cco_health">โรคประจำตัว</label>
                                                        <input type="text" class="form-control" name="cco_health" placeholder="" value ="{{isset($cco->cco_health) ? $cco->cco_health : ''}}" >
                                                    </div>
                                                    @error('cco_health')
                                                    <div class="my-2">
                                                        <span class="text-red-600 text">{{$message}}</span>
                                                    </div>
                                                    @enderror


                                                <!--เบอร์โทรศัพท์-->
                                                <div class="my-2 form-group">
                                                    <label for="cco_phone">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="cco_phone" value ="{{isset($cco->cco_phone) ? $cco->cco_phone : ''}}" >
                                                </div>
                                                @error('cco_phone')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--หมายเหตุ-->
                                                <div class="my-2 form-group">
                                                    <label for="cco_about">หมายเหตุ</label>
                                                    <input type="text" class="form-control" name="cco_about" value ="{{isset($cco->cco_about) ? $cco->cco_about: ''}}" >
                                                </div>
                                                @error('cco_about')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <div class="my-4 card ">
                                                    <div class="text-white bg-slate-500 card-header">ข้อมูล อาชีพเสริม</div>
                                                        <div class=" card-body bg-slate-100">

                                                                <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_skill_work">อาชีพเสริม</label>
                                                                    <input type="text" class="form-control" name="cco_skill_work" placeholder="" value ="{{isset($cco->cco_skill_work) ? $cco->cco_skill_work : ''}}" >
                                                                </div>
                                                                @error('cco_skill_work')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_skill">ความสามารถพิเศษ</label>
                                                                    <input type="text" class="form-control" name="cco_skill" placeholder="" value ="{{isset($cco->cco_skill) ? $cco->cco_skill : ''}}" >
                                                                </div>
                                                                @error('cco_skill')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror


                                                        </div>
                                                </div>
                                                <div class="my-4 card ">
                                                    <div class="text-white bg-red-950 card-header">ข้อมูล ครอบครัว</div>
                                                        <div class=" card-body bg-slate-100">
                                                                <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_wife_name">ชื่อภรรยา</label>
                                                                    <input type="text" class="form-control" name="cco_wife_name" placeholder="" value ="{{isset($cco->cco_wife_name) ? $cco->cco_wife_name : ''}}" >
                                                                </div>
                                                                @error('cco_wife_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror

                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_child_name1">ชื่อบุตรคนที่ 1</label>
                                                                    <input type="text" class="form-control" name="cco_child_name1" placeholder="" value ="{{isset($cco->cco_child_name1) ? $cco->cco_child_name1 : ''}}" >
                                                                </div>
                                                                @error('cco_child_name1')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_child_name2">ชื่อบุตรคนที่ 2</label>
                                                                    <input type="text" class="form-control" name="cco_child_name2" placeholder="" value ="{{isset($cco->cco_child_name2) ? $cco->cco_child_name2 : ''}}" >
                                                                </div>
                                                                @error('cco_child_name2')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_child_name3">ชื่อบุตรคนที่ 3</label>
                                                                    <input type="text" class="form-control" name="cco_child_name3" placeholder="" value ="{{isset($cco->cco_child_name3) ? $cco->cco_child_name3 : ''}}" >
                                                                </div>
                                                                @error('cco_child_name3')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_child_name4">ชื่อบุตรคนที่ 4</label>
                                                                    <input type="text" class="form-control" name="cco_child_name4" placeholder="" value ="{{isset($cco->cco_child_name4) ? $cco->cco_child_name4 : ''}}" >
                                                                </div>
                                                                @error('cco_child_name4')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หากมีระบุ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="cco_child_name5">ชื่อบุตรคนที่ 5</label>
                                                                    <input type="text" class="form-control" name="cco_child_name5" placeholder="" value ="{{isset($cco->cco_child_name5) ? $cco->cco_child_name5 : ''}}" >
                                                                </div>
                                                                @error('cco_child_name5')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                        </div>
                                                </div>

                                            <br>
                                             <a href="{{ '/cco/all?page='.request()->page.'&search='.request()->search.'&cco_dep_id='.request()->cco_dep_id.'&cco_provinces='.request()->cco_provinces.'&cco_education='.request()->cco_education.'&cco_disease='.request()->cco_disease.'&cco_amphoe='.request()->cco_amphoe  }}{{isset($cco_rank) ? '&cco_rank='.$cco_rank : '' }}" class="text-black bg-yellow-400 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>

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

    let cco_province = document.querySelector("#cco_province");
        let url = "/cco/amphoes?province=" + cco_province.value;
        console.log( url );
        // if(soldier_province.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let cco_amphoe = document.querySelector("#cco_amphoe");
                cco_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ ครับ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe;
                    cco_amphoe.appendChild(option);
                }
                //QUERY AMPHOES
                showTambons();
            });
    }
// เมื่อเลือกจังหวัดเกิดการเปลี่ยนแปลง
    document.querySelector('#cco_province').addEventListener('change', (event) => {
        showAmphoes();
    });


</script>
