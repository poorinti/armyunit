<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Arrays;
use DB;
use Image;

class SoldierController extends Controller
{
    public function index(Request $request){
        $search   =isset($request->search) ? $request->search : '' ;
        //  รับจากหน้า index ที่ selecd มา
        $soldier_dep_id=isset($request->soldier_dep_id) ? $request->soldier_dep_id : '' ;
        $user_id = Auth::user()->id;
        $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();
        $DepArr =Array();
        foreach($userdep as $key =>$row){
            $DepArr[]=$row->dep_id;
        }


  //ถ้ามาฟั่งชั้น index แล้ว search มีค่า query ก็จะทำงานใน if //desc คือมากกว่าขึ้นก่อน ไม่ใส่จะ น้อบไปมาก
       $soldier= Soldier::where('soldier_id','!=','')

       ->where(function($query) use ($DepArr){
                if($DepArr){
                    $query->whereIn('soldier_dep_id',$DepArr);
                }

         })
         // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
         ->where(function($query) use ($soldier_dep_id){
            if($soldier_dep_id!=''){
                $query->where('soldier_dep_id','=',$soldier_dep_id);
            }

     })
        ->where(function($query) use ($search){
            if($search !=''){
                //ตัวแรก where ตามด้วย orwhere
                $query->where('soldier_name', 'like','%'.$search.'%')
                ->orwhere('soldier_id', 'like','%'.$search.'%')
                ->orwhere('soldiers_dep_name', 'like','%'.$search.'%')
                ->orwhere('soldiers_bat_name', 'like','%'.$search.'%')
                ->orwhere('soldier_rtanumber', 'like','%'.$search.'%')
                ->orwhere('soldier_education', 'like','%'.$search.'%')
                ->orwhere('soldier_intern', 'like','%'.$search.'%')
                ->orwhere('soldier_skill', 'like','%'.$search.'%')
                ->orwhere('soldiers_teacher', 'like','%'.$search.'%')
                ->orwhere('soldiers_now', 'like','%'.$search.'%')
                ->orwhere('soldier_course', 'like','%'.$search.'%')
                ->orWhere('soldier_state','%'. $search.'%');
            }
		    })
            // ->dd()
       ->orderBy('created_at','desc')->paginate(15);

            // $Department=Department::where('dep_id','!=','')
            // ->orderby('dep_id')->get();

            //
            $Department=Department::select('dep_id')
            //->selectRaw('ใส่sql ตรงๆเลย')
            ->selectRaw('min(department_name)department_name')
            ->selectRaw("SUM(CASE WHEN soldier_dep_id != '' THEN 1 ELSE 0 END) AS total")
            //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
            ->leftJoin("soldiers", "soldiers.soldier_dep_id", "=", "departments.dep_id")
            //->where('soldier_dep_id','!=',)
            ->groupBy('dep_id')
            //->dd()
            ->get();

            $total_soldier= Soldier::where('soldier_id','!=','')->count();
        return view('admin.soldier.index',compact('soldier','search','soldier_dep_id','total_soldier','Department'));
    }

