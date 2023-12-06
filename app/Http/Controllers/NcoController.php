<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Department;
use App\Models\Nco;
use App\Models\Rank;
use App\Models\Tambon;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Arrays;
use DB;
use Image;

class NcoController extends Controller
{
    public function index(Request $request){



                $search   =isset($request->search) ? $request->search : '' ;
                //  dd($request->all());
                //  รับจากหน้า index ที่ selecd มา
                $nco_dep_id     =isset($request->nco_dep_id) ? $request->nco_dep_id : '' ;
                $nco_rank =isset($request->nco_rank ) ? $request->nco_rank  : '' ;
                $nco_ranknco =0;
                $nco_provinces  =isset($request->nco_provinces) ? $request->nco_provinces : '' ;
                $nco_education =isset($request->nco_education) ? $request->nco_education : '' ;
                $nco_disease =isset($request->nco_disease) ? $request->nco_disease : '' ;
                $nco_amphoe =isset($request->nco_amphoe) ? $request->nco_amphoe : '' ;

                // เช็ค สิทธิ์ login
                $user_id = Auth::user()->id;
                $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

                $DepArr =Array();
                foreach($userdep as $key =>$row){
                    $DepArr[]=$row->dep_id;
                }
                // ลิส table
                $nco= Nco::where('nco_id','!=','')

                // ->where(function($query) use ($nco_ranknco){
                //     if($nco_ranknco!=''){
                //         $query->where('nco_rank_index','=',0);
                //     }

                // })

                ->where(function($query) use ($DepArr){
                         if($DepArr){
                             $query->whereIn('nco_dep_id',$DepArr);
                         }

                  })
                  // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
                  ->where(function($query) use ($nco_dep_id){
                     if($nco_dep_id!=''){
                         $query->where('nco_dep_id','=',$nco_dep_id);
                     }

                 })
                 ->where(function($query) use ($nco_rank){
                    if($nco_rank!=''){
                        $query->where('nco_rank','=',$nco_rank);
                    }

                })

                 ->where(function($query) use ($nco_provinces){
                     if($nco_provinces!=''){
                         $query->where('nco_province','=',$nco_provinces);
                     }

                 })
                 ->where(function($query) use ($nco_amphoe){
                     if($nco_amphoe!=''){
                         $query->where('nco_amphoe','=',$nco_amphoe);
                     }

                 })
                 ->where(function($query) use ($nco_education){
                     if($nco_education!=''){
                         $query->where('nco_education','=',$nco_education);
                     }

                 })
                 ->where(function($query) use ($nco_disease){
                     if($nco_disease!=''){
                         $query->where('nco_disease','=',$nco_disease);
                     }

                 })

                 ->where(function($query) use ($search){
                     if($search !=''){
                         //ตัวแรก where ตามด้วย orwhere
                         $query->where('nco_name', 'like','%'.$search.'%')
                         ->orwhere('nco_id', 'like','%'.$search.'%')
                         ->orwhere('nco_dep_name', 'like','%'.$search.'%')
                         ->orwhere('nco_bat_name', 'like','%'.$search.'%')
                         ->orwhere('nco_rtanumber', 'like','%'.$search.'%')
                         ->orwhere('nco_intern', 'like','%'.$search.'%')
                         ->orwhere('nco_province', 'like','%'.$search.'%');

                     }
                     })
                     // ->dd()
                    // ->orderBy('soldier_intern')
                    //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
                    // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
                    // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
                     ->orderBy('nco_name')
                     // ->orderBy('created_at','desc')
                     ->paginate(15);





          $Department=Department::select('dep_id')
            //->selectRaw('ใส่sql ตรงๆเลย')
            ->where('nco_rank_index','=',0)
            ->selectRaw('min(departments.dep_index)dep_index')
            ->selectRaw('min(department_name)department_name')
            ->selectRaw("SUM(CASE WHEN nco_dep_id != '' THEN 1 ELSE 0 END) AS total")
            //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
            ->leftJoin("ncos", "ncos.nco_dep_id", "=", "departments.dep_id")
            //->where('soldier_dep_id','!=',)
            ->groupBy('dep_id')
            ->orderBy('dep_index')
            //->dd()
            ->get();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','=',0)->orderby('nco_rank_index')->get();

            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $provinces = Nco::selectRaw('nco_province as province')->where('nco_province','!=','')->distinct()->get();

            $total_nco= Nco::where('nco_id','!=','')->count();



        return view('admin.nco.index',compact('nco','Department','total_nco','nco_dep_id','nco_provinces','nco_education','nco_disease','provinces','rank','nco_rank','search','nco_amphoe','amphoes' ));
    }

