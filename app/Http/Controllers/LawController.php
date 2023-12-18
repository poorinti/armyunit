<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Department;
use App\Models\Nco;
use App\Models\Law;
use App\Models\Rank;
use App\Models\Ans;
use App\Models\Tambon;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Arrays;
use DB;
use Image;

class LawController extends Controller
{
    public function index(Request $request){



                $search   =isset($request->search) ? $request->search : '' ;
                //   dd($request->all());
                //  รับจากหน้า index ที่ selecd มา
                $law_dep_id     =isset($request->law_dep_id) ? $request->law_dep_id : '' ;
                $law_rank =isset($request->law_rank ) ? $request->law_rank  : '' ;
                $law_lawchk=isset($request->law_lawchk ) ? $request->law_lawchk  : '' ;
                $law_ranknco = 1;
                $law_provinces  =isset($request->law_provinces) ? $request->law_provinces : '' ;
                $law_education =isset($request->law_education) ? $request->law_education : '' ;
                $law_disease =isset($request->law_disease) ? $request->law_disease : '' ;
                $law_amphoe=isset($request->law_amphoe) ? $request->law_amphoe : '' ;

                // เช็ค สิทธิ์ login
                $user_id = Auth::user()->id;
                $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

                $DepArr =Array();
                foreach($userdep as $key =>$row){
                    $DepArr[]=$row->dep_id;
                }
                // ลิส table
                $law= Law::where('law_id','!=','')

                ->where(function($query) use ($law_ranknco){
                    if($law_ranknco!=''){
                        $query->where('law_rank_index','<=',2);
                    }

                })

                ->where(function($query) use ($DepArr){
                         if($DepArr){
                             $query->whereIn('law_dep_id',$DepArr);
                         }

                  })
                  // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
                  ->where(function($query) use ($law_dep_id){
                     if($law_dep_id!=''){
                         $query->where('law_dep_id','=',$law_dep_id);
                     }

                 })
                 ->where(function($query) use ($law_rank){
                    if($law_rank!=''){
                        $query->where('law_rank','=',$law_rank);
                    }

                })
                ->where(function($query) use ($law_lawchk){
                    if($law_lawchk!=''){

                          if($law_lawchk=='ม.35(3)'){
                                $query->where('law_index','=',3);
                                }

                          if($law_lawchk=='ม.35(7)'){
                            $query->where('law_index','=',7);
                              }

                          if($law_lawchk=='ไม่เข้าร่วม'){
                            $query->where('law_index','=',9);
                              }

                    }

                })

                 ->where(function($query) use ($law_provinces){
                     if($law_provinces!=''){
                         $query->where('law_province','=',$law_provinces);
                     }

                 })
                 ->where(function($query) use ($law_amphoe){
                    if($law_amphoe!=''){
                        $query->where('law_amphoe','=',$law_amphoe);
                    }

                })

                 ->where(function($query) use ($law_disease){
                     if($law_disease!=''){
                         $query->where('law_disease','=',$law_disease);
                     }

                    })
                 ->where(function($query) use ($search){
                     if($search !=''){
                         //ตัวแรก where ตามด้วย orwhere
                         $query->where('law_name', 'like','%'.$search.'%')
                         ->orwhere('law_id', 'like','%'.$search.'%')
                         ->orwhere('law_dep_name', 'like','%'.$search.'%')
                         ->orwhere('law_bat_name', 'like','%'.$search.'%')
                         ->orwhere('law_rtanumber', 'like','%'.$search.'%')
                         ->orwhere('law_intern', 'like','%'.$search.'%')
                         ->orwhere('law_province', 'like','%'.$search.'%');

                     }
                     })
                     // ->dd()
                    // ->orderBy('soldier_intern')
                    //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
                    // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
                    // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
                     ->orderBy('law_name')
                     // ->orderBy('created_at','desc')
                     ->paginate(15);


          $Department=Department::select('dep_id')
            //->selectRaw('ใส่sql ตรงๆเลย')
            ->where('law_rank_index','<=',2)
            ->selectRaw('min(departments.dep_index)dep_index')
            ->selectRaw('min(department_name)department_name')
            ->selectRaw("SUM(CASE WHEN law_dep_id != '' THEN 1 ELSE 0 END) AS total")
            //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
            ->leftJoin("laws", "laws.law_dep_id", "=", "departments.dep_id")
            //->where('soldier_dep_id','!=',)
            ->groupBy('dep_id')
            ->orderBy('dep_index')
            //->dd()
            ->get();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();

            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $provinces = Law::selectRaw('law_province as province')->where('law_province','!=','')->distinct()->get();

            $total_law= Law::where('law_id','!=','')->count();

            if($law_dep_id!=''){
                $ans = Ans::where('ans_id','!=','')
                ->where('ans_name','=','ข้อมูลพลทหาร')
                    ->where(function($query) use ($law_dep_id){
                        if($law_dep_id!=''){
                            $query->where('ans_dep_id','=',$law_dep_id);
                        }

                    })->orderBy('ans_index')->get();
                    }else{
                        $ans=null;
                    }




        return view('admin.law.index',compact('law','Department','total_law','law_dep_id','law_provinces','law_education','law_disease','provinces','rank','law_rank','law_lawchk','search','amphoes','law_amphoe','ans' ));
    }