    public function store( Request $request){

        $request->validate([

          // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'

            'soldier_id'=>'required|unique:soldiers|max:13'
            ,'soldier_name'=>'required|unique:soldiers|max:255'
            ,'soldier_image'=>'mimes:png,jpg,jpeg,JPG|max:3072'
            // ,'soldier_address'
            // ,'soldier_country'
            // ,'soldier_state'
            // ,'soldier_zip'
            // ,'soldier_intern'
            // ,'soldier_corp'
            // ,'soldier_education'
            // ,'soldier_skill'
            // ,'soldier_startdate'
            // ,'soldier_enddate'
            // ,'soldier_phone'
            // ,'soldier_about'
            // , 'soldier_dep_id'

        ],
        [
            'soldier_name.required'=>"กรุณาป้อนชื่อกำลังพลด้วยครับ",
            'soldier_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'soldier_name.unique'=>"มีข้อมูลชื่อกำลังพลในฐานข้อมูลแล้ว",
            // 'soldier_image.required' => "กรุณาใส่ภาพประกอบ",
            'soldier_id.required'=>"กรุณาป้อนเลขประจำตัวประชาชนด้วยครับด้วยครับ",
            'soldier_id.max'=>"ห้ามป้อนตัวอักษรเกิน 13",
            'soldier_id.unique'=>"มีเลขประจำตัวประชาชนในฐานข้อมูลแล้ว",
        ]
    );
    //บันทึกข้อมูล

    $soldier_name   =isset($request->soldier_name) ? $request->soldier_name : '' ;
    $soldier_id   =isset($request->soldier_id) ? $request->soldier_id : '' ;
    $soldier_dep_id   =isset($request->soldier_dep_id) ? $request->soldier_dep_id : '' ;
    $act=false;
    $created_at=Carbon::now()->format("Y-m-d H:i:s");
    $updated_at =Carbon::now()->format("Y-m-d H:i:s");

    $Dep=Department::where('dep_id','=',$soldier_dep_id)->first();

    $soldiers_dep_name      =$Dep->department_name;
    $soldiers_bat_id        =$Dep->battalion_id ;
    $soldiers_bat_name      =$Dep->battalion_name;
    $soldier_year   =Carbon::now()->format("Y");

    $act =Soldier::insert([
        'soldier_name'=>$soldier_name,
        'soldier_id'=>$soldier_id,
        'soldier_dep_id'=>$soldier_dep_id,
        'created_at'=>$created_at,
        'updated_at'=>$updated_at
        ,'soldiers_dep_name'=>$soldiers_dep_name
        ,'soldiers_bat_id'=>$soldiers_bat_id
        ,'soldiers_bat_name'=>$soldiers_bat_name
        ,'soldier_year'=>$soldier_year

    ]);

//dd($act);
    if($act){


    //การเข้ารหัสรูปภาพ
    $soldier_image = $request->file('soldier_image');
    if($soldier_image){
    // gen ชื่อภาพ
    $name_gen = hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($soldier_image->getClientOriginalExtension());

    //ขื่อไฟล์ภาพ ภาพ
    $img_name = $name_gen.'.'.$img_ext;

    //อัพโหลดภาพ และบันทึกข้อมูล
    $upload_location = 'image/soldier/'.$soldier_year.'/'.$soldier_dep_id.'/';
    if (!File::exists('image/soldier/'.$soldier_year)) {

        // mkdir($upload_location, 0755, true);
        File::makeDirectory('image/soldier/'.$soldier_year, 0755, true);
        File::makeDirectory($upload_location, 0755, true);
    }
    $full_path = $upload_location.$img_name;
   // dd($full_path);

    Soldier::where('soldier_id','=',$soldier_id)->update([
        'soldier_image'=>$full_path,

    ]);

  $soldier_image->move($upload_location,$img_name);

        // $img = Image::make($soldier_image->path());
        // $act = $img->resize(400, 600, function ($const) {
        //     $const->aspectRatio();
        // })->save($full_path);


        // $imgFile = Image::make($soldier_image->getRealPath());
        // $imgFile->resize(150, 150, function ($constraint) {
		//     $constraint->aspectRatio();
		// })->save($upload_location.'/'.$input['file']);

        // $image->move($upload_location, $input['file']);


    }

}


    // $service_image->move(ที่ที่เก็บไว้ ตัวอย่างคือเก็บ ที่ pubplic ,ไฟล์ไหน);
    return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");

    }





       public function startadd(){

        $user_id = Auth::user()->id;
        //dd($user_id);
        $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();
        $DepArr =Array();
        foreach($userdep as $key =>$row){
            $DepArr[]=$row->dep_id;
        }
         if( $DepArr ){
            //ถ้ามี ข้อมูล ใน อาร์เรย์ ให้มาทำ ตรงนี้ where คือใน อารเรย์
            $Department=Department::whereIn('dep_id',$DepArr )->orderby('dep_id')->get();
         } else {
            $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();

         }
          // ไปหน้าแอด


          return view('admin.soldier.add',compact('Department'));
         }

         public function startupadd(Request $request){

            // Save Dapublic function startupadd(Request $request){

        // Save Data

        return view('admin.soldier.index');
       }

       public function delete($soldier_id){
        $act=false;
        $soldier_id  =isset($soldier_id) ? $soldier_id : '' ;

        $delete = Soldier::Where('soldier_id','=',$soldier_id)->Delete();
        if($act){
            return redirect()->back()->with("success","ลบข้อมูลถาวรเรียบร้อย");
        } else{
            return redirect()->back()->with("error","ไม่ลบสามารถลบข้อมูลได้");
        }
    }

    public function edit(Request $request,$soldier_id){
            //  dd($request->all());
            $page = isset($request->page)? $request->page : '';
            $soldier = Soldier::Where('soldier_id','=',$soldier_id)->first(); /// get คือ มีหลายตั้งหลายเร็ค // first เอาอันเดียว

            if($soldier){
                return view('admin.soldier.edit',compact('page','soldier'));
            }
            else {
            return  view('erroe.403');
            }

    }


