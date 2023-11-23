<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Department;
use App\Models\Nco;
use App\Models\Law;
use App\Models\Pay;
use App\Models\Payout;
use App\Models\Paytopayout;
use App\Models\Rank;
use App\Models\Tambon;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Arrays;
use DB;
use Image;

class PayController extends Controller
{
    public function index(Request $request){



                $search   =isset($request->search) ? $request->search : '' ;
                //   dd($request->all());
                //  รับจากหน้า index ที่ selecd มา
                $pay_dep_id     =isset($request->pay_dep_id) ? $request->pay_dep_id : '' ;
                $pay_rank =isset($request->pay_rank ) ? $request->pay_rank  : '' ;
                $pay_paychk=isset($request->pay_paychk ) ? $request->pay_paychk  : '' ;
                $pay_ranknco = 1;
                $pay_provinces  =isset($request->pay_provinces) ? $request->pay_provinces : '' ;
                $pay_education =isset($request->pay_education) ? $request->pay_education : '' ;
                $pay_disease =isset($request->pay_disease) ? $request->pay_disease : '' ;

                // เช็ค สิทธิ์ login
                $user_id = Auth::user()->id;
                $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

                $DepArr =Array();
                foreach($userdep as $key =>$row){
                    $DepArr[]=$row->dep_id;
                }
                // ลิส table
                $pay= Pay::where('pay_id','!=','')

                ->where(function($query) use ($pay_ranknco){
                    if($pay_ranknco!=''){
                        $query->where('pay_rank_index','<=',2);
                    }

                })

                ->where(function($query) use ($DepArr){
                         if($DepArr){
                             $query->whereIn('pay_dep_id',$DepArr);
                         }

                  })
                  // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
                  ->where(function($query) use ($pay_dep_id){
                     if($pay_dep_id!=''){
                         $query->where('pay_dep_id','=',$pay_dep_id);
                     }

                 })
                 ->where(function($query) use ($pay_rank){
                    if($pay_rank!=''){
                        $query->where('pay_rank','=',$pay_rank);
                    }

                })
                ->where(function($query) use ($pay_paychk){
                    if($pay_paychk!=''){

                        $query->where('pay_reward','=',$pay_paychk);

                    }

                })

                 ->where(function($query) use ($pay_provinces){
                     if($pay_provinces!=''){
                         $query->where('pay_province','=',$pay_provinces);
                     }

                 })

                 ->where(function($query) use ($pay_disease){
                     if($pay_disease!=''){
                         $query->where('pay_disease','=',$pay_disease);
                     }

                    })
                 ->where(function($query) use ($search){
                     if($search !=''){
                         //ตัวแรก where ตามด้วย orwhere
                         $query->where('pay_name', 'like','%'.$search.'%')
                         ->orwhere('pay_id', 'like','%'.$search.'%')
                         ->orwhere('pay_dep_name', 'like','%'.$search.'%')
                         ->orwhere('pay_bat_name', 'like','%'.$search.'%')
                         ->orwhere('pay_reward', 'like','%'.$search.'%')
                         ->orwhere('pay_rank', 'like','%'.$search.'%')
                         ->orwhere('pay_province', 'like','%'.$search.'%')
                         ->orwhere('pay_address', 'like','%'.$search.'%')
                         ->orwhere('pay_amphoe', 'like','%'.$search.'%')
                         ->orwhere('pay_parent_about', 'like','%'.$search.'%')
                         ->orwhere('pay_parent_name', 'like','%'.$search.'%');

                     }
                     })
                     // ->dd()
                    // ->orderBy('soldier_intern')
                    //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
                    // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
                    // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
                     ->orderBy('pay_name')
                     // ->orderBy('created_at','desc')
                     ->paginate(15);


          $Department=Department::select('dep_id')
            //->selectRaw('ใส่sql ตรงๆเลย')
            ->where('pay_rank_index','<=',2)
            ->selectRaw('min(departments.dep_index)dep_index')
            ->selectRaw('min(department_name)department_name')
            ->selectRaw("SUM(CASE WHEN pay_dep_id != '' THEN 1 ELSE 0 END) AS total")
            //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
            ->leftJoin("pays", "pays.pay_dep_id", "=", "departments.dep_id")
            //->where('soldier_dep_id','!=',)
            ->groupBy('dep_id')
            ->orderBy('dep_index')
            //->dd()
            ->get();

            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();



            $provinces = Pay::selectRaw('pay_province as province')->where('pay_province','!=','')->distinct()->get();

            $total_nco= Pay::where('pay_id','!=','')->count();




        return view('admin.pay.index',compact('pay','Department','total_nco','pay_dep_id','pay_provinces','pay_education','pay_disease','provinces','rank','pay_rank','pay_paychk','search' ));
    }

