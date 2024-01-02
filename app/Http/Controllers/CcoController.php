<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Department;
use App\Models\Nco;
use App\Models\Ans;
use App\Models\Cco;
use App\Models\Rank;
use App\Models\Tambon;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Arrays;
use DB;
use Image;

class CcoController extends Controller
{
    public function index(Request $request){



                $search   =isset($request->search) ? $request->search : '' ;
                //  dd($request->all());
                //  รับจากหน้า index ที่ selecd มา
                $cco_dep_id     =isset($request->cco_dep_id) ? $request->cco_dep_id : '' ;
                $cco_rank =isset($request->cco_rank ) ? $request->cco_rank  : '' ;
                $cco_ranknco =0;
                $cco_provinces  =isset($request->cco_provinces) ? $request->cco_provinces : '' ;
                $cco_education =isset($request->cco_education) ? $request->cco_education : '' ;
                $cco_disease =isset($request->cco_disease) ? $request->cco_disease : '' ;
                $cco_amphoe =isset($request->cco_amphoe) ? $request->cco_amphoe : '' ;
                $cco_wantto =isset($request->cco_wantto) ? $request->cco_wantto : '' ;

                // เช็ค สิทธิ์ login
                $user_id = Auth::user()->id;
                $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

                $DepArr =Array();
                foreach($userdep as $key =>$row){
                    $DepArr[]=$row->dep_id;
                }
                // ลิส table
                $cco= Cco::where('cco_id','!=','')

                // ->where(function($query) use ($cco_ranknco){
                //     if($cco_ranknco!=''){
                //         $query->where('cco_rank_index','=',);
                //     }

                // })

                ->where(function($query) use ($DepArr){
                         if($DepArr){
                             $query->whereIn('cco_dep_id',$DepArr);
                         }

                  })
                  // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
                  ->where(function($query) use ($cco_dep_id){
                     if($cco_dep_id!=''){
                         $query->where('cco_dep_id','=',$cco_dep_id);
                     }

                 })
                 ->where(function($query) use ($cco_rank){
                    if($cco_rank!=''){
                        $query->where('cco_rank','=',$cco_rank);
                    }

                })

                 ->where(function($query) use ($cco_provinces){
                     if($cco_provinces!=''){
                         $query->where('cco_province','=',$cco_provinces);
                     }

                 })
                 ->where(function($query) use ($cco_amphoe){
                    if($cco_amphoe!=''){
                        $query->where('cco_amphoe','=',$cco_amphoe);
                    }

                })
                 ->where(function($query) use ($cco_wantto){
                     if($cco_wantto!=''){
                         $query->where('cco_wantto','=',$cco_wantto);
                     }

                 })
                 ->where(function($query) use ($cco_disease){
                     if($cco_disease!=''){
                         $query->where('cco_disease','=',$cco_disease);
                     }

                 })

                 ->where(function($query) use ($search){
                     if($search !=''){
                         //ตัวแรก where ตามด้วย orwhere
                         $query->where('cco_name', 'like','%'.$search.'%')
                         ->orwhere('cco_id', 'like','%'.$search.'%')
                         ->orwhere('cco_rank', 'like','%'.$search.'%')
                         ->orwhere('cco_dep_name', 'like','%'.$search.'%')
                         ->orwhere('cco_bat_name', 'like','%'.$search.'%')
                         ->orwhere('cco_rtanumber', 'like','%'.$search.'%')
                         ->orwhere('cco_intern', 'like','%'.$search.'%')
                         ->orwhere('cco_corp', 'like','%'.$search.'%')
                         ->orwhere('cco_job', 'like','%'.$search.'%')
                         ->orwhere('cco_education', 'like','%'.$search.'%')
                         ->orwhere('cco_education_study', 'like','%'.$search.'%')
                         ->orwhere('cco_wantto', 'like','%'.$search.'%')
                         ->orwhere('cco_wantto_about', 'like','%'.$search.'%')
                         ->orwhere('cco_skill_work', 'like','%'.$search.'%')
                         ->orwhere('cco_wife_name', 'like','%'.$search.'%')
                         ->orwhere('cco_child_name1', 'like','%'.$search.'%')
                         ->orwhere('cco_child_name2', 'like','%'.$search.'%')
                         ->orwhere('cco_child_name3', 'like','%'.$search.'%')
                         ->orwhere('cco_child_name4', 'like','%'.$search.'%')
                         ->orwhere('cco_child_name5', 'like','%'.$search.'%')
                         ->orwhere('cco_skill', 'like','%'.$search.'%');

                     }
                     })
                     // ->dd()
                    // ->orderBy('soldier_intern')
                    //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
                    // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
                    // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
                    ->orderBy('cco_rank_index','desc')
                    ->orderBy('cco_name')
                     // ->orderBy('created_at','desc')
                     ->paginate(15);





          $Department=Department::select('dep_id')
            //->selectRaw('ใส่sql ตรงๆเลย')
            // ->where('nco_rank_index','=',0)
            ->selectRaw('min(departments.dep_index)dep_index')
            ->selectRaw('min(department_name)department_name')
            ->selectRaw("SUM(CASE WHEN cco_dep_id != '' THEN 1 ELSE 0 END) AS total")
            //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
            ->leftJoin("ccos", "ccos.cco_dep_id", "=", "departments.dep_id")
            //->where('soldier_dep_id','!=',)
            ->groupBy('dep_id')
            ->orderBy('dep_index')
            //->dd()
            ->get();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','=',1)->orderby('nco_rank_index')->get();

            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $provinces = Cco::selectRaw('cco_province as province')->where('cco_province','!=','')->distinct()->get();

            $total_cco= Cco::where('cco_id','!=','')->count();

            if($cco_dep_id!=''){
                $ans = Ans::where('ans_id','!=','')
                ->where('ans_name','=','ข้อมูลนายทหาร')
                    ->where(function($query) use ($cco_dep_id){
                        if($cco_dep_id!=''){
                            $query->where('ans_dep_id','=',$cco_dep_id);
                        }

                    })->orderBy('ans_index')->get();
                    }else{
                        $ans=null;
                    }

                    // dd($ans);

        return view('admin.cco.index',compact('cco','Department','total_cco','cco_dep_id','cco_provinces','cco_education','cco_disease','provinces','rank','cco_rank','search','amphoes','cco_amphoe','cco_wantto','ans'));
    }

