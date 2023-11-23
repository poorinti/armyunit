<x-app-layout>
    <x-slot name="header5">
        <h2 class="text-xl font-semibold leading-tight text-white">
             ข้อมูลผู้รับสิทธิ์
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
 @php   $url='/pay/all?';
 $url .=isset($page)? 'page='.$page :'';
 $url .=isset($search) ? '&search='.$search : '' ;
 $url .=isset($pay_dep_id) ? '&pay_dep_id='.$pay_dep_id : '' ;
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
                            <a href="{{ '/pay/all?page='.request()->page.'&search='.request()->search.'&pay_dep_id='.request()->pay_dep_id.'&pay_provinces='.request()->pay_provinces.'&pay_education='.request()->pay_education.'&pay_disease='.request()->pay_disease  }}{{isset($pay_rank) ? '&pay_rank='.$pay_rank : '' }}{{isset($pay_paychk) ? '&pay_paychk='.$pay_paychk: '' }}" class="text-black bg-purple-700 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>
                            <div class="bg-slate-200 card-header ">รูปประจำตัว</div>
                            <div class="justify-center mx-auto text-center card-body ">
                                <img src="{{isset($pay->pay_image) ? asset($pay->pay_image) : '/image/logo/logo1.png'}}" alt="{{ isset($pay->pay_image) ? asset($pay->pay_image) : '' }}" alt="imageshow" width="200px" height="200px">
                                {{-- <label for="imageshow">{{$soldier->soldier_name }}</label> --}}
                            </div>

                        </div>
                        {{-- <div class="my-4 card ">
                            <div class="text-white bg-orange-600 card-header">ข้อมูลการรับเงิน</div>
                                <div class=" card-body bg-slate-100">
                                         <!--เบอร์-->
                                         @php
                                                $i=0;
                                                $depArr=Array();
                                            foreach ( $payout as $key => $val) {
                                                    $depArr[$val->payout_id]= $val->payout_name;
                                                }
                                     @endphp
                                         @foreach ( $payout as $row )

                                         <div class="my-2 form-group">
                                            <label for="pay_payuot">{{$depArr[$row->payout_id]}} </label>
                                            <input type="text" class="form-control" name="pay_payuot" placeholder="" value ="{{isset($PayoutArr[$row->payout_id]) ? $PayoutArr[$row->payout_id] : 'ยังไม่ได้รับ'}}" >
                                        </div>
                                        @error('pay_payuot')
                                        <div class="my-2">
                                            <span class="text-red-600 text">{{$message}}</span>
                                        </div>
                                        @enderror
                                        @endforeach
                                </div>
                        </div> --}}
                    </div>

                    <div class="col-md-8">
                        <div class=" card">
                            <div class="card">
                                <div class="bg-slate-200 card-header">แก้ไขข้อมูลประจำตัว</div>
                                     <div class="card-body">
                                        <form action="{{url('/pay/update/'.$pay->pay_id )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="my-3 form-group">
                                                <!--  ภาพเก่า -->
                                                <br>
                                                <input type="hidden" name="old_image" value="{{$pay->pay_image}}">
                                                <!-- ไอดีเก่า -->
                                                <input type="hidden" name="pay_id" value="{{$pay->pay_id}}">

                                                <!-- เพจ -->
                                                <input type="hidden" name="page" value="{{$page}}">

                                                <input type="hidden" name="pay_dep_id" value="{{$pay_dep_id}}">
                                                <input type="hidden" name="search" value="{{$search}}">
                                                <input type="hidden" name="pay_index" value="{{$pay->pay_index}}">
                                                <input type="hidden" name="pay_rank_index" value="{{$pay->pay_rank_index}}">
                                                <input type="hidden" name="pay_provinces" value="{{isset($pay_provinces) ? $pay_provinces :'' }}">


                                                <div class="form-group">
                                                </div>
                                                <label for="pay_image">อัพโหลดภาพโปรไฟล์</label>
                                                <input type="file" class="form-control" name="pay_image" value="{{$pay->pay_image}}">
                                                </div>
                                                @error('pay_image')
                                                        <div class="my-2">
                                                            <span class="text-danger">{{$message}}</span>
                                                        </div>
                                                    @enderror
                                                 <!--ยศ -->
                                                 <div class="my-2 form-group">
                                                    <label for="pay_rank">ยศ/คำนำหน้า</label>
                                                     <select class="form-control" name="pay_rank" id="pay_rank" required>
                                                     @foreach ( $rank as $key=>$row )
                                                     <option value="{{$row->rank_name}}" {{ $row->rank_name==$pay->pay_rank ? 'selected' : ''}}>{{$row->rank_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @error('pay_rank')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--ชื่อ -->
                                                <label for="pay_name">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" name="pay_name" value="{{$pay->pay_name}}" >
                                                @error('pay_name')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--เลขประชาชน -->
                                                <div class="my-2 form-group">
                                                    <label for="pay_id">เลขบัตรประชนผู้พิการ</label>
                                                    <input type="text" class="form-control" name="pay_id"  value =" {{$pay->pay_id}}" placeholder="ตัวอย่าง :เลข 13 หลัก" disabled>
                                                </div>
                                                @error('pay_id')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                @php
                                                $payArr = array();
                                                $payArr=['พิการทางการมองเห็น','พิการทางการได้ยินหรือสื่อความหมาย','พิการทางการเคลื่อนไหวหรือทางร่างกาย','พิการทางจิตใจ หรือพฤติกรรม','พิการทางการสติปัญญา','พิการทางการเรียนรู้','พิการทางออทิสติก','อื่นๆ']
                                                @endphp

                                                <!--ลักษณะการพิการ -->
                                               <div class="my-2 form-group">
                                                  <label for="pay_defective" class="form-label">ลักษณะการพิการ</label>
                                                  <select class="form-select" id="pay_defective" name="pay_defective">
                                                    {{-- <option value ="{{isset($pay->pay_index) ? $pay->pay_index : 0 }}" >เข้าร่วมทั้งสอง</option> --}}
                                                    @foreach (  $payArr as $row )
                                                  <option value="{{$row}}"{{ $pay->pay_defective == $row ? 'selected' : ''}}>{{$row}}</option>
                                                  @endforeach
                                                  </select>
                                              </div>
                                              @error('pay_index')
                                              <div class="my-2">
                                                <span class="text-red-600 text">{{$message}}</span>
                                              </div>
                                               @enderror
                                                <!--สาเหตุความพิการเกิดจาก-->
                                                <div class="my-2 form-group">
                                                    <label for="pay_defective_about">สาเหตุความพิการเกิดจาก</label>
                                                    <input type="text" class="form-control" name="pay_defective_about" placeholder="" value ="{{isset($pay->pay_defective_about) ? $pay->pay_defective_about : ''}}" >
                                                </div>
                                                @error('pay_defective_about')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                @php
                                                $payArr = array();
                                                $payArr=['เงินสงเคราะห์บุตร','เงินสงเคราะห์บุพการี','ทุนยังชีพรายปีบุตร','ทุนยังชีพรายปีคู่สมรส']
                                                @endphp
                                                <!--เคยเข้าร่วม -->
                                               <div class="my-2 form-group">
                                                  <label for="pay_reward" class="form-label">ประเภทสิทธิ์ที่ได้รับ</label>
                                                  <select class="form-select" id="pay_reward" name="pay_reward">
                                                    <option value="">กรุณาเลือก</option>
                                                    @foreach (  $payArr as $row )
                                                  <option value="{{$row}}"{{ $pay->pay_reward == $row ? 'selected' : ''}}>{{$row}}</option>
                                                  @endforeach
                                                  </select>
                                              </div>
                                              @error('pay_reward')
                                              <div class="my-2">
                                                <span class="text-red-600 text">{{$message}}</span>
                                              </div>
                                               @enderror

                                                {{-- <!--สิทธิอื่นๆที่รับ-->
                                                <div class="my-2 form-group">
                                                    <label for="pay_reward">สิทธิอื่นๆที่รับ</label>
                                                    <input type="text" class="form-control" name="pay_reward" placeholder="" value ="{{isset($pay->pay_reward) ? $pay->pay_reward : ''}}" >
                                                </div>
                                                @error('pay_reward')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror --}}

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
                                                    <label for="pay_address">ภูมิลำเนา</label>
                                                    <input type="text" class="form-control" name="pay_address"placeholder="ตัวอย่าง : 118 หมู่ 7 ต.โพธิ์สัย อ.ศรัสมเด็จ" value ="{{isset($pay->pay_address) ? $pay->pay_address : ''}}" >
                                                </div>
                                                @error('pay_address')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <div class="my-2 form-group">
                                                    <label for="pay_province">จังหวัด</label>
                                                    <select id="pay_province" name="pay_province" class="form-select"  >
                                                        <option value="">กรุณาเลือกจังหวัด</option>
                                                        @foreach($provinces as $item)
                                                        <option value="{{ $item->province }}" {{ $item->province==$pay->pay_province ? 'selected' : ''}}>{{ $item->province }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="my-2 form-group">
                                                    <label for="pay_amphoe">เขต/อำเภอ</label>
                                                    <select id="pay_amphoe"  name="pay_amphoe"  class="form-select" >
                                                        <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                                        @foreach($amphoes as $item)
                                                        <option value="{{ $item->amphoe }}" {{ $item->amphoe==$pay->pay_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
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
                                                    <label for="pay_phone">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="pay_phone" value ="{{isset($pay->pay_phone) ? $pay->pay_phone : ''}}" >
                                                </div>
                                                @error('pay_phone')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror
                                                <!--หมายเหตุ-->
                                                <div class="my-2 form-group">
                                                    <label for="pay_about">หมายเหตุ</label>
                                                    <input type="text" class="form-control" name="pay_about" value ="{{isset($pay->pay_about) ? $pay->pay_about: ''}}" >
                                                </div>
                                                @error('pay_about')
                                                <div class="my-2">
                                                    <span class="text-red-600 text">{{$message}}</span>
                                                </div>
                                                @enderror

                                                <div class="my-4 card ">
                                                    <div class="text-white bg-slate-500 card-header">ข้อมูลผู้เกี่ยวข้อง</div>
                                                        <div class=" card-body bg-slate-100">
                                                            @php
                                                            $payArr = array();
                                                            $payArr=['คู่สมรส','บุตร','บิดา','มารดา','ปู่','ย่า','ตา','ยาย','พี่','น้อง','อื่นๆ']
                                                            @endphp
                                                            <!--ความเกี่ยวข้องกับกำลังพล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="pay_parent_about" class="form-label">ความเกี่ยวข้องกับกำลังพล</label>
                                                                    <select class="form-select" id="pay_parent_about" name="pay_parent_about">
                                                                        <option value="">กรุณาเลือก</option>
                                                                        @foreach (  $payArr as $row )
                                                                    <option value="{{$row}}"{{ $pay->pay_parent_about == $row ? 'selected' : ''}}>{{$row}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('pay_index')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror

                                                            <!--ยศ-->
                                                                <div class="my-2 form-group">
                                                                    <label for="pay_parent_rank">ยศ/คำนำหน้า</label>
                                                                    <select class="form-control" name="pay_parent_rank" id="pay_parent_rank" required>
                                                                    @foreach ( $rank as $key=>$row )
                                                                    <option value="{{$row->rank_name}}"{{ $row->rank_name==$pay->pay_parent_rank ? 'selected' : ''}}>{{$row->rank_name}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('pay_parent_rank')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                {{-- <!--เลขบัตรประชานผู้เกี่ยวข้อง-->
                                                                <div class="my-2 form-group">
                                                                    <label for="pay_parent_id">เลขบัตรประชน</label>
                                                                    <input type="text" class="form-control" name="pay_parent_id" placeholder=" " value ="{{isset($pay->pay_parent_id) ? $pay->pay_parent_id : ''}}" >
                                                                </div>
                                                                @error('pay_parent_id')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror --}}
                                                              <!--ชื่อ-สกุล-->
                                                                <div class="my-2 form-group">
                                                                    <label for="pay_parent_name">ชื่อ-สกุล</label>
                                                                    <input type="text" class="form-control" name="pay_parent_name" placeholder="" value ="{{isset($pay->pay_parent_name) ? $pay->pay_parent_name : ''}}" >
                                                                </div>
                                                                @error('pay_parent_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                <!--หน่วย-->
                                                                <div class="my-2 form-group">
                                                                    <label for="pay_dep_name">หน่วย</label>
                                                                    <input type="text" class="form-control" name="pay_dep_name" placeholder="" value ="{{isset($pay->pay_dep_name) ? $pay->pay_dep_name : ''}}" >
                                                                </div>
                                                                @error('pay_dap_name')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror
                                                                 <!--เบอร์-->
                                                                 <div class="my-2 form-group">
                                                                    <label for="pay_phone">เบอร์</label>
                                                                    <input type="text" class="form-control" name="pay_phone" placeholder="" value ="{{isset($pay->pay_phone) ? $pay->pay_phone : ''}}" >
                                                                </div>
                                                                @error('pay_phone')
                                                                <div class="my-2">
                                                                    <span class="text-red-600 text">{{$message}}</span>
                                                                </div>
                                                                @enderror

                                                        </div>
                                                    </div>
                                                    <div class="my-4 card ">
                                                        <div class="text-white bg-orange-600 card-header">ข้อมูลการรับเงิน</div>
                                                            <div class=" card-body bg-slate-100">
                                                                     <!--เบอร์-->
                                                                     <div class="my-2 form-group">
                                                                        <label for="pay_payuot">งวดที่ 20 (ห้วง ม.ค. - มิ.ย. 66)</label>
                                                                        <input type="text" class="form-control" name="pay_payuot" placeholder="" value ="{{isset($pay->pay_payuot) ? $pay->pay_payuot : ''}}" >
                                                                    </div>
                                                                    @error('pay_payuot')
                                                                    <div class="my-2">
                                                                        <span class="text-red-600 text">{{$message}}</span>
                                                                    </div>
                                                                    @enderror
                                                                     <!--เบอร์-->
                                                                     <div class="my-2 form-group">
                                                                        <label for="pay_phone">งวดที่ 21 (ห้วง ก.ค. - ธ.ค. 66)</label>
                                                                        <input type="text" class="form-control" name="pay_phone" placeholder="" value ="{{isset($pay->pay_phone) ? $pay->pay_phone : ''}}" >
                                                                    </div>
                                                                    @error('pay_phone')
                                                                    <div class="my-2">
                                                                        <span class="text-red-600 text">{{$message}}</span>
                                                                    </div>
                                                                    @enderror

                                                            </div>
                                                    </div>

                                            <br>
                                             <a href="{{ '/pay/all?page='.request()->page.'&search='.request()->search.'&pay_dep_id='.request()->pay_dep_id.'&pay_provinces='.request()->pay_provinces.'&pay_education='.request()->pay_education.'&pay_disease='.request()->pay_disease  }}{{isset($pay_rank) ? '&pay_rank='.$pay_rank : '' }}" class="text-black bg-yellow-400 btn btn-primary"> <i class="fa fa-arrow-left"></i>      กลับ</a>

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

    let nco_province = document.querySelector("#pay_province");
        let url = "/pay/amphoes?province=" + pay_province.value;
        console.log( url );
        // if(soldier_province.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let pay_amphoe = document.querySelector("#pay_amphoe");
                pay_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ ครับ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe;
                    pay_amphoe.appendChild(option);
                }
                //QUERY AMPHOES
                showTambons();
            });
    }
// เมื่อเลือกจังหวัดเกิดการเปลี่ยนแปลง
    document.querySelector('#pay_province').addEventListener('change', (event) => {
        showAmphoes();
    });


</script>

