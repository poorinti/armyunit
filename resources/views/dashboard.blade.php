<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">

           <b >พลทหาร จำนวน <span class="text-red-500">{{count($Department)}} </span>หน่วย</b>
        </h2>
    </x-slot>
   {{-- {{dd($Department);}} --}}
    <div class="py-12">
        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-purple-500 shadow-xl sm:rounded-lg">
                <table class="table table-striped ">
                    <thead class="table-warning">
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">หน่วย</th>
                        <th scope="col">จำนวนพลทหาร</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp

                        @foreach ( $Department as $row )
                      <tr>
                        <th >{{$i++}}</th>
                        <td>{{$row->department_name}}</td>
                        <td>{{$row->total}}</td>



                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</x-app-layout>


