<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BattalionController extends Controller
{
    public function index(){
        //ดึงจาก EORM โดยตรง
       $departments = Department::all();
       $battalion = Battalion::paginate(15);

      // $departments =  DB::table('departments')->get();

      //เขียนเรียกจาก table โดยตรง

    //   $departments =DB::table('departments')
    //     ->join('users','departments.user_id','users.id')
    //     ->select('departments.*','users.name')->paginate(5);

    //
    // DB::table('เรียกตาราง ดีพาสเม้น')
    // -> join ร่วมกับ('ตาราง users', 'โดย คอลั่ม user_id ใน departments.','เชื่มกับคอลั่ม id ใน ตาราง user')
    // ->select เลือก('เรียกตาราง ดีพาสเม้น ทั้งหมด.*','แต่ ในตรางรางuser เอามาแค่ name')->paginate(3);
        return view('admin.battalion.index',compact('battalion','departments'));
    }

    public function store( Request $request){
        $request->validate([
            'battalion_name'=>'required|unique:battalions|max:255',
            'battalion_id'=>'required|unique:battalions|max:50'
        ],
        [
            'battalion_name.required'=>"กรุณาป้อนชื่อกองพันด้วยครับ",
            'battalion.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'battalion_name.unique'=>"มีข้อมูลชื่อแผนกนี้ในฐานข้อมูลแล้ว",
        ]
    );
    //บันทึกข้อมูล


    // $department = new Department ;//เอาจากโมเดลมา
    // $department->department_name = $request->department_name; //อ้างอิงค่ามาใส เอาค่ามาใส่ $fileable
    // $department->user_id = Auth::user()->id;
    // $department->save();

    $data = array();
    $data['battalion_name'] = $request->battalion_name;
    $data['battalion_id']= $request->battalion_id;
   // dd($request->department_id);
    //query
    DB::table('battalions')->insert($data);

    return redirect()->back()->with("success","บันทึกข้อมูลเรียบร้อย");
    }


}
