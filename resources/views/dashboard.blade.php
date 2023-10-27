<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ข้อมูลผู้ใช้ {{Auth::user()->name}}
           <b class="float-end">จำนวนผู้ใช้ระบบ <span class="text-red-500">{{count($users)}} </span>คน</b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-purple-500 shadow-xl sm:rounded-lg">
                <table class="table table-striped ">
                    <thead class="table-warning">
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">เริ่มใช้งานระบบ</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ( $users as $row )
                      <tr>
                        <th scope="row">{{$row->id}}</th>
                        <td>{{$row->name}}</td>
                        <td>{{$row->email}}</td>
                        <td>{{$row->created_at->diffForHumans()}}</td>

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