    public function edit(Request $request,$cco_id){

        //    dd($request->all());
            $page = isset($request->page)? $request->page : '';
            $search = isset($request->search) ? $request->search  : '';
            $cco_dep_id = isset($request->cco_dep_id) ? $request->cco_dep_id : '';
            $cco_provinces  =isset($request->cco_provinces) ? $request->cco_provinces : '' ;
            $cco_rank =isset($request->cco_rank ) ? $request->cco_rank  : '' ;
            $cco_amphoe=isset($request->cco_amphoe) ? $request->cco_amphoe : '' ;
            $provinces = Tambon::select('province')->distinct()->get();
            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $cco= Cco::where('cco_id','=',$cco_id)->first();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','=',1)->orderby('nco_rank_index')->get();



    // dd($soldier_provinces);

            return view('admin.cco.edit',compact('page','cco','provinces','amphoes','cco_provinces','rank','cco_rank','cco_dep_id','search','cco_amphoe'));



    }

    /////////////////////////////////////////////////////// แอดข้อมูล/////////////////////////////////////////////
    public function store( Request $request){

            //   dd($request->all());
            // เช็คก่อนเอาเข้า
        $request->validate([

          // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'

            'cco_id'=>'required|unique:ccos|max:10'
            ,'cco_name'=>'required|unique:ccos|max:255'
            ,'cco_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
        ],
        [
            'cco_name.required'=>"กรุณาป้อนชื่อกำลังพลด้วยครับ",
            'cco_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'cco_name.unique'=>"มีข้อมูลชื่อกำลังพลในฐานข้อมูลแล้ว",
            // 'soldier_image.required' => "กรุณาใส่ภาพประกอบ",
            'cco_id.required'=>"กรุณาป้อนเลขประจำตัวทหารด้วยครับด้วยครับ",
            'cco_id.max'=>"ห้ามป้อนตัวอักษรเกิน 10",
            'cco_id.unique'=>"มีเลขประจำตัวประชาชนในฐานข้อมูลแล้ว",
        ]
    );

    //บันทึกข้อมูล

    $cco_name   =isset($request->cco_name) ? $request->cco_name : '' ;
    $cco_id   =isset($request->cco_id) ? $request->cco_id : '' ;
    $nco_rank_index =isset($request->cco_rank) ? $request->cco_rank : '' ;
    $cco_dep_id   =isset($request->cco_dep_id) ? $request->cco_dep_id : '' ;
    $act=false;
    $created_at=Carbon::now()->format("Y-m-d H:i:s");
    $updated_at =Carbon::now()->format("Y-m-d H:i:s");

    $cco_rank_name=Rank::where('nco_rank_index','=',$nco_rank_index)->first();
    // dd( $cco_rank_name->rank_name);
    $Dep=Department::where('dep_id','=',$cco_dep_id)->first();

    $cco_dep_name      =$Dep->department_name;
    $cco_bat_id        =$Dep->battalion_id ;
    $cco_bat_name      =$Dep->battalion_name;
    $cco_year   =Carbon::now()->format("Y");

    $act =Cco::insert([
        'cco_name'=>$cco_name,
        'cco_rank'=>$cco_rank_name->rank_name,
        'cco_rank_index'=>$nco_rank_index,
        'cco_id'=>$cco_id,
        'cco_dep_id'=>$cco_dep_id,

        'created_at'=>$created_at,
        'updated_at'=>$updated_at
        ,'cco_dep_name'=>$cco_dep_name
        ,'cco_bat_id'=>$cco_bat_id
        ,'cco_bat_name'=>$cco_bat_name
        ,'cco_year'=>$cco_year

    ]);

//dd($act);
    if($act){


    //การเข้ารหัสรูปภาพ
    $cco_image = $request->file('nco_image');
    if($cco_image){
    // gen ชื่อภาพ
    $name_gen = hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($cco_image->getClientOriginalExtension());

    //ขื่อไฟล์ภาพ ภาพ
    $img_name = $name_gen.'.'.$img_ext;

    //อัพโหลดภาพ และบันทึกข้อมูล
    $upload_location = 'image/cco/'.$cco_year.'/'.$cco_dep_id.'/';
    if (!File::exists('image/cco/'.$cco_year)) {

        // mkdir($upload_location, 0755, true);
        File::makeDirectory('image/cco/'.$cco_year, 0755, true);
        File::makeDirectory($upload_location, 0755, true);
    }
    $full_path = $upload_location.$img_name;
   // dd($full_path);

    Nco::where('cco_id','=',$cco_id)->update([
        'cco_image'=>$full_path,

    ]);

  $cco_image->move($upload_location,$img_name);

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


          $rankcco = Rank::where('rank_id','!=','')->where('cco_rank_index','=',1)->orderby('nco_rank_index')->get();
          return view('admin.cco.add',compact('Department','rankcco'));
         }







         public function delete($cco_id){
            $act=true;
            $cco_id  =isset($cco_id) ? $cco_id : '' ;

            $delete = Cco::Where('cco_id','=',$cco_id)->Delete();
            if($delete){
                return redirect()->back()->with("success","ลบข้อมูลถาวรเรียบร้อย");
            } else{
                return redirect()->back()->with("error","ไม่ลบสามารถลบข้อมูลได้");
            }
        }



/////////////////////////////////////////////////////// อัพเดทข้อมูล/////////////////////////////////////////////
        public function update(Request $request,$dep_id){
                    // dd( $request->All());
            $request->validate([

                'cco_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
              ],[
                'cco_image.max' => "ขนาดไฟล์เกิน 2 MB ครับ",
              ]

              );

               //ค้นหา
            //ตัวแปรค้นหา
        $cco_provinces  =isset($request->cco_provinces) ? $request->cco_provinces : '' ;
        $page = isset($request->page) ? $request->page  : '';
        $search = isset($request->search) ? $request->search  : '';
        $cco_dep_id = isset($request->cco_dep_id) ? $request->cco_dep_id : '';

        //เซ็ทค่า การนำข้อมูลเข้า เบสิค
        $old_image = isset($request->old_image) ? $request->old_image  : '';
        // dd( $old_image);
        //หาแรงค์


        $cco_id = isset($request->cco_id ) ? $request->cco_id   : '';

        $cco_rank_index = isset($request->cco_rank_index ) ? $request->cco_rank_index   : 0;
        $cco_rank = isset($request->cco_rank ) ? $request->cco_rank   : '';
        $cco_name=isset($request->cco_name) ? $request->cco_name   : '';
        $cco_image =isset($request->cco_image) ? $request->cco_image   : '';
        $cco_rtanumber = isset($request->cco_rtanumber ) ? $request->cco_rtanumber   : '';
        $cco_address = isset($request->cco_address ) ? $request->cco_address   : '';
        $cco_intern = isset($request->cco_intern ) ? $request->cco_intern : '';
        $cco_corp = isset($request->cco_corp ) ? $request->cco_corp   : '';
        $cco_startdate = isset($request->cco_startdate  ) ?   $this->dateThaiToeng($request->cco_startdate)  : null;
        $cco_phone = isset($request->cco_phone) ? $request->cco_phone : '';
        $cco_about = isset($request->cco_about) ? $request->cco_about   : '';
        $cco_education=isset($request->cco_education) ? $request->cco_education   : '';
        $cco_job=isset($request->cco_job) ? $request->cco_job   : '';
        //เพิ่มครั้งที่ 2
        $cco_education_study=isset($request->cco_education_study) ? $request->cco_education_study  : '';
        $cco_wantto=isset($request->cco_wantto) ? $request->cco_wantto  : '';
        $cco_wantto_about=isset($request->cco_wantto_about) ? $request->cco_wantto_about  : '';
        $cco_health=isset($request->cco_health) ? $request->cco_health  : '';
        $cco_health_about=isset($request->cco_health_about) ? $request->cco_health_about  : '';
        $cco_skill_work=isset($request->cco_skill_work) ? $request->cco_skill_work  : '';
        $cco_skill=isset($request->cco_skill) ? $request->cco_skill  : '';
        $cco_wife_name=isset($request->cco_wife_name) ? $request->cco_wife_name   : '';
        $cco_child_name1=isset($request->cco_child_name1) ? $request->cco_child_name1   : '';
        $cco_child_name2=isset($request->cco_child_name2) ? $request->cco_child_name2   : '';
        $cco_child_name3=isset($request->cco_child_name3) ? $request->cco_child_name3   : '';
        $cco_child_name4=isset($request->cco_child_name4) ? $request->cco_child_name4   : '';
        $cco_child_name5=isset($request->cco_child_name5) ? $request->cco_child_name5   : '';


        // อันนี้ใช้แทนมีหรือไม่มี
        $cco_sick_have= isset($request->cco_sick_have) ? $request->cco_sick_have  : '';
        // อันนี้ใช้แทนอาการ
        $cco_sick= isset($request->cco_sick) ? $request->cco_sick   : '';
        //  dd($soldier_id);

        $chk =false;
        $cco =Cco::where('cco_id','=', $cco_id)->first();

        //ดึงค่า index

        $cco_rank = isset($request->cco_rank ) ? $request->cco_rank   : '';

        $cco_rank_iput_name=Rank::where('rank_name','=',$cco_rank )->first();
        $cco_rank_index = isset($cco_rank_iput_name->nco_rank_index ) ? $cco_rank_iput_name->nco_rank_index   : 0;



        $cco_year =$cco->cco_year;
        $cco_dep_id=$cco->cco_dep_id;
        $cco_province=isset($request->cco_province) ? $request->cco_province   : '';
        $cco_amphoe=isset($request->cco_amphoe) ? $request->cco_amphoe   : '';

        if($cco){
            Cco::where('cco_id','=',$cco_id)->update([

                "cco_id" => $cco_id
                ,"cco_rank" => $cco_rank
                ,"cco_rank_index" => $cco_rank_index
                ,"cco_name" => $cco_name
                ,"cco_rtanumber" => $cco_rtanumber
                ,"cco_address" => $cco_address
                ,"cco_intern" =>$cco_intern
                ,"cco_corp" => $cco_corp
                ,"cco_startdate" => $cco_startdate
                ,"cco_phone" => $cco_phone
                ,"cco_about" => $cco_about
                ,'cco_job'=>$cco_job

                ,"cco_education" => $cco_education
                ,"cco_education_study" => $cco_education_study
                ,"cco_wantto" => $cco_wantto
                ,'cco_wantto_about'=>$cco_wantto_about
                ,"cco_health" => $cco_health
                ,"cco_health_about" => $cco_health_about
                ,"cco_skill_work" => $cco_skill_work
                ,"cco_skill" => $cco_skill
                ,"cco_wife_name" => $cco_wife_name
                ,"cco_child_name1" => $cco_child_name1
                ,"cco_child_name2" => $cco_child_name2
                ,"cco_child_name3" => $cco_child_name3
                ,"cco_child_name4" => $cco_child_name4
                ,"cco_child_name5" => $cco_child_name5



                 ,"cco_province" => $cco_province
                 ,"cco_amphoe" => $cco_amphoe


            ]);
        }

        // อัพเดทภาพ
        $update_image = $request->file('cco_image');

        if($update_image &&  $cco )
            {

                // gen ชื่อภาพ
                $name_gen = hexdec(uniqid());

                //ดึงนามสกุลไฟล์ภาพ
                $img_ext = strtolower($cco_image->getClientOriginalExtension());

                //ดึงนามสกุลไฟล์ภาพ ภาพ
                $img_name = $name_gen.'.'.$img_ext;

                //อัพโหลดภาพ และอัพเดทข้อมูล
                $upload_location = 'image/cco/'.$cco_year.'/'.$cco_dep_id.'/';

                //ต้องการเช็ตpath ก่อน ถ้าไม่มีให้สร้าง
                if (!File::exists('image/cco/'.$cco_year)) {

                    // mkdir($upload_location, 0755, true);
                    File::makeDirectory('image/cco/'.$cco_year, 0755, true);
                    File::makeDirectory($upload_location, 0755, true);
                }

                $full_path = $upload_location.$img_name;

                //ลบภาพเก่าและอัพภาพใหม่แทนที่
                $old_image = $request->old_image;
                //   if($old_image){
                //   unlink($old_image);}
                $cco_image->move($upload_location,$img_name);
                // $img = Image::make($soldier_image->path());
                // $act = $img->resize(400, 600, function ($const) {
                //     $const->aspectRatio();
                // })->save($full_path);
                $chk = True;

                Cco::where('cco_id','=',$cco_id)->update([
                    'cco_image'=> $full_path

                ]);



            }

            if($chk= true)

            {

                // $page = isset($request->page) ? $request->page  : '';
                // $search = isset($request->search) ? $request->search  : '';
                // $soldier_dep_id = isset($request->soldier_dep_id) ? $request->soldier_dep_id : '';

                $url='/cco/all?';
                $url .=isset($page)? 'page='.$page :'';
                $url .=isset($search) ? '&search='.$search : '' ;
                $url .=isset($nco_dep_id) ? '&cco_dep_id='.$cco_dep_id : '' ;
                $url .=isset($request->cco_rank ) ? $request->cco_rank  : '' ;
                $url .=isset($cco_provinces) ? '&cco_provinces='. iconv('Windows-1250', 'UTF-8',$cco_provinces) : '' ;

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