    public function edit(Request $request,$nco_id){

        //    dd($request->all());
            $page = isset($request->page)? $request->page : '';
            $search = isset($request->search) ? $request->search  : '';
            $nco_dep_id = isset($request->nco_dep_id) ? $request->nco_dep_id : '';
            $nco_provinces  =isset($request->nco_provinces) ? $request->nco_provinces : '' ;
            $nco_rank =isset($request->nco_rank ) ? $request->nco_rank  : '' ;
            $nco_amphoe=isset($request->nco_amphoe) ? $request->nco_amphoe : '' ;
            $provinces = Tambon::select('province')->distinct()->get();
            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $nco= Nco::where('nco_id','=',$nco_id)->first();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','=',0)->orderby('nco_rank_index')->get();



    // dd($soldier_provinces);

            return view('admin.nco.edit',compact('page','nco','provinces','amphoes','nco_provinces','rank','nco_rank','nco_amphoe'));



    }

    /////////////////////////////////////////////////////// แอดข้อมูล/////////////////////////////////////////////
    public function store( Request $request){

            // dd($request->all());
            // เช็คก่อนเอาเข้า
        $request->validate([

          // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'

            'nco_id'=>'required|unique:ncos|max:10'
            ,'nco_name'=>'required|unique:ncos|max:255'
            ,'nco_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
        ],
        [
            'nco_name.required'=>"กรุณาป้อนชื่อกำลังพลด้วยครับ",
            'nco_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'nco_name.unique'=>"มีข้อมูลชื่อกำลังพลในฐานข้อมูลแล้ว",
            // 'soldier_image.required' => "กรุณาใส่ภาพประกอบ",
            'nco_id.required'=>"กรุณาป้อนเลขประจำตัวทหารด้วยครับด้วยครับ",
            'nco_id.max'=>"ห้ามป้อนตัวอักษรเกิน 10",
            'nco_id.unique'=>"มีเลขประจำตัวประชาชนในฐานข้อมูลแล้ว",
        ]
    );

    //บันทึกข้อมูล

    $nco_name   =isset($request->nco_name) ? $request->nco_name : '' ;
    $nco_id   =isset($request->nco_id) ? $request->nco_id : '' ;
    $nco_rank =isset($request->nco_rank) ? $request->nco_rank : '' ;
    $nco_dep_id   =isset($request->nco_dep_id) ? $request->nco_dep_id : '' ;
    $act=false;
    $created_at=Carbon::now()->format("Y-m-d H:i:s");
    $updated_at =Carbon::now()->format("Y-m-d H:i:s");

    $Dep=Department::where('dep_id','=',$nco_dep_id)->first();

    $nco_dep_name      =$Dep->department_name;
    $nco_bat_id        =$Dep->battalion_id ;
    $nco_bat_name      =$Dep->battalion_name;
    $nco_year   =Carbon::now()->format("Y");

    $nco_rank  = isset($request->nco_rank  ) ? $request->nco_rank   : '';

    $nco_rank_iput_name=Rank::where('rank_name','=',$nco_rank  )->first();
    $nco_rank_index = isset($nco_rank_iput_name->nco_rank_index ) ? $nco_rank_iput_name->nco_rank_index   : 0;

    $act =Nco::insert([
        'nco_name'=>$nco_name,
        'nco_rank'=>$nco_rank,
        'nco_id'=>$nco_id,
        'nco_rank_index'=>$nco_rank_index,
        'nco_dep_id'=>$nco_dep_id,
        'created_at'=>$created_at,
        'updated_at'=>$updated_at
        ,'nco_dep_name'=>$nco_dep_name
        ,'nco_bat_id'=>$nco_bat_id
        ,'nco_bat_name'=>$nco_bat_name
        ,'nco_year'=>$nco_year

    ]);

//dd($act);
    if($act){


    //การเข้ารหัสรูปภาพ
    $nco_image = $request->file('nco_image');
    if($nco_image){
    // gen ชื่อภาพ
    $name_gen = hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($nco_image->getClientOriginalExtension());

    //ขื่อไฟล์ภาพ ภาพ
    $img_name = $name_gen.'.'.$img_ext;

    //อัพโหลดภาพ และบันทึกข้อมูล
    $upload_location = 'image/nco/'.$nco_year.'/'.$nco_dep_id.'/';
    if (!File::exists('image/nco/'.$nco_year)) {

        // mkdir($upload_location, 0755, true);
        File::makeDirectory('image/nco/'.$nco_year, 0755, true);
        File::makeDirectory($upload_location, 0755, true);
    }
    $full_path = $upload_location.$img_name;
   // dd($full_path);

    Nco::where('nco_id','=',$nco_id)->update([
        'nco_image'=>$full_path,

    ]);

  $nco_image->move($upload_location,$img_name);

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

          $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','=',0)->orderby('nco_rank_index')->get();
          $rankcco = Rank::where('rank_id','!=','')->where('cco_rank_index','=',1)->orderby('nco_rank_index')->get();
          return view('admin.nco.add',compact('Department','rank','rankcco'));
         }







         public function delete($nco_id){
            $act=true;
            $nco_id  =isset($nco_id) ? $nco_id : '' ;

            $delete = Nco::Where('nco_id','=',$nco_id)->Delete();
            if($act){
                return redirect()->back()->with("success","ลบข้อมูลถาวรเรียบร้อย");
            } else{
                return redirect()->back()->with("error","ไม่ลบสามารถลบข้อมูลได้");
            }
        }


/////////////////////////////////////////////////////// อัพเดทข้อมูล/////////////////////////////////////////////
        public function update(Request $request,$dep_id){
                //    dd( $request->All());
            $request->validate([

                'nco_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
              ],[
                'nco_image.max' => "ขนาดไฟล์เกิน 2 MB ครับ",
              ]

              );

               //ค้นหา
            //ตัวแปรค้นหา
        $nco_provinces  =isset($request->nco_provinces) ? $request->nco_provinces : '' ;
        $page = isset($request->page) ? $request->page  : '';
        $search = isset($request->search) ? $request->search  : '';
        $nco_dep_id = isset($request->nco_dep_id) ? $request->nco_dep_id : '';

        //เซ็ทค่า การนำข้อมูลเข้า เบสิค
        $old_image = isset($request->old_image) ? $request->old_image  : '';
        // dd( $old_image);
        $nco_id = isset($request->nco_id ) ? $request->nco_id   : '';


        $nco_name=isset($request->nco_name) ? $request->nco_name   : '';
        $nco_image =isset($request->nco_image) ? $request->nco_image   : '';
        $nco_rtanumber = isset($request->nco_rtanumber ) ? $request->nco_rtanumber   : '';
        $nco_address = isset($request->nco_address ) ? $request->nco_address   : '';
        $nco_intern = isset($request->nco_intern ) ? $request->nco_intern : '';
        $nco_corp = isset($request->nco_corp ) ? $request->nco_corp   : '';
        $nco_startdate = isset($request->nco_startdate  ) ?   $this->dateThaiToeng($request->nco_startdate)  : null;
        $nco_phone = isset($request->nco_phone) ? $request->nco_phone : '';
        $nco_about = isset($request->nco_phone) ? $request->nco_phone   : '';
         //เพิ่มครั้งที่ 2
         $nco_education=isset($request->nco_education) ? $request->nco_education   : '';
         $nco_education_study=isset($request->nco_education_study) ? $request->nco_education_study  : '';
         $nco_wantto=isset($request->nco_wantto) ? $request->nco_wantto  : '';
         $nco_health=isset($request->nco_health) ? $request->nco_health  : '';
         $nco_skill_work=isset($request->nco_skill_work) ? $request->nco_skill_work  : '';
         $nco_skill=isset($request->nco_skill) ? $request->nco_skill  : '';
         $nco_wife_name=isset($request->nco_wife_name) ? $request->nco_wife_name   : '';
         $nco_child_name1=isset($request->nco_child_name1) ? $request->nco_child_name1   : '';
         $nco_child_name2=isset($request->nco_child_name2) ? $request->nco_child_name2   : '';
         $nco_child_name3=isset($request->nco_child_name3) ? $request->nco_child_name3   : '';
         $nco_child_name4=isset($request->nco_child_name4) ? $request->nco_child_name4   : '';
         $nco_child_name5=isset($request->nco_child_name5) ? $request->nco_child_name5   : '';

        // อันนี้ใช้แทนมีหรือไม่มี
        $nco_law_rank= isset($request->nco_law_rank) ? $request->nco_law_rank  : '';
        // อันนี้ใช้แทนอาการ
        $nco_law_parent= isset($request->nco_law_parent) ? $request->nco_law_parent   : '';
      //  dd($soldier_id);

      //ดึงค่า  rank index

      $nco_rank = isset($request->nco_rank ) ? $request->nco_rank   : '';
      $nco_rank_iput_name=Rank::where('rank_name','=',$nco_rank )->first();
      $nco_rank_index = isset($nco_rank_iput_name->nco_rank_index ) ? $nco_rank_iput_name->nco_rank_index   : 0;
    //   dd( $nco_rank_index);

        $chk =false;
        $nco =Nco::where('nco_id','=', $nco_id)->first();

        $nco_year =$nco->nco_year;
        $nco_dep_id=$nco->nco_dep_id;
        $nco_province=isset($request->nco_province) ? $request->nco_province   : '';
        $nco_amphoe=isset($request->nco_amphoe) ? $request->nco_amphoe   : '';

        if($nco){
            Nco::where('nco_id','=',$nco_id)->update([

                "nco_id" => $nco_id
                ,"nco_rank" => $nco_rank
                ,"nco_rank_index" => $nco_rank_index
                ,"nco_name" => $nco_name
                ,"nco_rtanumber" => $nco_rtanumber
                ,"nco_address" => $nco_address
                ,"nco_intern" =>$nco_intern
                ,"nco_corp" => $nco_corp
                ,"nco_startdate" => $nco_startdate
                ,"nco_phone" => $nco_phone
                ,"nco_about" => $nco_about
                ,"nco_law_rank"=> $nco_law_rank
                ,"nco_law_parent"=> $nco_law_parent

                ,"nco_education" => $nco_education
                ,"nco_education_study" => $nco_education_study
                ,"nco_wantto" => $nco_wantto
                ,"nco_health" => $nco_health
                ,"nco_skill_work" => $nco_skill_work
                ,"nco_skill" => $nco_skill
                ,"nco_wife_name" => $nco_wife_name
                ,"nco_child_name1" => $nco_child_name1
                ,"nco_child_name2" => $nco_child_name2
                ,"nco_child_name3" => $nco_child_name3
                ,"nco_child_name4" => $nco_child_name4
                ,"nco_child_name5" => $nco_child_name5


                 ,"nco_province" => $nco_province
                 ,"nco_amphoe" => $nco_amphoe


            ]);
        }

        // อัพเดทภาพ
        $update_image = $request->file('nco_image');

        if($update_image &&  $nco )
            {

                // gen ชื่อภาพ
                $name_gen = hexdec(uniqid());

                //ดึงนามสกุลไฟล์ภาพ
                $img_ext = strtolower($nco_image->getClientOriginalExtension());

                //ดึงนามสกุลไฟล์ภาพ ภาพ
                $img_name = $name_gen.'.'.$img_ext;

                //อัพโหลดภาพ และอัพเดทข้อมูล
                $upload_location = 'image/nco/'.$nco_year.'/'.$nco_dep_id.'/';

                //ต้องการเช็ตpath ก่อน ถ้าไม่มีให้สร้าง
                if (!File::exists('image/nco/'.$nco_year)) {

                    // mkdir($upload_location, 0755, true);
                    File::makeDirectory('image/nco/'.$nco_year, 0755, true);
                    File::makeDirectory($upload_location, 0755, true);
                }

                $full_path = $upload_location.$img_name;

                //ลบภาพเก่าและอัพภาพใหม่แทนที่
                $old_image = $request->old_image;
                //   if($old_image){
                //   unlink($old_image);}
                $nco_image->move($upload_location,$img_name);
                // $img = Image::make($soldier_image->path());
                // $act = $img->resize(400, 600, function ($const) {
                //     $const->aspectRatio();
                // })->save($full_path);
                $chk = True;

                Nco::where('nco_id','=',$nco_id)->update([
                    'nco_image'=> $full_path

                ]);



            }

            if($chk= true)

            {

                // $page = isset($request->page) ? $request->page  : '';
                // $search = isset($request->search) ? $request->search  : '';
                // $soldier_dep_id = isset($request->soldier_dep_id) ? $request->soldier_dep_id : '';

                $url='/nco/all?';
                $url .=isset($page)? 'page='.$page :'';
                $url .=isset($search) ? '&search='.$search : '' ;
                $url .=isset($nco_dep_id) ? '&nco_dep_id='.$nco_dep_id : '' ;
                $url .=isset($request->nco_rank ) ? $request->nco_rank  : '' ;
                $url .=isset($nco_provinces) ? '&nco_provinces='. iconv('Windows-1250', 'UTF-8',$nco_provinces) : '' ;

                //    dd($url);
                // return redirect($url  )->with("success","อัพเดทข้อมูลเรียบร้อย");
                 return redirect()->back()->with("success","อัพเดทข้อมูลเรียบร้อย");




            }else{

                return with("error","ไม่ลบสามารถบันทึกข้อมูลได้");
            }
            // return redirect()->route('department')->with("success","อัพเดทข้อมูลเรียบร้อย");



        }
        public function index2(Request $request){



            $search   =isset($request->search) ? $request->search : '' ;
            //  dd($request->all());
            //  รับจากหน้า index ที่ selecd มา
            $nco_dep_id     =isset($request->nco_dep_id) ? $request->nco_dep_id : '' ;
            $nco_rank =isset($request->nco_rank ) ? $request->nco_rank  : '' ;
            $nco_rankcco = 1;
            $nco_provinces  =isset($request->nco_provinces) ? $request->nco_provinces : '' ;
            $nco_education =isset($request->nco_education) ? $request->nco_education : '' ;
            $nco_disease =isset($request->nco_disease) ? $request->nco_disease : '' ;

            // เช็ค สิทธิ์ login
            $user_id = Auth::user()->id;
            $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

            $DepArr =Array();
            foreach($userdep as $key =>$row){
                $DepArr[]=$row->dep_id;
            }
            // ลิส table
            $nco= Nco::where('nco_id','!=','')

            ->where(function($query) use ($nco_rankcco){
                if($nco_rankcco!=''){
                    $query->where('nco_rank_index','=',1);
                }

            })

            ->where(function($query) use ($DepArr){
                     if($DepArr){
                         $query->whereIn('nco_dep_id',$DepArr);
                     }

              })
              // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
              ->where(function($query) use ($nco_dep_id){
                 if($nco_dep_id!=''){
                     $query->where('nco_dep_id','=',$nco_dep_id);
                 }

             })
             ->where(function($query) use ($nco_rank){
                if($nco_rank!=''){
                    $query->where('nco_rank','=',$nco_rank);
                }

            })

             ->where(function($query) use ($nco_provinces){
                 if($nco_provinces!=''){
                     $query->where('nco_province','=',$nco_provinces);
                 }

             })
             ->where(function($query) use ($nco_education){
                 if($nco_education!=''){
                     $query->where('nco_education','=',$nco_education);
                 }

             })
             ->where(function($query) use ($nco_disease){
                 if($nco_disease!=''){
                     $query->where('nco_disease','=',$nco_disease);
                 }

             })

             ->where(function($query) use ($search){
                 if($search !=''){
                     //ตัวแรก where ตามด้วย orwhere
                     $query->where('nco_name', 'like','%'.$search.'%')
                     ->orwhere('nco_id', 'like','%'.$search.'%')
                     ->orwhere('nco_dep_name', 'like','%'.$search.'%')
                     ->orwhere('nco_bat_name', 'like','%'.$search.'%')
                     ->orwhere('nco_rtanumber', 'like','%'.$search.'%')
                     ->orwhere('nco_intern', 'like','%'.$search.'%')
                     ->orwhere('nco_province', 'like','%'.$search.'%')
                     ->orWhere('nco_state','%'. $search.'%');
                 }
                 })
                 // ->dd()
                // ->orderBy('soldier_intern')
                //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
                // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
                // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
                 ->orderBy('nco_name')
                 // ->orderBy('created_at','desc')
                 ->paginate(15);





      $Department=Department::select('dep_id')
        //->selectRaw('ใส่sql ตรงๆเลย')
        ->where('nco_rank_index','=',1)
        ->selectRaw('min(departments.dep_index)dep_index')
        ->selectRaw('min(department_name)department_name')
        ->selectRaw("SUM(CASE WHEN nco_dep_id != '' THEN 1 ELSE 0 END) AS total")
        //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
        ->leftJoin("ncos", "ncos.nco_dep_id", "=", "departments.dep_id")
        //->where('soldier_dep_id','!=',)
        ->groupBy('dep_id')
        ->orderBy('dep_index')
        //->dd()
        ->get();

        $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','=',1)->orderby('nco_rank_index')->get();



        $provinces = Nco::selectRaw('nco_province as province')->where('nco_province','!=','')->distinct()->get();

        $total_cco= Nco::where('nco_id','!=','')->where('nco_rank_index','=',1)->count();



    return view('admin.cco.index',compact('nco','Department','total_cco','nco_dep_id','nco_provinces','nco_education','nco_disease','provinces','rank','nco_rank' ));
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
