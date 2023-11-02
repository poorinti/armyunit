<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">

           <b >จำนวนหน่วย <span class="text-red-500">{{count($Department)}} </span>หน่วย</b>
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
                        <th scope="col">จำนวนกำลังพล</th>

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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


<script>
$(".show-model").on('click',function (e){
//{{url('/userallow/edit/'.$row->id)}}
$('#exampleModal').modal('show');
});

</script>