    public function edit(Request $request,$pay_id){

            //  dd($request->all());
            $page = isset($request->page)? $request->page : '';
            $search = isset($request->search) ? $request->search  : '';
            $pay_dep_id = isset($request->pay_dep_id) ? $request->pay_dep_id : '';
            $pay_provinces  =isset($request->pay_provinces) ? $request->pay_provinces : '' ;
            $pay_rank =isset($request->pay_rank ) ? $request->pay_rank  : '' ;
            $pay_paychk =isset($request->pay_paychk ) ? $request->pay_paychk  : '' ;
            $provinces = Tambon::select('province')->distinct()->get();
            $amphoes = Tambon::select('amphoe')->distinct()->get();

            $pay= Pay::where('pay_id','=',$pay_id)->first();
            $nco= Pay::where('pay_id','=',$pay_id)->first();
            $payout=  Payout::where('payout_id','!=','')->get();
            $paytopayout= Paytopayout::where('pay_id','=',$pay_id)->get();

            $PayArr =Array();
                foreach($paytopayout as $key =>$row){
                    $PayArr[]=$row->payout_id;
                }
// {{dd($PayArr);}}
            $PayoutArr=Array();
                foreach($paytopayout as $key =>$val){
                    $PayoutArr[$val->payout_id]=$val->payout_date;
                }
// {{dd($PayoutArr);}}
            $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();



    // dd($soldier_provinces);

            return view('admin.pay.edit',compact('page','nco','provinces','amphoes','pay_provinces','rank','pay_rank','pay','pay_dep_id','search','pay_paychk','payout','paytopayout','PayoutArr'));



    }

