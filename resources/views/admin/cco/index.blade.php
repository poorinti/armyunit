<x-app-layout>
    <x-slot name="header3">
        <h2 class="hidden text-xl font-semibold leading-tight text-white sm:block ">
            ข้อมูลนายทหาร
            <b class="float-end">จำนวนทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_cco,0)}}</button>  นาย</b>
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-white sm:block md:hidden lg:hidden xl:hidden">
         <b class="">จำนวนข้อมูลนายทหารทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_cco,0)}}</button>  นาย</b>
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
                 <form action="/cco/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class=" form-group">
                    </div>
                    <div class="input-group">
                        <button class="mx-1 text-white bg-purple-700 btn hover:bg-black " style="font-weight: 800;" >หน่วย</button>
                            <select class="form-control" name="cco_dep_id" id="cco_dep_id" >
                                <option value="">แสดงหน่วยทั้งหมด</option>
                                    @foreach ( $Department as $key=>$row )

                                    <option value="{{$row->dep_id}}" {{ $cco_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                                @endforeach
                        </select>
                        @php
                        $wanttoArr = array();
                        $wanttoArr=['บุพการีป่วยติดเตียง','ภรรยาคลอดบุตร','ไร้ที่อยู่อาศัย','ประสบภัยธรรมชาติ','อื่นๆ']
                        @endphp
                        <button class="mx-1 btn btn-success " style="font-weight: 800;">ความต้องการพิเศษ</button>
                        <select class="mr-2 form-control" id="cco_wantto" name="cco_wantto">
                            <option value="">-</option>
                            @foreach ( $wanttoArr as $key=>$row )
                        <option value="{{ $row}}" {{ $row== $cco_wantto ? 'selected' : ''}}>{{ $row}}</option>
                        @endforeach
                        </select>
                   </div>

                   <div class="my-2 input-group">
                    <button class="mx-1 btn btn-success " style="font-weight: 800;">จังหวัด</button>
                    <select class="form-control" name="cco_provinces" id="cco_provinces" >
                        <option value="">แสดงจังหวัดทั้งหมด</option>
                            @foreach ( $provinces as $key=>$item )
                            <option value="{{ $item->province }}" {{ $item->province==$cco_provinces ? 'selected' : ''}}>{{ $item->province }}</option>

                            @endforeach
                    </select>
                    <select id="cco_amphoe"  name="cco_amphoe"  class="mx-1 mr-2 form-control" >
                        <option value="">เลือกจังหวัดก่อน</option>
                        @foreach($amphoes as $item)
                        <option value="{{ $item->amphoe }}" {{ $item->amphoe==$cco_amphoe ? 'selected' : ''}}>{{ $item->amphoe }}</option>
                        @endforeach
                    </select>
                    </div>


                    <div class="my-3 input-group">


                        <select class="mr-2 form-select-sm" name="cco_rank" id="cco_rank" >

                            <option value="">แสดงยศทั้งหมด</option>
                                @foreach ( $rank as $key=>$item )
                                <option value="{{ $item->rank_name }}" {{ $cco_rank == $item->rank_name ? 'selected' : ''}}>{{ $item->rank_name  }}</option>

                                @endforeach
                        </select>

                            {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}

                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/cco/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/cco/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
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
                                <thead class="table-danger">
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
                                    @foreach ( $cco as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$cco->firstItem()+$loop->index}}</th>
                                    <td >
                                        <a href="{{url('/cco/edit/'.$row->cco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($cco_dep_id) ? '&cco_dep_id='.$cco_dep_id : '' }}{{isset($cco_provinces) ? '&cco_provinces='.$cco_provinces : '' }}{{isset($cco_education) ? '&cco_education='.$cco_education : '' }}{{isset($cco_disease) ? '&cco_disease='.$cco_disease : '' }}{{isset($cco_rank) ? '&cco_rank='.$cco_rank : '' }}{{isset($cco_amphoe) ? '&cco_amphoe='.$cco_amphoe : '' }}{{isset($cco_wantto) ? '&cco_wantto='.$cco_wantto : '' }}" >


                                        <img src="{{isset($row->cco_image) ? asset($row->cco_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->cco_image) ? asset($row->cco_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->cco_rank}}{{$row->cco_name}}</td>
                                    <td  class="hidden lg:table-cell">{{$row->cco_id }}</td>
                                    {{-- <td>{{$row->cco_intern}}</td> --}}
                                    <td>{{$row->cco_dep_name}}</td>
                                    <td class="hidden sm:table-cell">{{$row->cco_amphoe}}</td>
                                    <td class="hidden sm:table-cell">{{$row->cco_province}}</td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/cco/edit/'.$row->cco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($cco_dep_id) ? '&cco_dep_id='.$cco_dep_id : '' }}{{isset($cco_provinces) ? '&cco_provinces='.$cco_provinces : '' }}{{isset($cco_education) ? '&cco_education='.$cco_education : '' }}{{isset($cco_disease) ? '&cco_disease='.$cco_disease : '' }}{{isset($cco_rank) ? '&cco_rank='.$cco_rank : '' }}{{isset($cco_amphoe) ? '&cco_amphoe='.$cco_amphoe : '' }}{{isset($cco_wantto) ? '&cco_wantto='.$cco_wantto : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden lg:table-cell"><a href="{{url('/cco/delete/'.$row->cco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($cco_dep_id) ? '&cco_dep_id='.$cco_dep_id : '' }}{{isset($cco_provinces) ? '&cco_provinces='.$cco_provinces : '' }}{{isset($cco_education) ? '&cco_education='.$cco_education : '' }}{{isset($cco_disease) ? '&cco_disease='.$cco_disease : '' }}{{isset($cco_rank) ? '&cco_rank='.$cco_rank : '' }}{{isset($cco_amphoe) ? '&cco_amphoe='.$cco_amphoe : '' }}{{isset($cco_wantto) ? '&cco_wantto='.$cco_wantto : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>

                            {{$cco->appends(['search' => isset($search) ? $search : '','cco_dep_id'=>isset($cco_dep_id) ?$cco_dep_id :'',"cco_provinces"=> isset($cco_provinces) ? $cco_provinces : '',"cco_rank"=> isset($cco_rank) ? $cco_rank : '',"cco_amphoe"=> isset($cco_amphoe) ? $cco_amphoe: '',"cco_wantto"=> isset($cco_wantto) ? $cco_wantto: ''])->links()}}

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

        let cco_province = document.querySelector("#cco_provinces");
            let url = "/cco/amphoes?province=" + cco_provinces.value;
            console.log( url );
            // if(cco_province.value == "") return;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    //UPDATE SELECT OPTION
                    let cco_amphoe = document.querySelector("#cco_amphoe");
                    cco_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
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
        document.querySelector('#cco_provinces').addEventListener('change', (event) => {
            showAmphoes();
        });
        document.querySelector('#cco_provinces').addEventListener('click', (event) => {
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
