<x-app-layout>
    <x-slot name="header4">
        <h2 class="hidden text-xl font-semibold leading-tight text-white sm:block ">
            ข้อมูล {{$law_lawchk !=''? $law_lawchk :'ม.35'}}
            <b class="float-end">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_law,0)}}</button>  นาย</b>
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-white sm:block md:hidden lg:hidden xl:hidden">
            ข้อมูล {{$law_lawchk !=''? $law_lawchk :'ม.35'}}
         {{-- <b class="">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b> --}}
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
                 <form action="/law/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class=" form-group">
                    </div>
                    <div class="input-group">
                        <button class="mx-1 text-white bg-purple-700 btn hover:bg-black " style="font-weight: 800;" >หน่วย</button>
                            <select class="form-control" name="law_dep_id" id="law_dep_id" >
                                <option value="">แสดงหน่วยทั้งหมด</option>
                                    @foreach ( $Department as $key=>$row )

                                    <option value="{{$row->dep_id}}" {{ $law_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                                @endforeach
                        </select>
                        <button class="mx-1 text-white bg-purple-700 btn hover:bg-black" style="font-weight: 800;" >จังหวัด</button>
                        <select class="form-control " name="law_provinces" id="law_provinces" >
                            <option value="">แสดงจังหวัดทั้งหมด</option>
                                @foreach ( $provinces as $key=>$item )
                                <option value="{{ $item->province }}" {{ $item->province==$law_provinces ? 'selected' : ''}}>{{ $item->province }}</option>

                                @endforeach
                            </select>
                            <select id="law_amphoe"  name="law_amphoe"  class="mx-1 mr-2 form-control" >
                                <option value="">เลือกจังหวัดก่อน</option>
                                @foreach($amphoes as $item)
                                <option value="{{ $item->amphoe }}" {{ $item->amphoe==$law_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                                @endforeach
                            </select>

                   </div>
                            {{-- @php
                            $educationArr = array();
                            $educationArr=['ประถม','ม.ต้น','ม.ปลาย','ปวช','ปวส.','ป.ตรี','ป.โท','ป.เอก',]
                            @endphp
                   <div class="input-group">
                        <select class="form-control" name="nco_education" id="nco_education" >
                            <option value="">แสดงวุฒิทั้งหมด</option>
                                @foreach ( $educationArr as $key=>$row )

                                <option value="{{$row}}" {{ $nco_education ==$row ? 'selected' :'' }}>{{$row}}</option>
                            @endforeach
                        </select>
                        @php
                        $diseaseArr = array();
                        $diseaseArr=['ไม่มี','ซึมเศร้า','จิตเวช','ภูมิแพ้','หอบหืด','หัวใจ','ภูมิแพ้','กระดูก/ดามเหล็ก','เคยเป็นลมร้อนมาก่อน','ตับ','ไว้รัสตับอักเสบ B','ลมชัก','อื่นๆ']
                        @endphp

                        <select class="form-control" name="nco_disease" id="nco_disease" >
                        <option value="">แสดงอาการป่วยทั้งหมด</option>
                            @foreach ( $diseaseArr as $key=>$item )
                            <option value="{{ $item }}" {{ $item == $nco_disease ? 'selected' : ''}}>{{ $item }}</option>

                            @endforeach
                        </select>

                    </div> --}}


                    <div class="my-3 input-group">
                        @php
                        $lawArr = array();
                        $lawArr=['ม.35(3)','ม.35(7)']
                        @endphp

                        <select class="mr-2 form-select-sm" name="law_lawchk" id="law_lawchk" >

                            <option value="">ม.35</option>
                                @foreach ( $lawArr as $key=>$item )
                                <option value="{{ $item }}" {{ $item == $law_lawchk ? 'selected' : ''}}>{{ $item }}</option>

                                @endforeach
                        </select>


                        <select class="mr-2 form-select-sm" name="law_rank" id="law_rank" >

                            <option value="">คำนำหน้า</option>
                                @foreach ( $rank as $key=>$item )
                            <option value="{{ $item->rank_name }}" {{ $law_rank == $item->rank_name ? 'selected' : ''}}>{{ $item->rank_name  }}</option>

                                @endforeach
                        </select>

                            {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}

                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/law/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/law/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
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

                            <table class="table table-striped">
                                <thead class="table-primary">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพ</th>
                                    <th scope="col">ชื่อ-สกุล</th>
                                    <th scope="col" class="hidden lg:table-cell">เลขบัตรประชาชน</th>
                                    <th style="width: 120px;" scope="col">เกี่ยวข้องเป็น</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col" class="hidden sm:table-cell">ภูมิลำเนา</th>
                                    <th scope="col" class="hidden lg:table-cell">แก้ไข</th>
                                    <th scope="col" class="hidden lg:table-cell">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $law as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$law->firstItem()+$loop->index}}</th>
                                    <td >
                                        <a href="{{url('/law/edit/'.$row->law_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($law_dep_id) ? '&law_dep_id='.$law_dep_id : '' }}{{isset($law_provinces) ? '&law_provinces='.$law_provinces : '' }}{{isset($law_education) ? '&law_education='.$law_education : '' }}{{isset($law_disease) ? '&law_disease='.$law_disease : '' }}{{isset($law_lawchk) ? '&law_lawchk='.$law_lawchk : '' }}{{isset($law_rank) ? '&law_rank='.$law_rank : '' }}{{isset($law_amphoe) ? '&law_amphoe='.$law_amphoe : '' }}" >


                                        <img src="{{isset($row->law_image) ? asset($row->law_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->law_image) ? asset($row->law_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->law_rank}}{{$row->law_name}}</td>
                                    <td  class="hidden lg:table-cell">{{$row->law_id }}</td>
                                    <td>{{$row->law_parent_about}}</td>
                                    <td>{{$row->law_dep_name}}</td>
                                    <td class="hidden sm:table-cell">{{$row->law_province}}</td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/law/edit/'.$row->law_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($law_dep_id) ? '&law_dep_id='.$law_dep_id : '' }}{{isset($law_provinces) ? '&law_provinces='.$law_provinces : '' }}{{isset($law_education) ? '&law_education='.$law_education : '' }}{{isset($law_disease) ? '&law_disease='.$law_disease : '' }}{{isset($law_lawchk) ? '&law_lawchk='.$law_lawchk : '' }}{{isset($law_rank) ? '&law_rank='.$law_rank : '' }}{{isset($law_amphoe) ? '&law_amphoe='.$law_amphoe : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/law/delete/'.$row->law_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($law_dep_id) ? '&law_dep_id='.$law_dep_id : '' }}{{isset($law_provinces) ? '&law_provinces='.$law_provinces : '' }}{{isset($law_education) ? '&law_education='.$law_education : '' }}{{isset($law_disease) ? '&law_disease='.$law_disease : '' }}{{isset($law_lawchk) ? '&law_lawchk='.$law_lawchk : '' }}{{isset($law_rank) ? '&law_rank='.$law_rank : '' }}{{isset($law_amphoe) ? '&law_amphoe='.$law_amphoe : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>

                            {{$law->appends(['search' => isset($search) ? $search : '','law_dep_id'=>isset($law_dep_id) ?$law_dep_id :'',"law_provinces"=> isset($law_provinces) ? $law_provinces : '',"law_rank"=> isset($law_rank) ? $law_rank : '',"law_lawchk"=> isset($law_lawchk) ? $law_lawchk : '',"law_amphoe"=> isset($law_amphoe) ? $law_amphoe: ''])->links()}}

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

        let nco_province = document.querySelector("#law_provinces");
            let url = "/law/amphoes?province=" + law_provinces.value;
            console.log( url );
            // if(law_province.value == "") return;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    //UPDATE SELECT OPTION
                    let law_amphoe = document.querySelector("#law_amphoe");
                    law_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
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
        document.querySelector('#law_provinces').addEventListener('change', (event) => {
            showAmphoes();
        });
        document.querySelector('#law_provinces').addEventListener('click', (event) => {
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
</script>

