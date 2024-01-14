<x-app-layout>
    <x-slot name="header2">
        <h2 class="hidden text-xl font-semibold leading-tight text-white sm:block ">
            ข้อมูลนายสิบ
            <b class="float-end">จำนวนทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_nco,0)}}</button>  นาย</b>
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-white sm:block md:hidden lg:hidden xl:hidden">
         <b class="">จำนวนข้อมูลนายสิบทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_nco,0)}}</button>  นาย</b>
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
                 <form action="/nco/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class=" form-group">
                    </div>
                    <div class="input-group">
                        <button class="mx-1 text-white bg-purple-700 btn hover:bg-black " style="font-weight: 800;" >หน่วย</button>
                            <select class="form-control" name="nco_dep_id" id="nco_dep_id" >
                                <option value="">แสดงหน่วยทั้งหมด</option>
                                    @foreach ( $Department as $key=>$row )

                                    <option value="{{$row->dep_id}}" {{ $nco_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                                @endforeach
                        </select>
                            @php
                            $wanttoArr = array();
                            $wanttoArr=['บุพการีป่วยติดเตียง','ภรรยาคลอดบุตร','ไร้ที่อยู่อาศัย','ประสบภัยธรรมชาติ','อื่นๆ']
                            @endphp
                            <button class="mx-1 btn btn-success " style="font-weight: 800;">ความต้องการพิเศษ</button>
                            <select class="mr-2 form-control" id="nco_wantto" name="nco_wantto">
                                <option value="">-</option>
                                @foreach ( $wanttoArr as $key=>$row )
                            <option value="{{ $row}}" {{ $row== $nco_wantto ? 'selected' : ''}}>{{ $row}}</option>
                            @endforeach
                            </select>

                   </div>

                   <div class="my-1 input-group">
                    <button class="mx-1 btn btn-success " style="font-weight: 800;">จังหวัด</button>
                    <select class="form-control" name="nco_provinces" id="nco_provinces" >
                        <option value="">แสดงจังหวัดทั้งหมด</option>
                            @foreach ( $provinces as $key=>$item )
                            <option value="{{ $item->province }}" {{ $item->province==$nco_provinces ? 'selected' : ''}}>{{ $item->province }}</option>

                            @endforeach
                        </select>
                        <select id="nco_amphoe"  name="nco_amphoe"  class="mx-1 mr-2 form-control" >
                            <option value="">เลือกจังหวัดก่อน</option>
                            @foreach($amphoes as $item)
                            <option value="{{ $item->amphoe }}" {{ $item->amphoe==$nco_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="my-3 input-group">


                        <select class="mr-2 form-select-sm" name="nco_rank" id="nco_rank" >

                            <option value="">แสดงยศทั้งหมด</option>
                                @foreach ( $rank as $key=>$item )
                                <option value="{{ $item->rank_name }}" {{ $nco_rank == $item->rank_name ? 'selected' : ''}}>{{ $item->rank_name  }}</option>

                                @endforeach
                        </select>

                            {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}

                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/nco/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/nco/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
                        <a href="{{url('/ans/all/')}}" class="hidden mr-2 text-white btn btn-warning sm:block">เพิ่มสรุป</a>
                    </div>
                </div>
                </form>

                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                    <div class="col-md-12">
                        <div class="justify-items-center">
                            <button class="mx-1 text-white btn btn-primary" id = "btnSubmit"><i class="fa-solid fa-circle-info"></i>    แสดงสรุปข้อมูล</button>
                            <div id="showimg"  style="display:none" class="my-1">
                                @if ($ans)
                                @foreach ( $ans as $row )
                                {{-- <img src="{{isset($row->nco_image) ? asset($row->nco_image) : '/image/logo/'.{{$row}}.'JPG'}}" alt="" width="1000px" height="1000px" class="mx-auto my-2" > --}}
                                <img src="{{isset($row->ans_image) ? asset($row->ans_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->ans_image) ? asset($row->ans_image) : '' }}" alt="" width="1000px" height="1000px" class="mx-auto my-2" >
                                @endforeach
                                @endif

                        </div>

                            <table class="table my-1 table-striped">
                                <thead class="table-success">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพ</th>
                                    <th scope="col">ชื่อ-สกุล</th>
                                    <th scope="col" class="hidden lg:table-cell">เลขประจำตัวทหาร</th>
                                    {{-- <th style="width: 80px;" scope="col">กำเหนิด</th> --}}
                                    <th scope="col">หน่วย</th>
                                    <th scope="col" class="hidden sm:table-cell">อำเภอ</th>
                                    <th scope="col" class="hidden sm:table-cell">จังหวัด</th>
                                    <th scope="col" class="hidden lg:table-cell">แก้ไข</th>
                                    <th scope="col" class="hidden lg:table-cell">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $nco as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$nco->firstItem()+$loop->index}}</th>
                                    <td >
                                        <a href="{{url('/nco/edit/'.$row->nco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($nco_dep_id) ? '&nco_dep_id='.$nco_dep_id : '' }}{{isset($nco_provinces) ? '&nco_provinces='.$nco_provinces : '' }}{{isset($nco_education) ? '&nco_education='.$nco_education : '' }}{{isset($nco_disease) ? '&nco_disease='.$nco_disease : '' }}{{isset($nco_rank) ? '&nco_rank='.$nco_rank : '' }}{{isset($nco_amphoe) ? '&nco_amphoe='.$nco_amphoe : '' }}" >


                                        <img src="{{isset($row->nco_image) ? asset($row->nco_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->nco_image) ? asset($row->nco_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->nco_rank}}{{$row->nco_name}}</td>
                                    <td  class="hidden lg:table-cell">{{$row->nco_id }}</td>
                                    {{-- <td>{{$row->nco_intern}}</td> --}}
                                    <td>{{$row->nco_dep_name}}</td>
                                    <td class="hidden sm:table-cell">{{$row->nco_amphoe}}</td>
                                    <td class="hidden sm:table-cell">{{$row->nco_province}}</td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/nco/edit/'.$row->nco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($nco_dep_id) ? '&nco_dep_id='.$nco_dep_id : '' }}{{isset($nco_provinces) ? '&nco_provinces='.$nco_provinces : '' }}{{isset($nco_education) ? '&nco_education='.$nco_education : '' }}{{isset($nco_disease) ? '&nco_disease='.$nco_disease : '' }}{{isset($nco_rank) ? '&nco_rank='.$nco_rank : '' }}{{isset($nco_amphoe) ? '&nco_amphoe='.$nco_amphoe : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/nco/delete/'.$row->nco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($nco_dep_id) ? '&nco_dep_id='.$nco_dep_id : '' }}{{isset($nco_provinces) ? '&nco_provinces='.$nco_provinces : '' }}{{isset($nco_education) ? '&nco_education='.$nco_education : '' }}{{isset($nco_disease) ? '&nco_disease='.$nco_disease : '' }}{{isset($nco_rank) ? '&nco_rank='.$nco_rank : '' }}{{isset($nco_amphoe) ? '&nco_amphoe='.$nco_amphoe : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>


                            {{$nco->appends(['search' => isset($search) ? $search : '','nco_dep_id'=>isset($nco_dep_id) ?$nco_dep_id :'',"nco_provinces"=> isset($nco_provinces) ? $nco_provinces : '',"nco_rank"=> isset($nco_rank) ? $nco_rank : '',"nco_amphoe"=> isset($nco_amphoe) ? $nco_amphoe: '','nco_wantto'=>isset($nco_wantto) ?$nco_wantto :''])->links()}}
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

        let nco_province = document.querySelector("#nco_provinces");
            let url = "/nco/amphoes?province=" + nco_provinces.value;
            console.log( url );
            // if(nco_province.value == "") return;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    //UPDATE SELECT OPTION
                    let nco_amphoe = document.querySelector("#nco_amphoe");
                    nco_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
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
        document.querySelector('#nco_provinces').addEventListener('change', (event) => {
            showAmphoes();
        });
        document.querySelector('#nco_provinces').addEventListener('click', (event) => {
            showAmphoes();
        });

        // $("#btnSubmit").click(function(){
        //     let $btnSubmit = $(this);
        //     $("#showimg").toggle();
        //     $("#btnSubmit").text('ปิดข้อมูล') ;
        //     });

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
