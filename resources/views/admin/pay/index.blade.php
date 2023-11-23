<x-app-layout>
    <x-slot name="header5">
        <h2 class="hidden text-xl font-semibold leading-tight text-white sm:block ">
            ข้อมูล ผู้รับสิทธิ์
            {{-- <b class="float-end">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b> --}}
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-white sm:block md:hidden lg:hidden xl:hidden">
         {{-- <b class="">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b> --}}
        </h2>

    </x-slot>


            {{-- @foreach ( $Department as $key=>$row )


            <div class="col-auto my-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Special {{$row->total}}</h5>
                      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                      <a href="#" class="btn btn-primary">{{$row->department_name} </a>
                    </div>
                  </div>
            </div>

        @endforeach --}}

    <div class="py-4">
        <div class="mx-auto max-w-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                 <form action="/pay/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class=" form-group">
                    </div>
                    <div class="input-group">
                            <select class="form-control" name="pay_dep_id" id="pay_dep_id" >
                                <option value="">แสดงหน่วยทั้งหมด</option>
                                    @foreach ( $Department as $key=>$row )

                                    <option value="{{$row->dep_id}}" {{ $pay_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                                @endforeach
                            </select>

                        <select class="form-control" name="pay_provinces" id="pay_provinces" >
                            <option value="">แสดงจังหวัดทั้งหมด</option>
                                @foreach ( $provinces as $key=>$item )
                                <option value="{{ $item->province }}" {{ $item->province==$pay_provinces ? 'selected' : ''}}>{{ $item->province }}</option>

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
                        $lawArr=['เงินสงเคราะห์บุตร','เงินสงเคราะห์บุพการี','ทุนยังชีพรายปีบุตร','ทุนยังชีพรายปีคู่สมรส']
                        @endphp

                        <select class="mr-2 form-select-sm" name="pay_paychk" id="pay_paychk" >

                            <option value="">ทั้งหมด</option>
                                @foreach ( $lawArr as $key=>$item )
                                <option value="{{ $item }}" {{ $item == $pay_paychk ? 'selected' : ''}}>{{ $item }}</option>

                                @endforeach
                        </select>


                        <select class="mr-2 form-select-sm" name="pay_rank" id="pay_rank" >

                            <option value="">คำนำหน้า</option>
                                @foreach ( $rank as $key=>$item )
                            <option value="{{ $item->rank_name }}" {{ $pay_rank == $item->rank_name ? 'selected' : ''}}>{{ $item->rank_name  }}</option>

                                @endforeach
                        </select>

                            {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}

                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/pay/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/pay/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
                    </div>
                </div>
                </form>

                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                    <div class="col-md-12">
                        <div class="">

                            <table class="table table-striped">
                                <thead class="table-primary">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพ</th>
                                    <th scope="col">ชื่อ-สกุล</th>
                                    <th scope="col" class="hidden sm:table-cell">เลขบัตรประชาชน</th>
                                    <th style="width: 120px;" scope="col">เกี่ยวข้องเป็น</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col" class="hidden sm:table-cell">ภูมิลำเนา</th>
                                    <th scope="col" class="hidden sm:table-cell">แก้ไข</th>
                                    <th scope="col" class="hidden sm:table-cell">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $pay as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$pay->firstItem()+$loop->index}}</th>
                                    <td >
                                        <a href="{{url('/pay/edit/'.$row->pay_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($pay_dep_id) ? '&pay_dep_id='.$pay_dep_id : '' }}{{isset($pay_provinces) ? '&pay_provinces='.$pay_provinces : '' }}{{isset($pay_education) ? '&pay_education='.$pay_education : '' }}{{isset($pay_disease) ? '&pay_disease='.$pay_disease : '' }}{{isset($pay_paychk) ? '&pay_paychk='.$pay_paychk : '' }}{{isset($pay_rank) ? '&pay_rank='.$pay_rank : '' }}" >


                                        <img src="{{isset($row->pay_image) ? asset($row->pay_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->pay_image) ? asset($row->pay_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->pay_rank}}{{$row->pay_name}}</td>
                                    <td  class="hidden sm:table-cell">{{$row->pay_id }}</td>
                                    <td>{{$row->pay_parent_about}}</td>
                                    <td>{{$row->pay_dep_name}}</td>
                                    <td class="hidden sm:table-cell">{{$row->pay_province}}</td>
                                    <td class="hidden sm:table-cell"><a href="{{url('/pay/edit/'.$row->pay_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($pay_dep_id) ? '&pay_dep_id='.$pay_dep_id : '' }}{{isset($pay_provinces) ? '&pay_provinces='.$pay_provinces : '' }}{{isset($pay_education) ? '&pay_education='.$pay_education : '' }}{{isset($pay_disease) ? '&pay_disease='.$pay_disease : '' }}{{isset($pay_paychk) ? '&pay_paychk='.$pay_paychk : '' }}{{isset($pay_rank) ? '&pay_rank='.$pay_rank : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden sm:table-cell"><a href="{{url('/pay/delete/'.$row->pay_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($pay_dep_id) ? '&pay_dep_id='.$pay_dep_id : '' }}{{isset($pay_provinces) ? '&pay_provinces='.$pay_provinces : '' }}{{isset($pay_education) ? '&pay_education='.$pay_education : '' }}{{isset($pay_disease) ? '&pay_disease='.$pay_disease : '' }}{{isset($pay_lawchk) ? '&pay_lawchk='.$pay_lawchk : '' }}{{isset($pay_rank) ? '&lpay_rank='.$pay_rank : '' }}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <br>

                            {{$pay->appends(['search' => isset($search) ? $search : '','pay_dep_id'=>isset($pay_dep_id) ?$pay_dep_id :'',"pay_provinces"=> isset($pay_provinces) ? $pay_provinces : '',"pay_rank"=> isset($pay_rank) ? $pay_rank : '',"pay_paychk"=> isset($pay_paychk) ? $pay_paychk : ''])->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

