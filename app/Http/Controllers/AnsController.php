<?php

namespace App\Http\Controllers;

use App\Models\Ans;
use App\Models\Soldier;
use App\Models\Userdep;

use App\Models\Battalion;
use App\Models\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Nette\Utils\Arrays;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;


class AnsController extends Controller
{
    public function index(Request $request){
        // dd($request->all());
        //ดึงจาก EORM โดยตรง
       $departments = Department::orderby('dep_index')->paginate(30);
       $battalion = Battalion::where('battalion_id','!=','')->orderby('battalion_id')->get();

    //    $ans_ID = Ans::where('ans_dep_id','!=','')->orderby('ans_index')->get();

        // dd($ansShow,$departments);
    //    $Battalion = Battalion::where('battalion_id','!= ไม่ค่าว่าง','')->orderby('battalion_id')->get();
       $trashDepartment = Department::onlyTrashed()->paginate(10);
      // $departments =  DB::table('departments')->get();
    //  );
      //เขียนเรียกจาก table โดยตรง

    //   $departments =DB::table('departments')
    //     ->join('users','departments.user_id','users.id')
    //     ->select('departments.*','users.name')->paginate(5);

    //
    // DB::table('เรียกตาราง ดีพาสเม้น')
    // -> join ร่วมกับ('ตาราง users', 'โดย คอลั่ม user_id ใน departments.','เชื่มกับคอลั่ม id ใน ตาราง user')
    // ->select เลือก('เรียกตาราง ดีพาสเม้น ทั้งหมด.*','แต่ ในตรางรางuser เอามาแค่ name')->paginate(3);


    $ans_name =isset($request->ans_name ) ? $request->ans_name   : '' ;
    $ans_dep_id =isset($request->ans_dep_id) ? $request->ans_dep_id : '' ;

    $user_id = Auth::user()->id;
    $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

    $DepArr =Array();
    foreach($userdep as $key =>$row){
        $DepArr[]=$row->dep_id;
    }
    $ansShow = Ans::where('ans_id','!=','')->orderby('ans_id')
            ->where(function($query) use ($DepArr){
                if($DepArr){
                    $query->whereIn('ans_dep_id',$DepArr);
                }

        })
        ->where(function($query) use ($ans_dep_id){
            if($ans_dep_id!=''){
                $query->where('ans_dep_id','=',$ans_dep_id);
            }

        })
        ->where(function($query) use ($ans_name){
            if($ans_name!=''){
                $query->where('ans_name','=',$ans_name);
            }

        })
        ->paginate(30);

        return view('admin.ans.index',compact('departments','battalion','trashDepartment','ansShow','ans_dep_id','ans_name'));
    }
    public function store( Request $request){
        //  dd($request->all());
        $request->validate([

            // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'



              'ans_image'=>'required|mimes:png,jpg,jpeg,JPG|max:2048'
          ],
          [

              // 'soldier_image.required' => "กรุณาใส่ภาพประกอบ",
              'ans_id.unique'=>"มีลำดับนี้แล้วกรุณาลบ ข้อมูลเก่าออกก่อน",
              'ans_image.required'=>'โปรดเพิ่มรูปก่อนบันทึกข้อมูล'
          ]
      );

        $ans_name   =isset($request->ans_name) ? $request->ans_name : '' ;
        $ans_dep_id  =isset($request->ans_dep_id) ? $request->ans_dep_id : '' ;
        $ans_index =isset($request->ans_index) ? $request->ans_index : '' ;

        $act=false;
        $created_at=Carbon::now()->format("Y-m-d H:i:s");
        $updated_at =Carbon::now()->format("Y-m-d H:i:s");

        $name_gen = hexdec(uniqid());
        $ans_id=$ans_dep_id.'_'.$name_gen;

        $chkid=Ans::where('ans_id','=',$ans_id)->first();
        if(!$chkid){
        //  dd( $ans_id);
        $Dep=Department::where('dep_id','=',$ans_dep_id )->first();

        $ans_dep_name      =$Dep->department_name;
        $ans_bat_id        =$Dep->battalion_id ;
        $ans_bat_name      =$Dep->battalion_name;
        $ans_year   =Carbon::now()->format("Y");

        $act =Ans::insert([
            'ans_name'=>$ans_name,
            'ans_id'=>$ans_id,
            'ans_dep_id'=>$ans_dep_id,
            'ans_index'=>$ans_index,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at
            ,'ans_dep_name'=>$ans_dep_name
            ,'ans_bat_id'=>$ans_bat_id
            ,'ans_bat_name'=>$ans_bat_name
            ,'ans_year'=>$ans_year

        ]);

    //dd($act);
        if($act){


        //การเข้ารหัสรูปภาพ
        $ans_image = $request->file('ans_image');
        if($ans_image){
        // gen ชื่อภาพ
        $name_gen = hexdec(uniqid());

        //ดึงนามสกุลไฟล์ภาพ
        $img_ext = strtolower($ans_image->getClientOriginalExtension());

        //ขื่อไฟล์ภาพ ภาพ
        $img_name = $name_gen.'.'.$img_ext;

        //อัพโหลดภาพ และบันทึกข้อมูล
        $upload_location = 'image/ans/'.$ans_year.'/'.$ans_dep_id.'/';
        if (!File::exists('image/ans/'.$ans_year)) {

            // mkdir($upload_location, 0755, true);
            File::makeDirectory('image/ans/'.$ans_year, 0755, true);
            File::makeDirectory($upload_location, 0755, true);
        }
        $full_path = $upload_location.$img_name;
       // dd($full_path);

        Ans::where('ans_id','=',$ans_id)->update([
            'ans_image'=>$full_path,

        ]);

      $ans_image->move($upload_location,$img_name);

        }

        return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");
    }
}
        return redirect()->back()->with('error',"มีลำดับนี้อยู่แล้ว โปรดลบข้อมูลเก่าก่อน");
        // $service_image->move(ที่ที่เก็บไว้ ตัวอย่างคือเก็บ ที่ pubplic ,ไฟล์ไหน);

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

    public function delete(Request $request,$ans_id){

        $ans_name=isset($request->ans_name)? $request->ans_name : '';
        $ans_dep_id=isset($request->ans_dep_id)? $request->ans_dep_id : '';
        $act=true;
        $ans_id  =isset($ans_id) ? $ans_id : '' ;

        $chkimage= Ans::Where('ans_id','=',$ans_id)->first();
        $ans_image1=$chkimage->ans_image;
        $delete = Ans::Where('ans_id','=',$ans_id)->Delete();
        if($ans_image1){
             unlink($ans_image1);
            }
        if($act){
            return redirect()->route('ans',['ans_name'=>$ans_name,'ans_dep_id'=>$ans_dep_id])->with("success","ลบข้อมูลถาวรเรียบร้อย");;
            // return redirect()->back()->->with('ans_dep_id',$ans_dep_id);
        } else{
            return redirect()->back()->with("error","ไม่ลบสามารถลบข้อมูลได้");
        }
    }

    public function show(){
        //ดึงจาก EORM โดยตรง
       $departments = Department::orderby('dep_index')->paginate(30);
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
        return view('admin.department.show',compact('departments','battalion','trashDepartment'));
    }

}

//รันตาเลขหน้า <!--<div> {{department_name->fristItem()+loop->index }} </div> -->
