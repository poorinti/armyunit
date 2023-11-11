<x-app-layout>
    <x-slot name="header">
        <h2 class="hidden text-xl font-semibold leading-tight text-gray-800 sm:block ">
            ข้อมูลนายสิบ
            {{-- <b class="float-end">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b> --}}
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:block md:hidden lg:hidden xl:hidden">
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
                {{-- <form action="/soldier/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class=" form-group">
                    </div>
                    <div class="input-group">
                            <select class="form-control" name="soldier_dep_id" id="soldier_dep_id" >
                                <option value="">แสดงหน่วยทั้งหมด</option>
                                    @foreach ( $Department as $key=>$row )

                                    <option value="{{$row->dep_id}}" {{ $soldier_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                                @endforeach
                        </select>

                        <select class="form-control" name="soldier_provinces" id="soldier_provinces" >
                            <option value="">แสดงจังหวัดทั้งหมด</option>
                                @foreach ( $provinces as $key=>$item )
                                <option value="{{ $item->province }}" {{ $item->province==$soldier_provinces ? 'selected' : ''}}>{{ $item->province }}</option>

                                @endforeach
                            </select>

                   </div>
                            @php
                            $educationArr = array();
                            $educationArr=['ประถม','ม.ต้น','ม.ปลาย','ปวช','ปวส.','ป.ตรี','ป.โท','ป.เอก',]
                            @endphp
                   <div class="input-group">
                        <select class="form-control" name="soldier_education" id="soldier_education" >
                            <option value="">แสดงวุฒิทั้งหมด</option>
                                @foreach ( $educationArr as $key=>$row )

                                <option value="{{$row}}" {{ $soldier_education ==$row ? 'selected' :'' }}>{{$row}}</option>
                            @endforeach
                        </select>
                        @php
                        $diseaseArr = array();
                        $diseaseArr=['ไม่มี','ซึมเศร้า','จิตเวช','ภูมิแพ้','หอบหืด','หัวใจ','ภูมิแพ้','กระดูก/ดามเหล็ก','เคยเป็นลมร้อนมาก่อน','ตับ','ไว้รัสตับอักเสบ B','ลมชัก','อื่นๆ']
                        @endphp

                        <select class="form-control" name="soldier_disease" id="soldier_disease" >
                        <option value="">แสดงอาการป่วยทั้งหมด</option>
                            @foreach ( $diseaseArr as $key=>$item )
                            <option value="{{ $item }}" {{ $item == $soldier_disease ? 'selected' : ''}}>{{ $item }}</option>

                            @endforeach
                        </select>

                    </div>


                    <div class="my-3 input-group ">

                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/soldier/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/soldier/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
                    </div>
                </div>
                </form> --}}

                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                    <div class="col-md-12">
                        <div class="">

                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อ-สกุล</th>
                                    <th scope="col" class="hidden sm:table-cell">เลขบัตรประชาชน</th>
                                    <th style="width: 80px;" scope="col">ผลัด/ปี</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col" class="hidden sm:table-cell">ภูมิลำเนา</th>
                                    <th scope="col" class="hidden sm:table-cell">แก้ไข</th>
                                    <th scope="col" class="hidden sm:table-cell">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $nco as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$nco->firstItem()+$loop->index}}</th>
                                    <td >
                                        {{-- <a href="{{url('/soldier/edit/'.$row->nco_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' }}{{isset($soldier_provinces) ? '&soldier_provinces='.$soldier_provinces : '' }}{{isset($soldier_education) ? '&soldier_education='.$soldier_education : '' }}{{isset($soldier_disease) ? '&soldier_disease='.$soldier_disease : '' }}" > --}}


                                        <img src="{{isset($row->nco_image) ? asset($row->nco_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->nco_image) ? asset($row->nco_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->nco_name}}</td>
                                    <td  class="hidden sm:table-cell">{{$row->nco_id }}</td>
                                    <td>{{$row->nco_intern}}</td>
                                    <td>{{$row->nco_dep_name}}</td>
                                    <td class="hidden sm:table-cell">{{$row->nco_province}}</td>
                                    <td class="hidden sm:table-cell"><a href="{{url('/nco/edit/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($nco_dep_id) ? '&nco_dep_id='.$nco_dep_id : '' }}{{isset($nco_provinces) ? '&nco_provinces='.$nco_provinces : '' }}{{isset($nco_education) ? '&nco_education='.$nco_education : '' }}{{isset($nco_disease) ? '&nco_disease='.$nco_disease : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden sm:table-cell"><a href="{{url('/nco/delete/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($nco_dep_id) ? '&nco_dep_id='.$nco_dep_id : '' }}{{isset($nco_provinces) ? '&nco_provinces='.$nco_provinces : '' }}{{isset($nco_education) ? '&nco_education='.$nco_education : '' }}{{isset($nco_disease) ? '&nco_disease='.$nco_disease : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>

                            {{$nco->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

