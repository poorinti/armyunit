<x-app-layout>
    <x-slot name="header">
        <h2 class="hidden text-xl font-semibold leading-tight text-gray-800 sm:block ">
            ข้อมูลพลทหาร
            <b class="float-end">ข้อมูลพลทหารทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b>
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:block md:hidden lg:hidden xl:hidden">
         <b class="">ข้อมูลพลทหารทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b>
        </h2>

</x-slot>


            {{-- @foreach ( $Department as $key=>$row )


            <div class="col-auto my-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Special {{$row->total}}</h5>
                      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                      <a href="#" class="btn btn-primary">{{$row->department_name}} </a>
                    </div>
                  </div>
            </div>

        @endforeach --}}

    <div class="py-4">
        <div class="mx-auto max-w-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <form action="/soldier/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class=" form-group">
                    </div>
                    <div class="input-group">
                        <button class="mx-1 text-white btn btn-success " style="font-weight: 800;" >หน่วย</button>
                            <select class="mr-2 form-control" name="soldier_dep_id" id="soldier_dep_id" >
                                <option value="">ทั้งหมด</option>
                                    @foreach ( $Department as $key=>$row )
                                    <option value="{{$row->dep_id}}" {{ $soldier_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                                @endforeach
                        </select>
                        <button class="text-white bg-purple-700 btn hover:bg-black" style="font-weight: 800;" >จังหวัด</button>
                            <select class="mx-1 mr-2 form-control" name="soldier_provinces" id="soldier_provinces" >
                                <option value="">ทั้งหมด</option>
                                @foreach ( $provinces as $key=>$item )
                                <option value="{{ $item->province }}" {{ $item->province==$soldier_provinces ? 'selected' : ''}}>{{ $item->province }}</option>
                                @endforeach
                            </select>
                            <select id="soldier_amphoe"  name="soldier_amphoe"  class="mr-2 form-control" >
                                    <option value="">เลือกจังหวัดก่อน</option>
                                    @foreach($amphoes as $item)
                                    <option value="{{ $item->amphoe }}" {{ $item->amphoe==$soldier_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                                    @endforeach
                            </select>
                   </div>
                            @php
                            $educationArr = array();
                            $educationArr=['ประถม','ม.ต้น','ม.ปลาย','ปวช','ปวส.','ป.ตรี','ป.โท','ป.เอก',]
                            @endphp
                   <div class="my-2 input-group">
                        <button class="mx-1 text-white bg-purple-700 btn hover:bg-black" style="font-weight: 800;" >วุฒิ</button>
                        <select class="mr-2 form-control" name="soldier_education" id="soldier_education" >
                            <option value="">-</option>
                                @foreach ( $educationArr as $key=>$row )
                                <option value="{{$row}}" {{ $soldier_education ==$row ? 'selected' :'' }}>{{$row}}</option>
                            @endforeach
                        </select>
                        @php
                        $diseaseArr = array();
                        $diseaseArr=['ไม่มี','ซึมเศร้า','จิตเวช','ภูมิแพ้','หอบหืด','หัวใจ','ภูมิแพ้','กระดูก/ดามเหล็ก','เคยเป็นลมร้อนมาก่อน','ตับ','ไว้รัสตับอักเสบ B','ลมชัก','เบาหวาน','ความดัน','อื่นๆ']
                        @endphp
                        <button class="text-white bg-purple-700 btn hover:bg-black" style="font-weight: 800;" >โรค</button>
                        <select class="mx-1 mr-2 form-control" name="soldier_disease" id="soldier_disease" >
                        <option value="">-</option>
                            @foreach ( $diseaseArr as $key=>$item )
                            <option value="{{ $item }}" {{ $item == $soldier_disease ? 'selected' : ''}}>{{ $item }}</option>

                            @endforeach
                        </select>
                    </div>
                   <div class="my-1 input-group">
                        @php
                        $diseaseArr = array();
                        $diseaseArr=['มี','ไม่มี']
                        @endphp
                        <button class="mx-1 text-white bg-purple-700 btn hover:bg-black" style="font-weight: 800;" >ประสงค์สอบนนส.</button>
                        <select class="mr-2 form-control" name="soldier_want_nco" id="soldier_want_nco" >

                        <option value="">-</option>
                            @foreach ( $diseaseArr as $key=>$item )
                            <option value="{{ $item }}" {{ $item == $soldier_want_nco ? 'selected' : ''}}>{{ $item }}</option>
                            @endforeach
                        </select>

                        @php
                        $wanttoArr = array();
                        $wanttoArr=['บุพการีป่วยติดเตียง','ภรรยาคลอดบุตร','ไร้ที่อยู่อาศัย','ประสบภัยธรรมชาติ','อื่นๆ']
                        @endphp
                        <button class="text-white bg-purple-700 btn hover:bg-black" style="font-weight: 800;">ความต้องการพิเศษ</button>
                        <select class="mx-1 mr-2 form-control" id="soldier_wantto" name="soldier_wantto">
                            <option value="">-</option>
                            @foreach ( $wanttoArr as $key=>$row )
                        <option value="{{ $row}}" {{ $row== $soldier_wantto ? 'selected' : ''}}>{{ $row}}</option>
                        @endforeach
                        </select>
                    </div>


                    <div class="my-3 input-group ">
                         {{-- {{dd($search);}} --}}
                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/soldier/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/soldier/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
                        <a href="{{url('/ans/all/')}}" class="hidden mr-2 text-white btn btn-warning sm:block">เพิ่มสรุป</a>
                    </div>
                </div>
                </form>

                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                    <div class="col-md-12">
                        <div class="">
                            <button class="mx-1 text-white btn btn-primary" id = "btnSubmit"><i class="fa-solid fa-circle-info"></i>    แสดงสรุปข้อมูล </button>

                            <div id="showimg"  style="display:none" class="my-1">
                                    @if ($ans)
                                    @foreach ( $ans as $row )
                                    {{-- <img src="{{isset($row->nco_image) ? asset($row->nco_image) : '/image/logo/'.{{$row}}.'JPG'}}" alt="" width="1000px" height="1000px" class="mx-auto my-2" > --}}
                                    <img src="{{isset($row->ans_image) ? asset($row->ans_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->ans_image) ? asset($row->ans_image) : '' }}" alt="" width="1000px" height="1000px" class="mx-auto my-2" >
                                    @endforeach
                                    @endif

                            </div>


                            <table class="table my-1 table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพ</th>
                                    <th scope="col">ชื่อ-สกุล</th>
                                    <th scope="col" class="hidden lg:table-cell ">ความต้องการพิเศษ</th>
                                    <th style="width: 80px;" scope="col">ผลัด/ปี</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col" class="hidden sm:table-cell ">อำเภอ</th>
                                    <th scope="col" class="hidden sm:table-cell ">จังหวัด</th>
                                    <th scope="col" class="hidden lg:table-cell">แก้ไข</th>
                                    <th scope="col" class="hidden lg:table-cell">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $soldier as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$soldier->firstItem()+$loop->index}}</th>
                                    <td >
                                        <a href="{{url('/soldier/edit/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' }}{{isset($soldier_provinces) ? '&soldier_provinces='.$soldier_provinces : '' }}{{isset($soldier_education) ? '&soldier_education='.$soldier_education : '' }}{{isset($soldier_disease) ? '&soldier_disease='.$soldier_disease : '' }}{{isset($soldier_amphoe) ? '&soldier_amphoe='.$soldier_amphoe : '' }}{{isset($soldier_wantto) ? '&soldier_wantto='.$soldier_wantto : '' }}{{isset($soldier_want_nco ) ? '&soldier_want_nco='.$soldier_want_nco  : '' }}" >

                                        {{-- isset จากฐานข้อมูล ถ้าไม่มีภาพ ให้ดึงเอา โลโก้มา --}}
                                        <img src="{{isset($row->soldier_image) ? asset($row->soldier_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->soldier_image) ? asset($row->soldier_image) : '' }}" width="100px" height="100px" class="rounded" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->soldier_name}}</td>
                                    <td  class="hidden lg:table-cell">{{$row->soldier_wantto }}</td>
                                    <td>{{$row->soldier_intern}}</td>
                                    <td>{{$row->soldiers_dep_name}}</td>
                                    <td class="hidden sm:table-cell">{{$row->soldier_amphoe}}</td>
                                    <td class="hidden sm:table-cell">{{$row->soldier_province}}</td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/soldier/edit/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' }}{{isset($soldier_provinces) ? '&soldier_provinces='.$soldier_provinces : '' }}{{isset($soldier_education) ? '&soldier_education='.$soldier_education : '' }}{{isset($soldier_disease) ? '&soldier_disease='.$soldier_disease : '' }}{{isset($soldier_amphoe) ? '&soldier_amphoe='.$soldier_amphoe : '' }}{{isset($soldier_wantto) ? '&soldier_wantto='.$soldier_wantto : '' }}{{isset($soldier_want_nco) ? '&soldier_want_nco='.$soldier_want_nco : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/soldier/delete/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' }}{{isset($soldier_provinces) ? '&soldier_provinces='.$soldier_provinces : '' }}{{isset($soldier_education) ? '&soldier_education='.$soldier_education : '' }}{{isset($soldier_disease) ? '&soldier_disease='.$soldier_disease : '' }}{{isset($soldier_amphoe) ? '&soldier_amphoe='.$soldier_amphoe : '' }}{{isset($soldier_wantto) ? '&soldier_wantto='.$soldier_wantto : '' }}{{isset($soldier_want_nco) ? '&soldier_want_nco='.$soldier_want_nco : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>

                            <br>

                            {{$soldier->appends(['search' => isset($search) ? $search : '','soldier_dep_id'=>isset($soldier_dep_id) ?$soldier_dep_id :'' ,"soldier_provinces"=> isset($soldier_provinces) ? $soldier_provinces : '',"soldier_education"=> isset($soldier_education) ? $soldier_education : '',"soldier_disease"=> isset($soldier_disease) ? $soldier_disease : '',"soldier_amphoe"=> isset($soldier_amphoe) ? $soldier_amphoe: '',"soldier_wantto"=> isset($soldier_wantto) ? $soldier_wantto: '',"soldier_want_nco"=> isset($soldier_want_nco) ? $soldier_want_nco: ''])->links()}}


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

        let soldier_province = document.querySelector("#soldier_provinces");
            let url = "/soldier/amphoes?province=" + soldier_provinces.value;
            console.log( url );
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
        document.querySelector('#soldier_provinces').addEventListener('change', (event) => {
            showAmphoes();
        });
        document.querySelector('#soldier_provinces').addEventListener('click', (event) => {
            showAmphoes();
        });
        $("#btnSubmit").click(function(){
            var $this = $(this);
                $this.toggleClass('btnSubmit');
                $("#showimg").toggle();
                if($this.hasClass('btnSubmit')){

                    // $this.text('<i class="fa-solid fa-circle-info"></i>แสดงสรุปข้อมูล');
                    $this.html('<i class="fa-solid fa-circle-info"></i> ปิดสรุปข้อมูล');

                } else {

                    $this.html('<i class="fa-solid fa-circle-info"></i>แสดงสรุปข้อมูล');
                }
            });
            $("#btnSubmit2").click(function(){
            var $this = $(this);
                $this.toggleClass('btnSubmit2');
                $("#showimg2").toggle();
                if($this.hasClass('btnSubmit2')){

                    // $this.text('<i class="fa-solid fa-circle-info"></i>แสดงสรุปข้อมูล');
                    $this.html('<i class="fa-solid fa-circle-info"></i> ปิดสรุปข้อมูล โรคประจำตัว');

                } else {

                    $this.html('<i class="fa-solid fa-circle-info"></i>แสดงสรุปข้อมูล โรคประจำตัว.');
                }
            });


</script>