    public function update(Request $request,$dep_id){
           //dd( $request->All());

           $request->validate([

            'soldier_image'=>'mimes:png,jpg,jpeg,JPG|max:2500'
          ],[
            'soldier_image.max' => "ขนาดไฟล์เกิด 2 MB ครับ",
          ]

      );

            $page = isset($request->page) ? $request->page  : '';
            $old_image = isset($request->old_image) ? $request->old_image  : '';
            $soldier_id = isset($request->soldier_id ) ? $request->soldier_id   : '';
            $soldier_rtanumber = isset($request->soldier_rtanumber ) ? $request->soldier_rtanumber   : '';
            $soldier_address = isset($request->soldier_address ) ? $request->soldier_address   : '';
            $soldier_state = isset($request->soldier_state ) ? $request->soldier_state   : '';
            $soldier_intern = isset($request->soldier_intern ) ? $request->soldier_intern  : '';
            $soldier_corp = isset($request->soldier_corp ) ? $request->soldier_corp  : '';
            $soldier_education = isset($request->soldier_education ) ? $request->soldier_education   : '';
            $soldier_skill = isset($request->soldier_skill ) ? $request->soldier_skill    : '';
            $soldier_startdate = isset($request->soldier_startdate  ) ? Carbon::parse($request->soldier_startdate )->format('Y-m-d')   : null;
            $soldier_enddate = isset($request->soldier_enddate ) ?Carbon::parse($request->soldier_enddate )->format('Y-m-d')  : null;
            $soldier_phone = isset($request->soldier_phone ) ? $request->soldier_phone  : '';
            $soldier_about = isset($request->soldier_about) ? $request->soldier_about   : '';
            $soldier_image =isset($request->soldier_image) ? $request->soldier_image   : '';
            $soldiers_teacher=isset($request->soldiers_teacher) ? $request->soldiers_teacher   : '';
            $soldiers_now=isset($request->soldiers_now) ? $request->soldiers_now   : '';
            $soldiers_term=isset($request->soldiers_term) ? $request->soldiers_term   : '';
            $soldier_course=isset($request->soldier_course) ? $request->soldier_course   : '';
          //  dd($soldier_id);
         $soldier =Soldier::where('soldier_id','=', $soldier_id)->first();
         $soldier_year =$soldier ->soldier_year;
         $soldier_dep_id=$soldier ->soldier_dep_id;

        //กรณีแก้ไข เลยอ้างอิงจากชื่อ

        $chk =false;


        if($soldier){
            Soldier::where('soldier_id','=',$soldier_id)->update([

                "soldier_id" => $soldier_id
                ,"soldier_rtanumber" => $soldier_rtanumber
                ,"soldier_address" => $soldier_address
                ,"soldier_state" => $soldier_state
                ,"soldier_intern" =>$soldier_intern
                ,"soldier_corp" => $soldier_corp
                ,"soldier_education" =>$soldier_education
                ,"soldier_skill" => $soldier_skill

                ,"soldier_startdate" => $soldier_startdate
                ,"soldier_enddate" => $soldier_enddate
                ,"soldier_phone" => $soldier_phone
                ,"soldier_about" => $soldier_about
                ,'soldiers_teacher'=> $soldiers_teacher
                , 'soldiers_now'=> $soldiers_now
                , 'soldiers_term'=> $soldiers_term
                 ,'soldier_course'=> $soldier_course

            ]);
        }




        $update_image = $request->file('soldier_image');

        if($update_image &&  $soldier ){

                // gen ชื่อภาพ
                $name_gen = hexdec(uniqid());

                //ดึงนามสกุลไฟล์ภาพ
                $img_ext = strtolower($soldier_image->getClientOriginalExtension());

                //ดึงนามสกุลไฟล์ภาพ ภาพ
                $img_name = $name_gen.'.'.$img_ext;

                //อัพโหลดภาพ และอัพเดทข้อมูล
                $upload_location = 'image/soldier/'.$soldier_year.'/'.$soldier_dep_id.'/';

                //ต้องการเช็ตpath ก่อน ถ้าไม่มีให้สร้าง
                if (!File::exists('image/soldier/'.$soldier_year)) {

                    // mkdir($upload_location, 0755, true);
                    File::makeDirectory('image/soldier/'.$soldier_year, 0755, true);
                    File::makeDirectory($upload_location, 0755, true);
                }

                $full_path = $upload_location.$img_name;

                  //ลบภาพเก่าและอัพภาพใหม่แทนที่
                  $old_image = $request->old_image;
                //   if($old_image){
                //   unlink($old_image);}
                  $soldier_image->move($upload_location,$img_name);
                // $img = Image::make($soldier_image->path());
                // $act = $img->resize(400, 600, function ($const) {
                //     $const->aspectRatio();
                // })->save($full_path);
                  $chk = True;

                  Soldier::where('soldier_id','=',$soldier_id)->update([
                    'soldier_image'=> $full_path

                ]);



        }



            // return redirect()->route('department')->with("success","บันทึกข้อมูลเรียบร้อย");

            // เช็คว่ามีเพจไหม ถ้าไม่มีไป all
            if($chk= true){
             if($page != ''){
                return redirect('/soldier/all?page='.$page)->with("success","อัพเดทข้อมูลเรียบร้อย");
             }
                else{
                    return redirect('/soldier/all')->with("success","อัพเดทข้อมูลเรียบร้อย");
                }
            }else{

                return with("error","ไม่ลบสามารถบันทึกข้อมูลได้");
            }
            // return redirect()->route('department')->with("success","อัพเดทข้อมูลเรียบร้อย");
        }



}
