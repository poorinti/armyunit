<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ServiceController extends Controller
{
    public function index(){
        //ดึงจาก EORM โดยตรง
       $service = Service::paginate(5);

      // $departments =  DB::table('departments')->get();

      //เขียนเรียกจาก table โดยตรง

    //   $departments =DB::table('departments')
    //     ->join('users','departments.user_id','users.id')
    //     ->select('departments.*','users.name')->paginate(5);

    //
    // DB::table('เรียกตาราง ดีพาสเม้น')
    // -> join ร่วมกับ('ตาราง users', 'โดย คอลั่ม user_id ใน departments.','เชื่มกับคอลั่ม id ใน ตาราง user')
    // ->select เลือก('เรียกตาราง ดีพาสเม้น ทั้งหมด.*','แต่ ในตรางรางuser เอามาแค่ name')->paginate(3);
        return view('admin.service.index',compact('service'));
    }

    public function store( Request $request){
        // dd($request->all());
        $request->validate([

            'service_name'=>'required|unique:services|max:255',
            // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'
            'service_image'=>'required|mimes:png,jpg,jpeg'
        ],
        [
            'service_name.required'=>"กรุณาป้อนชื่อบริการด้วยครับ",
            'service_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'service_name.unique'=>"มีข้อมูลชื่อยริการในฐานข้อมูลแล้ว",
            'service_image.required' => "กรุณาใส่ภาพประกอบ",
        ]
    );
    //บันทึกข้อมูล


    //การเข้ารหัสรูปภาพ
    $service_image = $request->file('service_image');

    // gen ชื่อภาพ
    $name_gen = hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($service_image->getClientOriginalExtension());

    //ดึงนามสกุลไฟล์ภาพ ภาพ
    $img_name = $name_gen.'.'.$img_ext;

    //อัพโหลดภาพ และบันทึกข้อมูล
    $upload_location = 'image/services/';
    $full_path = $upload_location.$img_name;

    Service::insert([
        'service_name'=>$request->service_name,
        'service_image'=>$full_path,
        'created_at'=>Carbon::now(),
    ]);
    $service_image->move($upload_location,$img_name);
    // $service_image->move(ที่ที่เก็บไว้ ตัวอย่างคือเก็บ ที่ pubplic ,ไฟล์ไหน);
    return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");

    }

    public function edit($id){
        $service = Service::find($id);
        // goto edit
        return view('admin.service.edit',compact('service'));
    }

    public function update(Request $request,$id){

        $request->validate([

            'service_name'=>'required|max:255',
            // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'
            'service_image'=>'mimes:png,jpg,jpeg'
        ],
        [
            'service_name.required'=>"กรุณาป้อนชื่อบริการด้วยครับ",
            'service_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",

        ]
    );
        //การเข้ารหัสรูปภาพ
        $service_image = $request->file('service_image');
        //อัพเดตภาพและชื่อ
    if($service_image){


     // gen ชื่อภาพ
     $name_gen = hexdec(uniqid());

     //ดึงนามสกุลไฟล์ภาพ
     $img_ext = strtolower($service_image->getClientOriginalExtension());

     //ดึงนามสกุลไฟล์ภาพ ภาพ
     $img_name = $name_gen.'.'.$img_ext;

     //อัพโหลดภาพ และอัพเดทข้อมูล
     $upload_location = 'image/services/';
     $full_path = $upload_location.$img_name;

     Service::find($id)->update([
         'service_name'=>$request->service_name,
         'service_image'=>$full_path,
     ]);
      //ลบภาพเก่าและอัพภาพใหม่แทนที่
      $old_image = $request->old_image;
      unlink($old_image);
      $service_image->move($upload_location,$img_name);
     // $service_image->move(ที่ที่เก็บไว้ ตัวอย่างคือเก็บ ที่ pubplic ,ไฟล์ไหน);

     return redirect()->route('services')->with('success',"อัพเดตภาพเรียบร้อย");
    } else{
         //อัพเดตชื่ออย่างเดียว
         Service::find($id)->update([
            'service_name'=>$request->service_name,
        ]);
        return redirect()->route('services')->with('success',"อัพเดตชื่อบริการเรียบร้อย");
    }
    }

    public function delete($id){

       //  ลบภาพจากฐานข้อมูล
        $img =Service::find($id)->service_image;
        unlink($img);


       //ข้อมูล
        $delete =Service::find($id)->delete();

        return redirect()->back()->with("success","ลบข้อมูลถาวรเรียบร้อย");
    }

    public function startup(Request $request){

      //dd($request->All());

      //  $start_date = isset($request->start_date) ? $request->start_date  :   Carbon::now();
      //$start_date=     Carbon::parse($start_date)->addYear(543)->format('Y-m-d');

      //isset เช็คว่ามีการกรอกข้อมูลมาหรือไม่
     // $end_date = isset($request->end_date) ? $request->end_date  :   Carbon::now();
      //$end_date=     Carbon::parse($end_date)->addYear(543)->format('Y-m-d');

      //dd($start_date,$end_date);


      return view('admin.service.add');
     }

       public function startupupdate(Request $request){

        // Save Data
        return view('admin.soldier.add');
       }






}
