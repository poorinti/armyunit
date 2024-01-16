<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Ans;
use App\Models\Department;
use App\Models\Tambon;

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
         //dd($request->all());
        //  รับจากหน้า index ที่ selecd มา
        $soldier_dep_id     =isset($request->soldier_dep_id) ? $request->soldier_dep_id : '' ;
        $soldier_provinces  =isset($request->soldier_provinces) ? $request->soldier_provinces : '' ;
        $soldier_education =isset($request->soldier_education) ? $request->soldier_education : '' ;
        $soldier_disease =isset($request->soldier_disease) ? $request->soldier_disease : '' ;
        $soldier_amphoe =isset($request->soldier_amphoe) ? $request->soldier_amphoe : '' ;
        $soldier_wantto=isset($request->soldier_wantto) ? $request->soldier_wantto : '' ;
        $soldier_want_nco=isset($request->soldier_want_nco) ? $request->soldier_want_nco : '' ;

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

        ->where(function($query) use ($soldier_provinces){
            if($soldier_provinces!=''){
                $query->where('soldier_province','=',$soldier_provinces);
            }

        })
        ->where(function($query) use ($soldier_amphoe){
            if($soldier_amphoe!=''){
                $query->where('soldier_amphoe','=',$soldier_amphoe);
            }

        })
        ->where(function($query) use ($soldier_education){
            if($soldier_education!=''){
                $query->where('soldier_education','=',$soldier_education);
            }

        })
        ->where(function($query) use ($soldier_disease){
            if($soldier_disease!=''){
                $query->where('soldier_disease','=',$soldier_disease);
            }

        })
        ->where(function($query) use ($soldier_wantto){
            if($soldier_wantto!=''){
                $query->where('soldier_wantto','=',$soldier_wantto);
            }

        })
        ->where(function($query) use ($soldier_want_nco){
            if($soldier_want_nco!=''){
                $query->where('soldier_want_nco','=',$soldier_want_nco);
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
                ->orwhere('soldier_province', 'like','%'.$search.'%')
                ->orwhere('soldier_address', 'like','%'.$search.'%')
                ->orwhere('soldiers_teacher', 'like','%'.$search.'%')
                ->orwhere('soldiers_now', 'like','%'.$search.'%')
                ->orwhere('soldier_course', 'like','%'.$search.'%')
                ->orWhere('soldier_state','%'. $search.'%')
                ->orWhere('soldier_province','%'. $search.'%')
                ->orWhere('soldier_amphoe','%'. $search.'%')
                ->orWhere('soldier_wantto','%'. $search.'%')
                ->orWhere('soldier_disease','%'. $search.'%')
                ->orWhere('soldier_disease_about','%'. $search.'%')
                ->orWhere('soldier_startdate_text','%'. $search.'%')
                ->orWhere('soldier_enddate_text','%'. $search.'%')
                ->orWhere('soldier_course_have','%'. $search.'%')
                ->orWhere('soldier_education_study','%'. $search.'%')
                ->orWhere('soldier_education_end','%'. $search.'%')
                ->orWhere('soldier_job','%'. $search.'%');
            }
		    })
            // ->dd()
           // ->orderBy('soldier_intern')
           //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
           ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) desc")
           ->orderByRaw("SUBSTRING_INDEX(soldier_intern,'/',1) desc")
            ->orderBy('soldier_name')
            // ->orderBy('created_at','desc')
            ->paginate(15);

            // $Department=Department::where('dep_id','!=','')
            // ->orderby('dep_id')->get();

            //
            $Department=Department::select('dep_id')
            //->selectRaw('ใส่sql ตรงๆเลย')
            ->selectRaw('min(departments.dep_index)dep_index')
            ->selectRaw('min(department_name)department_name')
            ->selectRaw("SUM(CASE WHEN soldier_dep_id != '' THEN 1 ELSE 0 END) AS total")
            //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
            ->leftJoin("soldiers", "soldiers.soldier_dep_id", "=", "departments.dep_id")
            //->where('soldier_dep_id','!=',)
            ->groupBy('dep_id')
            ->orderBy('dep_index')
            //->dd()
            ->get();

            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $provinces = Soldier::selectRaw('soldier_province as province')->where('soldier_province','!=','')->distinct()->get();

            $total_soldier= Soldier::where('soldier_id','!=','')->count();

            if($soldier_dep_id!=''){
            $ans = Ans::where('ans_id','!=','')
            ->where('ans_name','=','ข้อมูลพลทหาร')
                ->where(function($query) use ($soldier_dep_id){
                    if($soldier_dep_id!=''){
                        $query->where('ans_dep_id','=',$soldier_dep_id);
                    }
                })->orderBy('ans_index')->get();
                }else{
                    $ans=null;
                }




        return view('admin.soldier.index',compact('soldier','search','soldier_dep_id','total_soldier','Department','soldier_dep_id','provinces','soldier_provinces','soldier_education','soldier_disease','amphoes','soldier_amphoe','soldier_wantto','soldier_want_nco','ans'));
    }

    public function store( Request $request){

        $request->validate([

          // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'

            'soldier_id'=>'required|unique:soldiers|max:13'
            ,'soldier_name'=>'required|unique:soldiers|max:255'
            ,'soldier_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
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


    public function delete(Request $request,$soldier_id){

        $soldier_id  =isset($soldier_id) ? $soldier_id : '' ;
        $search=isset($request->search)? $request->search : '';
        $page=isset($request->page)? $request->page : '';
        $soldier_want_nco=isset($request->soldier_want_nco)? $request->soldier_want_nco : '';

        // dd($soldier_name);
        $soldier_dep_id=isset($request->soldier_dep_id)? $request->soldier_dep_id : '';
        $act=true;
        $soldier_id  =isset($soldier_id) ? $soldier_id : '' ;

        $chkimage= Soldier::Where('soldier_id','=',$soldier_id)->first();
        $soldier_image1=$chkimage->soldier_image;

        $delete = Soldier::Where('soldier_id','=',$soldier_id)->Delete();
        if($soldier_image1){
             unlink($soldier_image1);
            }
        if($delete){
            return redirect()->route('soldier',['search'=>$search,'page'=>$page,'soldier_dep_id'=>$soldier_dep_id,'soldier_want_nco'=>$soldier_want_nco])->with("success","ลบข้อมูลถาวรเรียบร้อย");
            // return redirect()->back()->->with('ans_dep_id',$ans_dep_id);
        } else{
            return redirect()->back()->with("error","ไม่ลบสามารถลบข้อมูลได้");
        }
    }

    public function edit(Request $request,$soldier_id){
            //   dd($request->all());

            $page = isset($request->page)? $request->page : '';
            $search = isset($request->search) ? $request->search  : '';
            $soldier_dep_id = isset($request->soldier_dep_id) ? $request->soldier_dep_id : '';
            $soldier_provinces  =isset($request->soldier_provinces) ? $request->soldier_provinces : '' ;
            $soldier_amphoe=isset($request->soldier_amphoe) ? $request->soldier_amphoe : '' ;
            $soldier_wantto=isset($request->soldier_wantto) ? $request->soldier_wantto : '' ;

            $soldier = Soldier::Where('soldier_id','=',$soldier_id)->first(); /// get คือ มีหลายตั้งหลายเร็ค // first เอาอันเดียว

            // distinct() ซ้ำกันเอาอันเดียว
            $provinces = Tambon::select('province')->distinct()->get();
            $amphoes = Tambon::select('amphoe')->distinct()->get();
            //$tambons = Tambon::select('tambon')->distinct()->get();

        // dd($soldier_provinces);
            if($soldier){
                return view('admin.soldier.edit',compact('page','soldier','soldier_dep_id','search','provinces','amphoes','soldier_provinces','soldier_amphoe','soldier_wantto'));
            }
            else {
            return  view('erroe.403');
            }

    }


    public function update(Request $request,$dep_id){
        //   dd( $request->All());

           $request->validate([

            'soldier_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
          ],[
            'soldier_image.max' => "ขนาดไฟล์เกิน 2 MB ครับ",
          ]

      );

// dd($soldier_startdate);


            $page = isset($request->page) ? $request->page  : '';
            $search = isset($request->search) ? $request->search  : '';
            $soldier_dep_id = isset($request->soldier_dep_id) ? $request->soldier_dep_id : '';
            ////
            $old_image = isset($request->old_image) ? $request->old_image  : '';
            $soldier_id = isset($request->soldier_id ) ? $request->soldier_id   : '';
            $soldier_name=isset($request->soldier_name) ? $request->soldier_name   : '';
            $soldier_rtanumber = isset($request->soldier_rtanumber ) ? $request->soldier_rtanumber   : '';
            $soldier_address = isset($request->soldier_address ) ? $request->soldier_address   : '';
            $soldier_state = isset($request->soldier_state ) ? $request->soldier_state   : '';
            $soldier_intern = isset($request->soldier_intern ) ? $request->soldier_intern  : '';
            $soldier_corp = isset($request->soldier_corp ) ? $request->soldier_corp  : '';
            $soldier_education = isset($request->soldier_education ) ? $request->soldier_education   : '';
            $soldier_skill = isset($request->soldier_skill ) ? $request->soldier_skill    : '';

            $soldier_startdate = isset($request->soldier_startdate  ) ?   $this->dateThaiToeng($request->soldier_startdate)  : null;
            $soldier_enddate = isset($request->soldier_enddate  ) ?   $this->dateThaiToeng($request->soldier_enddate)  : null;
            // $soldier_startdate = isset($request->soldier_startdate  ) ? Carbon::parse($request->soldier_startdate )->format('Y-m-d')   : null;
            // $soldier_enddate = isset($request->soldier_enddate ) ?Carbon::parse($request->soldier_enddate )->format('Y-m-d')  : null;
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
            $soldier_province=isset($request->soldier_province) ? $request->soldier_province   : '';
            $soldier_amphoe=isset($request->soldier_amphoe) ? $request->soldier_amphoe   : '';
            //

            //เพิ่มล่าสุด 8/11/2566
            $soldier_education_study  =isset($request->soldier_education_study) ? $request->soldier_education_study : '' ;
            $soldier_education_end  =isset($request->soldier_education_end) ? $request->soldier_education_end : '' ;
            $soldier_wantto  =isset($request->soldier_wantto) ? $request->soldier_wantto : '' ;
            $soldier_wantto_about  =isset($request->soldier_wantto_about) ? $request->soldier_wantto_about : '' ;
            $soldier_health  =isset($request->soldier_health) ? $request->soldier_health : '' ;
            $soldier_want_nco  =isset($request->soldier_want_nco) ? $request->soldier_want_nco : '' ;
            $soldier_want_skill  =isset($request->soldier_want_skill) ? $request->soldier_want_skill : '' ;
            $soldier_disease  =isset($request->soldier_disease) ? $request->soldier_disease : '' ;
            $soldier_disease_about  =isset($request->soldier_disease_about) ? $request->soldier_disease_about : '' ;
            $soldier_relative_name1  =isset($request->soldier_relative_name1) ? $request->soldier_relative_name1 : '' ;
            $soldier_relative_phone1  =isset($request->soldier_relative_phone1) ? $request->soldier_relative_phone1 : '' ;
            $soldier_relative_add1  =isset($request->soldier_relative_add1) ? $request->soldier_relative_add1 : '' ;
            $soldier_relative_name2  =isset($request->soldier_relative_name2) ? $request->soldier_relative_name2 : '' ;
            $soldier_relative_phone2  =isset($request->soldier_relative_phone2) ? $request->soldier_relative_phone2 : '' ;
            $soldier_relative_add2  =isset($request->soldier_relative_add2) ? $request->soldier_relative_add2 : '' ;
            $soldier_job =isset($request->soldier_job) ? $request->soldier_job : '' ;
            $soldier_startdate_text =isset($request->soldier_startdate_text) ? $request->soldier_startdate_text : '' ;
            $soldier_enddate_text =isset($request->soldier_enddate_text) ? $request->soldier_enddate_text : '' ;
            $soldier_course_have =isset($request->soldier_course_have) ? $request->soldier_course_have: '' ;

            //ตัวแปรค้นหา
            $soldier_provinces  =isset($request->soldier_provinces) ? $request->soldier_provinces : '' ;
            //กรณีแก้ไข เลยอ้างอิงจากชื่อ




        $chk =false;


        if($soldier){
            Soldier::where('soldier_id','=',$soldier_id)->update([

                "soldier_id" => $soldier_id
                ,"soldier_name" => $soldier_name
                ,"soldier_rtanumber" => $soldier_rtanumber
                ,"soldier_address" => $soldier_address
                ,"soldier_job" => $soldier_job
                ,"soldier_intern" =>$soldier_intern
                ,"soldier_corp" => $soldier_corp
                ,"soldier_province" => $soldier_province
                ,"soldier_amphoe" => $soldier_amphoe
                ,"soldier_education" =>$soldier_education
                ,'soldier_education_study'=>$soldier_education_study
                ,'soldier_education_end'=>$soldier_education_end
                ,"soldier_skill" => $soldier_skill
                ,"soldier_startdate_text" => $soldier_startdate_text
                ,"soldier_enddate_text" => $soldier_enddate_text
                ,"soldier_phone" => $soldier_phone
                ,"soldier_about" => $soldier_about
                ,'soldier_wantto'=>$soldier_wantto
                ,'soldier_wantto_about'=>$soldier_wantto_about
                ,'soldier_health'=>$soldier_health
                ,'soldier_want_nco'=>$soldier_want_nco

                 , 'soldier_want_skill'=>$soldier_want_skill
                 , 'soldier_disease'=>$soldier_disease
                 , 'soldier_disease_about'=>$soldier_disease_about
                 , 'soldier_relative_name1'=>$soldier_relative_name1
                 , 'soldier_relative_phone1'=>$soldier_relative_phone1
                 , 'soldier_relative_add1'=>$soldier_relative_add1
                 , 'soldier_relative_name2'=>$soldier_relative_name2
                 , 'soldier_relative_phone2'=>$soldier_relative_phone2
                 , 'soldier_relative_add2'=>$soldier_relative_add2
                 ,'soldier_course_have'=> $soldier_course_have
                 ,'soldier_course'=> $soldier_course
                 ,'soldiers_teacher'=> $soldiers_teacher
                 ,'soldiers_term'=> $soldiers_term
                 , 'soldiers_now'=> $soldiers_now

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

                // $page = isset($request->page) ? $request->page  : '';
                // $search = isset($request->search) ? $request->search  : '';
                // $soldier_dep_id = isset($request->soldier_dep_id) ? $request->soldier_dep_id : '';

                // $url='/soldier/all?';
                // $url .=isset($page)? 'page='.$page :'';
                // $url .=isset($search) ? '&search='.$search : '' ;
                // $url .=isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' ;
                // $url .=isset($soldier_provinces) ? '&soldier_provinces='. iconv('Windows-1250', 'UTF-8',$soldier_provinces) : '' ;

                //    dd($url);
                // return redirect($url  )->with("success","อัพเดทข้อมูลเรียบร้อย");
                 return redirect()->back()->with("success","อัพเดทข้อมูลเรียบร้อย");




            }else{

                return with("error","ไม่ลบสามารถบันทึกข้อมูลได้");
            }
            // return redirect()->route('department')->with("success","อัพเดทข้อมูลเรียบร้อย");
        }

        public static function  dateThaiToeng($strdate=""){

            $d1 = substr($strdate, 0, 2);
            $m1 = substr($strdate, 3, 2);
            $y = substr($strdate, 6, 4) ;
            $y1 = $y-543;
            $h1 = substr($strdate, 10, 6);
            $_date="";

            if ($strdate == ""){
                $_date="";
            } else {
                $_date=$y1 . "-" . $m1 . "-" . $d1;
            }
            return  $_date;
            }

}