    public function edit(Request $request,$law_id){

            //  dd($request->all(),$law_id);
            $page = isset($request->page)? $request->page : '';
            $search = isset($request->search) ? $request->search  : '';
            $law_dep_id = isset($request->law_dep_id) ? $request->law_dep_id : '';
            $law_provinces  =isset($request->law_provinces) ? $request->law_provinces : '' ;
            $law_rank =isset($request->law_rank ) ? $request->law_rank  : '' ;
            $law_lawchk =isset($request->law_lawchk ) ? $request->law_lawchk  : '' ;
            $provinces = Tambon::select('province')->distinct()->get();
            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $law= Law::where('law_id','=',$law_id)->first();
            $nco= Law::where('law_id','=',$law_id)->first();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();



    // dd($soldier_provinces);

            return view('admin.law.edit',compact('page','nco','provinces','amphoes','law_provinces','rank','law_rank','law','law_dep_id','search','law_lawchk'));



    }

    /////////////////////////////////////////////////////// แอดข้อมูล/////////////////////////////////////////////
    public function store( Request $request){

            //  dd($request->all());
            // เช็คก่อนเอาเข้า
        $request->validate([

          // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'

            'law_id'=>'required|unique:laws|max:13'
            ,'law_name'=>'required|unique:laws|max:255'
            ,'law_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
        ],
        [
            'law_name.required'=>"กรุณาป้อนชื่อกำลังพลด้วยครับ",
            'law_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'law_name.unique'=>"มีข้อมูลชื่อกำลังพลในฐานข้อมูลแล้ว",
            // 'soldier_image.required' => "กรุณาใส่ภาพประกอบ",
            'law_id.required'=>"กรุณาป้อนเลขประจำตัวประชาชนด้วยครับด้วยครับ",
            'law_id.max'=>"ห้ามป้อนตัวอักษรเกิน 13",
            'law_id.unique'=>"มีเลขประจำตัวประชาชนในฐานข้อมูลแล้ว",
        ]
    );

    //บันทึกข้อมูล

    $law_name   =isset($request->law_name) ? $request->law_name : '' ;
    $law_id   =isset($request->law_id) ? $request->law_id : '' ;
    $law_rank =isset($request->law_rank) ? $request->law_rank : '' ;
    $law_dep_id   =isset($request->law_dep_id) ? $request->law_dep_id : '' ;
    $act=false;
    $created_at=Carbon::now()->format("Y-m-d H:i:s");
    $updated_at =Carbon::now()->format("Y-m-d H:i:s");

    $Dep=Department::where('dep_id','=',$law_dep_id)->first();

    $law_dep_name      =$Dep->department_name;
    $law_bat_id        =$Dep->battalion_id ;
    $law_bat_name      =$Dep->battalion_name;
    $law_year   =Carbon::now()->format("Y");

    $act =Law::insert([
        'law_name'=>$law_name,
        'law_rank'=>$law_rank,
        'law_id'=>$law_id,
        'law_dep_id'=>$law_dep_id,
        'created_at'=>$created_at,
        'updated_at'=>$updated_at
        ,'law_dep_name'=>$law_dep_name
        ,'law_bat_id'=>$law_bat_id
        ,'law_bat_name'=>$law_bat_name
        ,'law_year'=>$law_year

    ]);

//dd($act);
    if($act){


    //การเข้ารหัสรูปภาพ
    $law_image = $request->file('law_image');
    if($law_image){
    // gen ชื่อภาพ
    $name_gen = hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($law_image->getClientOriginalExtension());

    //ขื่อไฟล์ภาพ ภาพ
    $img_name = $name_gen.'.'.$img_ext;

    //อัพโหลดภาพ และบันทึกข้อมูล
    $upload_location = 'image/law/'.$law_year.'/'.$law_dep_id.'/';
    if (!File::exists('image/law/'.$law_year)) {

        // mkdir($upload_location, 0755, true);
        File::makeDirectory('image/law/'.$law_year, 0755, true);
        File::makeDirectory($upload_location, 0755, true);
    }
    $full_path = $upload_location.$img_name;
   // dd($full_path);

    Law::where('law_id','=',$law_id)->update([
        'law_image'=>$full_path,

    ]);

  $law_image->move($upload_location,$img_name);

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
          $ranklaw = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();
          return view('admin.law.add',compact('Department','rank','rankcco','ranklaw'));
         }







         public function delete($law_id){
            $act=true;

            $law_id  =isset($law_id) ? $law_id : '' ;

            $delete = Law::Where('law_id','=',$law_id)->Delete();
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

                'law_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
              ],[
                'law_image.max' => "ขนาดไฟล์เกิน 2 MB ครับ",
              ]

              );

               //ค้นหา
            //ตัวแปรค้นหา
        $law_provinces  =isset($request->law_provinces) ? $request->law_provinces : '' ;
        $page = isset($request->page) ? $request->page  : '';
        $search = isset($request->search) ? $request->search  : '';
        $law_dep_id = isset($request->law_dep_id) ? $request->law_dep_id : '';

        //เซ็ทค่า การนำข้อมูลเข้า เบสิค
        $old_image = isset($request->old_image) ? $request->old_image  : '';
        // dd( $old_image);

        $law_id = isset($request->law_id ) ? $request->law_id   : '';
        $law_rank = isset($request->law_rank ) ? $request->law_rank   : '';
        $law_index= isset($request->law_index) ? $request->law_index   : 0;
        $law_name=isset($request->law_name) ? $request->law_name   : '';
        $law_image =isset($request->law_image) ? $request->law_image   : '';
        $law_rtanumber = isset($request->law_rtanumber ) ? $request->law_rtanumber   : '';
        $law_defective = isset($request->law_defective ) ? $request->law_defective   : '';
        $law_defective_about = isset($request->law_defective_about ) ? $request->law_defective_about   : '';
        $law_m3_join = isset($request->law_m3_join ) ? $request->law_m3_join   : '';
        $law_m7_join = isset($request->law_m7_join ) ? $request->law_m7_join   : '';
        $law_reward = isset($request->law_reward) ? $request->law_reward  : '';
        $law_parent_about = isset($request->law_parent_about ) ? $request->law_parent_about  : '';
        $law_address = isset($request->law_address ) ? $request->law_address   : '';
        $law_m7_join = isset($request->law_m7_join ) ? $request->law_m7_join   : '';
        $law_intern = isset($request->law_intern ) ? $request->law_intern : '';
        $law_corp = isset($request->law_corp ) ? $request->law_corp   : '';
        $law_startdate = isset($request->law_startdate  ) ?   $this->dateThaiToeng($request->law_startdate)  : null;
        $law_phone = isset($request->law_phone ) ? $request->law_phone  : '';
        $law_about = isset($request->law_about) ? $request->law_about   : '';
        $law_parent_id = isset($request->law_parent_id) ? $request->law_parent_id   : '';
        $law_parent_rank = isset($request->law_parent_rank) ? $request->law_parent_rank   : '';
        $law_parent_name = isset($request->law_parent_name) ? $request->law_parent_name   : '';
        $law_dep_name = isset($request->law_dep_name) ? $request->law_dep_name   : '';
        $law_phone = isset($request->law_phone) ? $request->law_phone   : '';
      //  dd($soldier_id);
        $chk =false;

        $setrank= Rank::where('rank_name','=', $law_rank)->first();
        $law_rank_index = isset($setrank->cco_rank_index ) ? $setrank->cco_rank_index  : 2;



        $law =Law::where('law_id','=', $law_id)->first();
        $law_year =$law->law_year;
        $law_dep_id=$law->law_dep_id;
        $law_province=isset($request->law_province) ? $request->law_province   : '';
        $law_amphoe=isset($request->law_amphoe) ? $request->law_amphoe   : '';

        if($law){
            Law::where('law_id','=',$law_id)->update([


                "law_id" => $law_id
                ,"law_dep_id" =>$law_dep_id
                ,"law_rank" => $law_rank
                ,'law_rank_index' =>$law_rank_index
                ,"law_name" => $law_name
                ,"law_index" => $law_index
                ,"law_defective" =>$law_defective
                ,"law_defective_about" =>$law_defective_about
                ,"law_m3_join" =>$law_m3_join
                ,"law_m7_join" =>$law_m7_join
                ,"law_reward" =>$law_reward
                ,"law_parent_about" =>$law_parent_about
                ,"law_address" =>$law_address
                ,"law_province" =>$law_province
                ,"law_amphoe" =>$law_amphoe
                ,"law_phone" =>$law_phone
                ,"law_about" =>$law_about
                ,"law_parent_id" =>$law_parent_id
                ,"law_parent_rank" =>$law_parent_rank
                ,"law_parent_name" =>$law_parent_name
                ,"law_dep_name" =>$law_dep_name
                ,"law_phone" =>$law_phone

            ]);
        }

        // อัพเดทภาพ
        $update_image = $request->file('law_image');

        if($update_image &&  $law )
            {

                // gen ชื่อภาพ
                $name_gen = hexdec(uniqid());

                //ดึงนามสกุลไฟล์ภาพ
                $img_ext = strtolower($law_image->getClientOriginalExtension());

                //ดึงนามสกุลไฟล์ภาพ ภาพ
                $img_name = $name_gen.'.'.$img_ext;

                //อัพโหลดภาพ และอัพเดทข้อมูล
                $upload_location = 'image/law/'.$law_year.'/'.$law_dep_id.'/';

                //ต้องการเช็ตpath ก่อน ถ้าไม่มีให้สร้าง
                if (!File::exists('image/law/'.$law_year)) {

                    // mkdir($upload_location, 0755, true);
                    File::makeDirectory('image/law/'.$law_year, 0755, true);
                    File::makeDirectory($upload_location, 0755, true);
                }

                $full_path = $upload_location.$img_name;

                //ลบภาพเก่าและอัพภาพใหม่แทนที่
                $old_image = $request->old_image;
                //   if($old_image){
                //   unlink($old_image);}
                $law_image->move($upload_location,$img_name);
                // $img = Image::make($soldier_image->path());
                // $act = $img->resize(400, 600, function ($const) {
                //     $const->aspectRatio();
                // })->save($full_path);
                $chk = True;

                Law::where('law_id','=',$law_id)->update([
                    'law_image'=> $full_path

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
        public function index3(Request $request){



            $search   =isset($request->search) ? $request->search : '' ;
            //   dd($request->all());
            //  รับจากหน้า index ที่ selecd มา
            $law_dep_id     =isset($request->law_dep_id) ? $request->law_dep_id : '' ;
            $law_rank =isset($request->law_rank ) ? $request->law_rank  : '' ;
            $law_lawchk=isset($request->law_lawchk ) ? $request->law_lawchk  : '' ;
            $law_ranknco = 1;
            $law_provinces  =isset($request->law_provinces) ? $request->law_provinces : '' ;
            $law_education =isset($request->law_education) ? $request->law_education : '' ;
            $law_disease =isset($request->law_disease) ? $request->law_disease : '' ;

            // เช็ค สิทธิ์ login
            $user_id = Auth::user()->id;
            $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

            $DepArr =Array();
            foreach($userdep as $key =>$row){
                $DepArr[]=$row->dep_id;
            }
            // ลิส table
            $law= Law::where('law_id','!=','')

            ->where(function($query) use ($law_ranknco){
                if($law_ranknco!=''){
                    $query->where('law_rank_index','<=',2);
                }

            })

            ->where(function($query) use ($DepArr){
                     if($DepArr){
                         $query->whereIn('law_dep_id',$DepArr);
                     }

              })
              // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
              ->where(function($query) use ($law_dep_id){
                 if($law_dep_id!=''){
                     $query->where('law_dep_id','=',$law_dep_id);
                 }

             })
             ->where(function($query) use ($law_rank){
                if($law_rank!=''){
                    $query->where('law_rank','=',$law_rank);
                }

            })
            ->where(function($query) use ($law_lawchk){
                if($law_lawchk!=''){

                      if($law_lawchk=='ม.35(3)'){
                            $query->where('law_index','=',3);
                            }

                      if($law_lawchk=='ม.35(7)'){
                        $query->where('law_index','=',7);
                          }
                }

            })

             ->where(function($query) use ($law_provinces){
                 if($law_provinces!=''){
                     $query->where('law_province','=',$law_provinces);
                 }

             })

             ->where(function($query) use ($law_disease){
                 if($law_disease!=''){
                     $query->where('law_disease','=',$law_disease);
                 }

                })
             ->where(function($query) use ($search){
                 if($search !=''){
                     //ตัวแรก where ตามด้วย orwhere
                     $query->where('law_name', 'like','%'.$search.'%')
                     ->orwhere('law_id', 'like','%'.$search.'%')
                     ->orwhere('law_dep_name', 'like','%'.$search.'%')
                     ->orwhere('law_bat_name', 'like','%'.$search.'%')
                     ->orwhere('law_rtanumber', 'like','%'.$search.'%')
                     ->orwhere('law_intern', 'like','%'.$search.'%')
                     ->orwhere('law_province', 'like','%'.$search.'%');

                 }
                 })
                 // ->dd()
                // ->orderBy('soldier_intern')
                //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
                // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
                // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
                 ->orderBy('law_name')
                 // ->orderBy('created_at','desc')
                 ->paginate(15);


      $Department=Department::select('dep_id')
        //->selectRaw('ใส่sql ตรงๆเลย')
        ->where('law_rank_index','<=',2)
        ->selectRaw('min(departments.dep_index)dep_index')
        ->selectRaw('min(department_name)department_name')
        ->selectRaw("SUM(CASE WHEN law_dep_id != '' THEN 1 ELSE 0 END) AS total")
        //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
        ->leftJoin("laws", "laws.law_dep_id", "=", "departments.dep_id")
        //->where('soldier_dep_id','!=',)
        ->groupBy('dep_id')
        ->orderBy('dep_index')
        //->dd()
        ->get();

        $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();



        $provinces = Law::selectRaw('law_province as province')->where('law_province','!=','')->distinct()->get();

        $total_nco= Law::where('law_id','!=','')->count();




    return view('admin.law.index',compact('law','Department','total_nco','law_dep_id','law_provinces','law_education','law_disease','provinces','rank','law_rank','law_lawchk','search' ));
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

    public function index2(Request $request){



        $search   =isset($request->search) ? $request->search : '' ;
        //   dd($request->all());
        //  รับจากหน้า index ที่ selecd มา
        $law_dep_id     =isset($request->law_dep_id) ? $request->law_dep_id : '' ;
        $law_rank =isset($request->law_rank ) ? $request->law_rank  : '' ;
        $law_lawchk=isset($request->law_lawchk ) ? $request->law_lawchk  : '' ;
        $law_ranknco = 1;
        $law_provinces  =isset($request->law_provinces) ? $request->law_provinces : '' ;
        $law_education =isset($request->law_education) ? $request->law_education : '' ;
        $law_disease =isset($request->law_disease) ? $request->law_disease : '' ;

        // เช็ค สิทธิ์ login
        $user_id = Auth::user()->id;
        $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

        $DepArr =Array();
        foreach($userdep as $key =>$row){
            $DepArr[]=$row->dep_id;
        }
        // ลิส table
        $law= Law::where('law_id','!=','')

        ->where(function($query) use ($law_ranknco){
            if($law_ranknco!=''){
                $query->where('law_rank_index','<=',2);
            }

        })

        ->where(function($query) use ($DepArr){
                 if($DepArr){
                     $query->whereIn('law_dep_id',$DepArr);
                 }

          })
          // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
          ->where(function($query) use ($law_dep_id){
             if($law_dep_id!=''){
                 $query->where('law_dep_id','=',$law_dep_id);
             }

         })
         ->where(function($query) use ($law_rank){
            if($law_rank!=''){
                $query->where('law_rank','=',$law_rank);
            }

        })
        ->where(function($query) use ($law_lawchk){
            if($law_lawchk!=''){

                  if($law_lawchk=='ม.35(3)'){
                        $query->where('law_index','=',3);
                        }

                  if($law_lawchk=='ม.35(7)'){
                    $query->where('law_index','=',7);
                      }
            }

        })

         ->where(function($query) use ($law_provinces){
             if($law_provinces!=''){
                 $query->where('law_province','=',$law_provinces);
             }

         })

         ->where(function($query) use ($law_disease){
             if($law_disease!=''){
                 $query->where('law_disease','=',$law_disease);
             }

            })
         ->where(function($query) use ($search){
             if($search !=''){
                 //ตัวแรก where ตามด้วย orwhere
                 $query->where('law_name', 'like','%'.$search.'%')
                 ->orwhere('law_id', 'like','%'.$search.'%')
                 ->orwhere('law_dep_name', 'like','%'.$search.'%')
                 ->orwhere('law_bat_name', 'like','%'.$search.'%')
                 ->orwhere('law_rtanumber', 'like','%'.$search.'%')
                 ->orwhere('law_intern', 'like','%'.$search.'%')
                 ->orwhere('law_province', 'like','%'.$search.'%');

             }
             })
             // ->dd()
            // ->orderBy('soldier_intern')
            //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
            // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
            // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
             ->orderBy('law_name')
             // ->orderBy('created_at','desc')
             ->paginate(15);


  $Department=Department::select('dep_id')
    //->selectRaw('ใส่sql ตรงๆเลย')
    ->where('law_rank_index','<=',2)
    ->selectRaw('min(departments.dep_index)dep_index')
    ->selectRaw('min(department_name)department_name')
    ->selectRaw("SUM(CASE WHEN law_dep_id != '' THEN 1 ELSE 0 END) AS total")
    //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
    ->leftJoin("laws", "laws.law_dep_id", "=", "departments.dep_id")
    //->where('soldier_dep_id','!=',)
    ->groupBy('dep_id')
    ->orderBy('dep_index')
    //->dd()
    ->get();

    $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();



    $provinces = Law::selectRaw('law_province as province')->where('law_province','!=','')->distinct()->get();

    $total_nco= Law::where('law_id','!=','')->count();




return view('admin.pay.index',compact('law','Department','total_nco','law_dep_id','law_provinces','law_education','law_disease','provinces','rank','law_rank','law_lawchk','search' ));
}



}
