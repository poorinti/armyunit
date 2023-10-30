<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Department;
use App\Models\Soldier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function index(){
        //ดึงจาก EORM โดยตรง
       $departments = Department::paginate(30);
       $battalion = Battalion::where('battalion_id','!=','')->orderby('battalion_id')->get();

    //    $Battalion = Battalion::where('battalion_id','!= ไม่ค่าว่าง','')->orderby('battalion_id')->get();
       $trashDepartment = Department::onlyTrashed()->paginate(10);
      // $departments =  DB::table('departments')->get();

      //เขียนเรียกจาก table โดยตรง

    //   $departments =DB::table('departments')
    //     ->join('users','departments.user_id','users.id')
    //     ->select('departments.*','users.name')->paginate(5);

    //
    // DB::table('เรียกตาราง ดีพาสเม้น')
    // -> join ร่วมกับ('ตาราง users', 'โดย คอลั่ม user_id ใน departments.','เชื่มกับคอลั่ม id ใน ตาราง user')
    // ->select เลือก('เรียกตาราง ดีพาสเม้น ทั้งหมด.*','แต่ ในตรางรางuser เอามาแค่ name')->paginate(3);
        return view('admin.department.inddex',compact('departments','battalion','trashDepartment'));
    }
    public function store( Request $request){
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
            ,'dep_id'=>'required|unique:departments|max:50'
        ],
        [
            'department_name.required'=>"กรุณาป้อนชื่อแผนกด้วยครับ",
            'department_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'department_name.unique'=>"มีข้อมูลหน่วยฝึกนี้ในฐานข้อมูลแล้ว",
        ]
    );
    //บันทึกข้อมูล


    // $department = new Department ;//เอาจากโมเดลมา
    // $department->department_name = $request->department_name; //อ้างอิงค่ามาใส เอาค่ามาใส่ $fileable
    // $department->user_id = Auth::user()->id;
    // $department->save();

    $data = array();

    $data['dep_id'] = $request->dep_id;
    $data['department_name'] = $request->department_name;
    $data['battalion_id'] = $request->battalion_id;
    $battalion =Battalion::where('battalion_id','=', $request->battalion_id)->first();
    $data['battalion_name'] =  $battalion->battalion_name ?? '';


    //query
    DB::table('departments')->insert($data);

    return redirect()->back()->with("success","บันทึกข้อมูลเรียบร้อย");
    }

    public function edit(Request $request,$dep_id){
        // dd($request->all());
        $page = isset($request->page)? $request->page : '';
        $department = Department::Where('dep_id','=',$dep_id)->first(); /// get คือ มีหลายตั้งหลายเร็ค // first เอาอันเดียว
        $battalion = Battalion::where('battalion_id','!=','')->orderby('battalion_id')->get();
        if($department){
            return view('admin.department.edit',compact('department', 'battalion','page'));
        }
         else {
           return  view('error.403');
        }

    }

    public function update(Request $request,$dep_id){
    //    dd( $request->All());
      $page = isset($request->page)? $request->page : '';
        $request->validate([
            'department_name'=>'required|max:255',

        ],
        [
            'department_name.required'=>"กรุณาป้อนชื่อแผนกด้วยครับ",
            'department_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'department_name.unique'=>"มีข้อมูลชื่อแผนกนี้ในฐานข้อมูลแล้ว",
        ]
    );

    $battalion =Battalion::where('battalion_id','=', $request->battalion_id)->first();
    $battalion_name =  $battalion->battalion_name ?? '';
    $department_name = isset($request->department_name) ? $request->department_name : '';
    //กรณีแก้ไข เลยอ้างอิงจากชื่อ
    $update =false;

    if( $department_name){
        $update =true;
        Department::where('dep_id','=',$dep_id)->update([
            'department_name' => $department_name

        ]);
    }

    if($update ){
        Soldier::where('soldier_dep_id','=',$dep_id)->update([
            'soldiers_dep_name' => $department_name

        ]);
    }



        // return redirect()->route('department')->with("success","บันทึกข้อมูลเรียบร้อย");

        // เช็คว่ามีเพจไหม ถ้าไม่มีไป all
         if($page != ''){
            return redirect('/department/all?page='.$page)->with("success","อัพเดทข้อมูลเรียบร้อย");
         }
            else{
                return redirect('/department/all')->with("success","อัพเดทข้อมูลเรียบร้อย");
            }
        // return redirect()->route('department')->with("success","อัพเดทข้อมูลเรียบร้อย");
    }

    public function softdelete($dep_id){

        // $softdelete= เรียก Department::แล้วหาด้วยid ที่รับค่า มากจากปุ่มลบ find($id)->แล้วสั่งให้ลบ delete();
        //$softdelete =Department::Where('dep_id','=',$dep_id)->delete();
                                    //ชื่อฟิวจริง

                                    $check= 0;

      //User::Where('dep_id','=',$dep_id)->count();
        if($check){
            return redirect()->back()->with("error","ไม่ลบข้อมูลถาวรเรียบร้อย");
        } else {
            $softdelete =Department::Where('dep_id','=',$dep_id)->delete();

        }

        return redirect()->back()->with("success","ลบข้อมูลเรียบร้อย");
    }

    public function restore($dep_id){

        // $softdelete= เรียก ในถังขยะ Department::แล้วหาด้วยid ที่รับค่า มากจากปุ่มกู้ข้อมูล find($id)->แล้วสั่งให้กู้ข้อมูล restore();
        $restore =Department::withTrashed()->Where('dep_id','=',$dep_id)->restore();
        return redirect()->back()->with("success","กู้คืนข้อมูลเรียบร้อย");

    }

    public function delete($dep_id){

        // $delete= เรียก Department::แล้วหาด้วยid ที่รับค่า มากจากปุ่มลบ find($id)->แล้วสั่งให้ลบ คือลบจริงๆจากถังขยะ forcedelete();
      $check= 0;

      //User::Where('dep_id','=',$dep_id)->count();
        if($check){
            return redirect()->back()->with("error","ไม่สามารถลบข้อมูลได้ เนื่องจากมีการผูกข้อมูลไว้แล้ว");
        } else {
            $delete =Department::onlyTrashed()->Where('dep_id','=',$dep_id)->forceDelete();

        }

        return redirect()->back()->with("success","ลบข้อมูลถาวรเรียบร้อย");
    }
}

//รันตาเลขหน้า <!--<div> {{department_name->fristItem()+loop->index }} </div> -->