    /////////////////////////////////////////////////////// แอดข้อมูล/////////////////////////////////////////////
    public function store( Request $request){

        //    dd($request->all());
            // เช็คก่อนเอาเข้า
        $request->validate([

          // 'ไฟล์ที่เก็บค่ามาชื่อ name'=>'ต้องการข้อมูล|ไม่ซ้ำ:ในฐานข้อมูลที่เป็น พหุพจน์ |max:255'

            'pay_id'=>'required|unique:pays|max:13'
            ,'pay_name'=>'required|unique:pays|max:255'
            ,'pay_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
        ],
        [
            'pay_name.required'=>"กรุณาป้อนชื่อกำลังพลด้วยครับ",
            'pay_name.max'=>"ห้ามป้อนตัวอักษรเกิน 255",
            'pay_name.unique'=>"มีข้อมูลชื่อกำลังพลในฐานข้อมูลแล้ว",
            // 'soldier_image.required' => "กรุณาใส่ภาพประกอบ",
            'pay_id.required'=>"กรุณาป้อนเลขประจำตัวประชาชนด้วยครับด้วยครับ",
            'pay_id.max'=>"ห้ามป้อนตัวอักษรเกิน 13",
            'pay_id.unique'=>"มีเลขประจำตัวประชาชนในฐานข้อมูลแล้ว",
        ]
    );

    //บันทึกข้อมูล

    $pay_name   =isset($request->pay_name) ? $request->pay_name : '' ;
    $pay_id   =isset($request->pay_id) ? $request->pay_id : '' ;
    $pay_rank =isset($request->pay_rank) ? $request->pay_rank : '' ;
    $pay_dep_id   =isset($request->pay_dep_id) ? $request->pay_dep_id : '' ;
    $act=false;
    $created_at=Carbon::now()->format("Y-m-d H:i:s");
    $updated_at =Carbon::now()->format("Y-m-d H:i:s");

    $Dep=Department::where('dep_id','=',$pay_dep_id)->first();

    $pay_dep_name      =$Dep->department_name;
    $pay_bat_id        =$Dep->battalion_id ;
    $pay_bat_name      =$Dep->battalion_name;
    $pay_year   =Carbon::now()->format("Y");

    $act =Pay::insert([
        'pay_name'=>$pay_name,
        'pay_rank'=>$pay_rank,
        'pay_id'=>$pay_id,
        'pay_dep_id'=>$pay_dep_id,
        'created_at'=>$created_at,
        'updated_at'=>$updated_at
        ,'pay_dep_name'=>$pay_dep_name
        ,'pay_bat_id'=>$pay_bat_id
        ,'pay_bat_name'=>$pay_bat_name
        ,'pay_year'=>$pay_year

    ]);

//dd($act);
    if($act){


    //การเข้ารหัสรูปภาพ
    $pay_image = $request->file('pay_image');
    if($pay_image){
    // gen ชื่อภาพ
    $name_gen = hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($pay_image->getClientOriginalExtension());

    //ขื่อไฟล์ภาพ ภาพ
    $img_name = $name_gen.'.'.$img_ext;

    //อัพโหลดภาพ และบันทึกข้อมูล
    $upload_location = 'image/pay/'.$pay_year.'/'.$pay_dep_id.'/';
    if (!File::exists('image/pay/'.$pay_year)) {

        // mkdir($upload_location, 0755, true);
        File::makeDirectory('image/pay/'.$pay_year, 0755, true);
        File::makeDirectory($upload_location, 0755, true);
    }
    $full_path = $upload_location.$img_name;
   // dd($full_path);

    Pay::where('pay_id','=',$pay_id)->update([
        'pay_image'=>$full_path,

    ]);

  $pay_image->move($upload_location,$img_name);

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
          $rankpay = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();
          return view('admin.pay.add',compact('Department','rank','rankcco','rankpay'));
         }







         public function delete($pay_id){
            $act=true;

            $pay_id  =isset($pay_id) ? $pay_id : '' ;

            $delete = Pay::Where('pay_id','=',$pay_id)->Delete();
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

                'pay_image'=>'mimes:png,jpg,jpeg,JPG|max:2048'
              ],[
                'pay_image.max' => "ขนาดไฟล์เกิน 2 MB ครับ",
              ]

              );

               //ค้นหา
            //ตัวแปรค้นหา
        $pay_provinces  =isset($request->pay_provinces) ? $request->pay_provinces : '' ;
        $page = isset($request->page) ? $request->page  : '';
        $search = isset($request->search) ? $request->search  : '';
        $pay_dep_id = isset($request->pay_dep_id) ? $request->pay_dep_id : '';

        //เซ็ทค่า การนำข้อมูลเข้า เบสิค
        $old_image = isset($request->old_image) ? $request->old_image  : '';
        // dd( $old_image);

        $pay_id = isset($request->pay_id ) ? $request->pay_id   : '';
        $pay_rank = isset($request->pay_rank ) ? $request->pay_rank   : '';
        $pay_index= isset($request->pay_index) ? $request->pay_index   : 0;
        $pay_name=isset($request->pay_name) ? $request->pay_name   : '';
        $pay_image =isset($request->pay_image) ? $request->pay_image   : '';
        $pay_rtanumber = isset($request->pay_rtanumber ) ? $request->pay_rtanumber   : '';
        $pay_defective = isset($request->pay_defective ) ? $request->pay_defective   : '';
        $pay_defective_about = isset($request->pay_defective_about ) ? $request->pay_defective_about   : '';
        $pay_m3_join = isset($request->pay_m3_join ) ? $request->pay_m3_join   : '';
        $pay_m7_join = isset($request->pay_m7_join ) ? $request->pay_m7_join   : '';
        $pay_reward = isset($request->pay_reward) ? $request->pay_reward  : '';
        $pay_parent_about = isset($request->pay_parent_about ) ? $request->pay_parent_about  : '';
        $pay_address = isset($request->pay_address ) ? $request->pay_address   : '';
        $pay_m7_join = isset($request->pay_m7_join ) ? $request->pay_m7_join   : '';
        $pay_intern = isset($request->pay_intern ) ? $request->pay_intern : '';
        $pay_corp = isset($request->pay_corp ) ? $request->pay_corp   : '';
        $pay_startdate = isset($request->pay_startdate  ) ?   $this->dateThaiToeng($request->pay_startdate)  : null;
        $pay_phone = isset($request->pay_phone ) ? $request->pay_phone  : '';
        $pay_about = isset($request->pay_about) ? $request->pay_about   : '';
        $pay_parent_id = isset($request->pay_parent_id) ? $request->pay_parent_id   : '';
        $pay_parent_rank = isset($request->pay_parent_rank) ? $request->pay_parent_rank   : '';
        $pay_parent_name = isset($request->pay_parent_name) ? $request->pay_parent_name   : '';
        $pay_dep_name = isset($request->pay_dep_name) ? $request->pay_dep_name   : '';
        $pay_phone = isset($request->pay_phone) ? $request->pay_phone   : '';
      //  dd($soldier_id);
        $chk =false;

        $setrank= Rank::where('rank_name','=', $pay_rank)->first();
        $pay_rank_index = isset($setrank->cco_rank_index ) ? $setrank->cco_rank_index  : 2;



        $pay =Pay::where('pay_id','=', $pay_id)->first();
        $pay_year =$pay->pay_year;
        $pay_dep_id=$pay->pay_dep_id;
        $pay_province=isset($request->pay_province) ? $request->pay_province   : '';
        $pay_amphoe=isset($request->pay_amphoe) ? $request->pay_amphoe   : '';

        if($pay){
            Pay::where('pay_id','=',$pay_id)->update([


                "pay_id" => $pay_id
                ,"pay_dep_id" =>$pay_dep_id
                ,"pay_rank" => $pay_rank
                ,'pay_rank_index' =>$pay_rank_index
                ,"pay_name" => $pay_name
                ,"pay_index" => $pay_index
                ,"pay_defective" =>$pay_defective
                ,"pay_defective_about" =>$pay_defective_about
                ,"pay_m3_join" =>$pay_m3_join
                ,"pay_m7_join" =>$pay_m7_join
                ,"pay_reward" =>$pay_reward
                ,"pay_parent_about" =>$pay_parent_about
                ,"pay_address" =>$pay_address
                ,"pay_province" =>$pay_province
                ,"pay_amphoe" =>$pay_amphoe
                ,"pay_phone" =>$pay_phone
                ,"pay_about" =>$pay_about
                ,"pay_parent_id" =>$pay_parent_id
                ,"pay_parent_rank" =>$pay_parent_rank
                ,"pay_parent_name" =>$pay_parent_name
                ,"pay_dep_name" =>$pay_dep_name
                ,"pay_phone" =>$pay_phone

            ]);
        }

        // อัพเดทภาพ
        $update_image = $request->file('pay_image');

        if($update_image &&  $pay )
            {

                // gen ชื่อภาพ
                $name_gen = hexdec(uniqid());

                //ดึงนามสกุลไฟล์ภาพ
                $img_ext = strtolower($pay_image->getClientOriginalExtension());

                //ดึงนามสกุลไฟล์ภาพ ภาพ
                $img_name = $name_gen.'.'.$img_ext;

                //อัพโหลดภาพ และอัพเดทข้อมูล
                $upload_location = 'image/pay/'.$pay_year.'/'.$pay_dep_id.'/';

                //ต้องการเช็ตpath ก่อน ถ้าไม่มีให้สร้าง
                if (!File::exists('image/pay/'.$pay_year)) {

                    // mkdir($upload_location, 0755, true);
                    File::makeDirectory('image/pay/'.$pay_year, 0755, true);
                    File::makeDirectory($upload_location, 0755, true);
                }

                $full_path = $upload_location.$img_name;

                //ลบภาพเก่าและอัพภาพใหม่แทนที่
                $old_image = $request->old_image;
                //   if($old_image){
                //   unlink($old_image);}
                $pay_image->move($upload_location,$img_name);
                // $img = Image::make($soldier_image->path());
                // $act = $img->resize(400, 600, function ($const) {
                //     $const->aspectRatio();
                // })->save($full_path);
                $chk = True;

                Pay::where('pay_id','=',$pay_id)->update([
                    'pay_image'=> $full_path

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
        $pay_dep_id     =isset($request->pay_dep_id) ? $request->pay_dep_id : '' ;
        $pay_rank =isset($request->pay_rank ) ? $request->pay_rank  : '' ;
        $pay_paychk=isset($request->pay_paychk ) ? $request->pay_paychk  : '' ;
        $pay_ranknco = 1;
        $pay_provinces  =isset($request->pay_provinces) ? $request->pay_provinces : '' ;
        $pay_education =isset($request->pay_education) ? $request->pay_education : '' ;
        $pay_disease =isset($request->pay_disease) ? $request->pay_disease : '' ;

        // เช็ค สิทธิ์ login
        $user_id = Auth::user()->id;
        $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

        $DepArr =Array();
        foreach($userdep as $key =>$row){
            $DepArr[]=$row->dep_id;
        }
        // ลิส table
        $pay= Pay::where('pay_id','!=','')

        ->where(function($query) use ($pay_ranknco){
            if($pay_ranknco!=''){
                $query->where('pay_rank_index','<=',2);
            }

        })

        ->where(function($query) use ($DepArr){
                 if($DepArr){
                     $query->whereIn('pay_dep_id',$DepArr);
                 }

          })
          // ส่งโทรแปลเพื่อหาค่า  use คือฝาก พารามิเตอร์ลงในฟังชั่น
          ->where(function($query) use ($pay_dep_id){
             if($pay_dep_id!=''){
                 $query->where('pay_dep_id','=',$pay_dep_id);
             }

         })
         ->where(function($query) use ($pay_rank){
            if($pay_rank!=''){
                $query->where('pay_rank','=',$pay_rank);
            }

        })
        ->where(function($query) use ($pay_paychk){
            if($pay_paychk!=''){

                  if($pay_paychk=='ม.35(3)'){
                        $query->where('pay_index','=',3);
                        }

                  if($pay_paychk=='ม.35(7)'){
                    $query->where('pay_index','=',7);
                      }
            }

        })

         ->where(function($query) use ($pay_provinces){
             if($pay_provinces!=''){
                 $query->where('pay_province','=',$pay_provinces);
             }

         })

         ->where(function($query) use ($pay_disease){
             if($pay_disease!=''){
                 $query->where('pay_disease','=',$pay_disease);
             }

            })
         ->where(function($query) use ($search){
             if($search !=''){
                 //ตัวแรก where ตามด้วย orwhere
                 $query->where('pay_name', 'like','%'.$search.'%')
                 ->orwhere('pay_id', 'like','%'.$search.'%')
                 ->orwhere('pay_dep_name', 'like','%'.$search.'%')
                 ->orwhere('pay_bat_name', 'like','%'.$search.'%')
                 ->orwhere('pay_rtanumber', 'like','%'.$search.'%')
                 ->orwhere('pay_intern', 'like','%'.$search.'%')
                 ->orwhere('pay_province', 'like','%'.$search.'%');

             }
             })
             // ->dd()
            // ->orderBy('soldier_intern')
            //SUBSTRING_INDEX(SUBSTRING_INDEX(soldier_intern,'/', 2), '/',-1) ,SUBSTRING_INDEX(soldier_intern,'/',1);
            // ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(nco_intern,'/', 2), '/',-1) desc")
            // ->orderByRaw("SUBSTRING_INDEX(nco_intern,'/',1) desc")
             ->orderBy('pay_name')
             // ->orderBy('created_at','desc')
             ->paginate(15);


  $Department=Department::select('dep_id')
    //->selectRaw('ใส่sql ตรงๆเลย')
    ->where('pay_rank_index','<=',2)
    ->selectRaw('min(departments.dep_index)dep_index')
    ->selectRaw('min(department_name)department_name')
    ->selectRaw("SUM(CASE WHEN pay_dep_id != '' THEN 1 ELSE 0 END) AS total")
    //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
    ->leftJoin("pays", "pays.pay_dep_id", "=", "departments.dep_id")
    //->where('soldier_dep_id','!=',)
    ->groupBy('dep_id')
    ->orderBy('dep_index')
    //->dd()
    ->get();

    $rank = Rank::where('rank_id','!=','')->where('cco_rank_index','<=',2)->orderby('nco_rank_index')->get();



    $provinces = Pay::selectRaw('pay_province as province')->where('pay_province','!=','')->distinct()->get();

    $total_nco= Pay::where('pay_id','!=','')->count();




return view('admin.pay.index',compact('pay','Department','total_nco','pay_dep_id','pay_provinces','pay_education','pay_disease','provinces','rank','pay_rank','pay_paychk','search' ));
}



}
