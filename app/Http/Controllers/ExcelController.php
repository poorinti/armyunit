<?php

namespace App\Http\Controllers;

use App\Models\Soldier;
use App\Models\Department;
use App\Models\Rank;
use App\Models\Law;
use App\Models\Nco;
use App\Models\Pay;
use App\Models\Cco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class ExcelController extends Controller
{
    public function index()
    {

        $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();
        return view('admin.soldier.excel',compact('Department'));
    }
    public function indexnco()
    {

        $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();
        return view('admin.nco.excel',compact('Department'));
    }
    public function indexcco()
    {

        $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();
        return view('admin.cco.excel',compact('Department'));
    }
    public function indexlaw()
    {

        $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();
        return view('admin.law.excel',compact('Department'));
    }
    public function indexpay()
    {

        $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();
        return view('admin.pay.excel',compact('Department'));
    }
    public function indexuser()
    {

        $Department=Department::where('dep_id','!=','')->orderby('dep_id')->get();
        return view('admin.user.excel',compact('Department'));
    }
/////////////////////////////////////////////////////////////////////////////////////////ss
    public function import(Request $request)
    {

       $excel_import= $request->file('excel_import');
    //


    if(!$excel_import){

        return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
    }

    // $line->$soldier_dep_id = $soldier_dep_id;
      //   try {
            $soldiers = (new FastExcel)->import($excel_import, function ($line) {

                $soldier_dep_id=$line['soldier_dep_id'];


                $Dep=Department::where('dep_id','=',$soldier_dep_id)->first();

                $soldiers_dep_name      =$Dep->department_name;
                $soldiers_bat_id        =$Dep->battalion_id ;
                $soldiers_bat_name      =$Dep->battalion_name;

                $created_at=Carbon::now()->format("Y-m-d H:i:s");
                $updated_at =Carbon::now()->format("Y-m-d H:i:s");

                try {
                return Soldier::insert([

                    'soldier_id' =>$line['soldier_id']
                    ,'soldier_name'=>trim($line['soldier_name'])
                    ,'soldier_rtanumber'=>trim($line['soldier_rtanumber'])
                    ,'soldier_address'=>trim($line['soldier_address'])
                    ,'soldier_job'=>trim($line['soldier_job'])
                    ,'soldier_intern'=>trim($line['soldier_intern'])
                    ,'soldier_corp'=>trim($line['soldier_corp'])
                    ,'soldier_province'=>trim($line['soldier_province'])
                    ,'soldier_amphoe'=>trim($line['soldier_amphoe'])
                    ,'soldier_education'=>trim($line['soldier_education'])
                    ,'soldier_education_study'=>trim($line['soldier_education_study'])
                    ,'soldier_education_end'=>trim($line['soldier_education_end'])
                    ,'soldier_skill'=>trim($line['soldier_skill'])
                    ,'soldier_startdate_text'=>trim($line['soldier_startdate_text'])
                    ,'soldier_enddate_text'=>trim($line['soldier_enddate_text'])
                    ,'soldier_phone'=>trim($line['soldier_phone'])
                    ,'soldier_about'=>trim($line['soldier_about'])
                    ,'soldier_wantto'=>trim($line['soldier_wantto'])
                    ,'soldier_wantto_about'=>trim($line['soldier_wantto_about'])
                    ,'soldier_health'=>trim($line['soldier_health'])
                    ,'soldier_want_nco'=>trim($line['soldier_want_nco'])
                    ,'soldier_want_skill'=>trim($line['soldier_want_skill'])
                    ,'soldier_disease'=>trim($line['soldier_disease'])
                    ,'soldier_disease_about'=>trim($line['soldier_disease_about'])
                    ,'soldier_relative_name1'=>trim($line['soldier_relative_name1'])
                    ,'soldier_relative_phone1'=>trim($line['soldier_relative_phone1'])
                    ,'soldier_relative_add1'=>trim($line['soldier_relative_add1'])
                    ,'soldier_relative_name2'=>trim($line['soldier_relative_name2'])
                    ,'soldier_relative_phone2'=>trim($line['soldier_relative_phone2'])
                    ,'soldier_relative_add2'=>trim($line['soldier_relative_add2'])
                    ,'soldier_course_have'=>trim($line['soldier_course_have'])
                    ,'soldier_course'=>trim($line['soldier_course'])
                    ,'soldiers_teacher'=>trim($line['soldiers_teacher'])
                    ,'soldiers_term'=>trim($line['soldiers_term'])
                    ,'soldiers_now'=>trim($line['soldiers_now'])

                    ,'soldier_dep_id'=>$soldier_dep_id
                    ,'soldiers_dep_name'=>$soldiers_dep_name
                    ,'soldiers_bat_id'=>$soldiers_bat_id
                    ,'soldiers_bat_name'=>$soldiers_bat_name
                    ,'updated_at'=>$updated_at
                    ,'created_at'=>$created_at


                ]);
            } catch (\Throwable $th) {
                return

                Soldier::where('soldier_id','=',trim($line['soldier_id']))->update([

                    //'soldier_id' =>$line['soldier_id']
                    'soldier_name'=>trim($line['soldier_name'])
                    ,'soldier_rtanumber'=>trim($line['soldier_rtanumber'])
                    ,'soldier_address'=>trim($line['soldier_address'])
                    ,'soldier_job'=>trim($line['soldier_job'])
                    ,'soldier_intern'=>trim($line['soldier_intern'])
                    ,'soldier_corp'=>trim($line['soldier_corp'])
                    ,'soldier_province'=>trim($line['soldier_province'])
                    ,'soldier_amphoe'=>trim($line['soldier_amphoe'])
                    ,'soldier_education'=>trim($line['soldier_education'])
                    ,'soldier_education_study'=>trim($line['soldier_education_study'])
                    ,'soldier_education_end'=>trim($line['soldier_education_end'])
                    ,'soldier_skill'=>trim($line['soldier_skill'])
                    ,'soldier_startdate_text'=>trim($line['soldier_startdate_text'])
                    ,'soldier_enddate_text'=>trim($line['soldier_enddate_text'])
                    ,'soldier_phone'=>trim($line['soldier_phone'])
                    ,'soldier_about'=>trim($line['soldier_about'])
                    ,'soldier_wantto'=>trim($line['soldier_wantto'])
                    ,'soldier_wantto_about'=>trim($line['soldier_wantto_about'])
                    ,'soldier_health'=>trim($line['soldier_health'])
                    ,'soldier_want_nco'=>trim($line['soldier_want_nco'])
                    ,'soldier_want_skill'=>trim($line['soldier_want_skill'])
                    ,'soldier_disease'=>trim($line['soldier_disease'])
                    ,'soldier_disease_about'=>trim($line['soldier_disease_about'])
                    ,'soldier_relative_name1'=>trim($line['soldier_relative_name1'])
                    ,'soldier_relative_phone1'=>trim($line['soldier_relative_phone1'])
                    ,'soldier_relative_add1'=>trim($line['soldier_relative_add1'])
                    ,'soldier_relative_name2'=>trim($line['soldier_relative_name2'])
                    ,'soldier_relative_phone2'=>trim($line['soldier_relative_phone2'])
                    ,'soldier_relative_add2'=>trim($line['soldier_relative_add2'])
                    ,'soldier_course_have'=>trim($line['soldier_course_have'])
                    ,'soldier_course'=>trim($line['soldier_course'])
                    ,'soldiers_teacher'=>trim($line['soldiers_teacher'])
                    ,'soldiers_term'=>trim($line['soldiers_term'])
                    ,'soldiers_now'=>trim($line['soldiers_now'])

                    ,'soldier_dep_id'=>$soldier_dep_id
                    ,'soldiers_dep_name'=>$soldiers_dep_name
                    ,'soldiers_bat_id'=>$soldiers_bat_id
                    ,'soldiers_bat_name'=>$soldiers_bat_name
                    ,'updated_at'=>$updated_at

                ]);
                //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
                }


            });
        //   } catch (\Throwable $th) {

        //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
        //  }

        return redirect('/soldier/excel')->with(['success' => "Users imported successfully."]);

    }
/////////////////////////////////////////////////////////////////////////////////////////ss
    public function importnco(Request $request)
    {

       $excel_import= $request->file('excel_import');
    //


    if(!$excel_import){

        return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
    }

    // $line->$soldier_dep_id = $soldier_dep_id;
      //   try {
            $nco = (new FastExcel)->import($excel_import, function ($line) {

                $nco_dep_id=$line['nco_dep_id'];


                $Dep=Department::where('dep_id','=',$nco_dep_id)->first();

                $nco_dep_name      =$Dep->department_name;
                $nco_bat_id        =$Dep->battalion_id ;
                $nco_bat_name      =$Dep->battalion_name;

                $nco_rank  = trim($line['nco_rank']);

                $nco_rank_iput_name=Rank::where('rank_name','=',$nco_rank  )->first();
                $nco_rank_index = isset($nco_rank_iput_name->nco_rank_index ) ? $nco_rank_iput_name->nco_rank_index   : 0;


                $created_at=Carbon::now()->format("Y-m-d H:i:s");
                $updated_at =Carbon::now()->format("Y-m-d H:i:s");

                try {
                return Nco::insert([

                    'nco_id' =>trim($line['nco_id'])
                    ,'nco_name'=>trim($line['nco_name'])
                    ,'nco_job'=>trim($line['nco_job'])
                    ,'nco_rank'=>trim($line['nco_rank'])
                    ,'nco_rank_index'=>$nco_rank_index
                    ,'nco_corp'=>trim($line['nco_corp'])
                    ,'nco_education'=>trim($line['nco_education'])
                    ,'nco_education_study'=>trim($line['nco_education_study'])
                    ,'nco_address'=>trim($line['nco_address'])
                    ,'nco_amphoe'=>trim($line['nco_amphoe'])
                    ,'nco_province'=>trim($line['nco_province'])
                    ,'nco_wantto'=>trim($line['nco_wantto'])
                    ,'nco_wantto_about'=>trim($line['nco_wantto_about'])
                    ,'nco_health'=>trim($line['nco_health'])
                    ,'nco_health_about'=>trim($line['nco_health_about'])
                    ,'nco_wife_name'=>trim($line['nco_wife_name'])
                    ,'nco_child_name1'=>trim($line['nco_child_name1'])
                    ,'nco_child_name2'=>trim($line['nco_child_name2'])
                    ,'nco_child_name3'=>trim($line['nco_child_name3'])
                    ,'nco_child_name4'=>trim($line['nco_child_name4'])
                    ,'nco_child_name5'=>trim($line['nco_child_name5'])
                    ,'nco_skill_work'=>trim($line['nco_skill_work'])
                    ,'nco_skill'=>trim($line['nco_skill'])
                    ,'nco_phone'=>trim($line['nco_phone'])

                    ,'nco_dep_id'=>$nco_dep_id
                    ,'nco_dep_name'=>$nco_dep_name
                    ,'nco_bat_id'=>$nco_bat_id
                    ,'nco_bat_name'=>$nco_bat_name
                    ,'updated_at'=>$updated_at
                    ,'created_at'=>$created_at


                ]);
            } catch (\Throwable $th) {
                return

                Nco::where('nco_id','=',trim($line['nco_id']))->update([

                    //'soldier_id' =>$line['soldier_id']

                    'nco_name'=>trim($line['nco_name'])
                    ,'nco_job'=>trim($line['nco_job'])
                    ,'nco_rank'=>trim($line['nco_rank'])
                    ,'nco_rank_index'=>$nco_rank_index
                    ,'nco_corp'=>trim($line['nco_corp'])
                    ,'nco_education'=>trim($line['nco_education'])
                    ,'nco_education_study'=>trim($line['nco_education_study'])
                    ,'nco_address'=>trim($line['nco_address'])
                    ,'nco_amphoe'=>trim($line['nco_amphoe'])
                    ,'nco_province'=>trim($line['nco_province'])
                    ,'nco_wantto'=>trim($line['nco_wantto'])
                    ,'nco_wantto_about'=>trim($line['nco_wantto_about'])
                    ,'nco_health'=>trim($line['nco_health'])
                    ,'nco_health_about'=>trim($line['nco_health_about'])
                    ,'nco_wife_name'=>trim($line['nco_wife_name'])
                    ,'nco_child_name1'=>trim($line['nco_child_name1'])
                    ,'nco_child_name2'=>trim($line['nco_child_name2'])
                    ,'nco_child_name3'=>trim($line['nco_child_name3'])
                    ,'nco_child_name4'=>trim($line['nco_child_name4'])
                    ,'nco_child_name5'=>trim($line['nco_child_name5'])
                    ,'nco_skill_work'=>trim($line['nco_skill_work'])
                    ,'nco_skill'=>trim($line['nco_skill'])
                    ,'nco_phone'=>trim($line['nco_phone'])

                    ,'nco_dep_id'=>$nco_dep_id
                    ,'nco_dep_name'=>$nco_dep_name
                    ,'nco_bat_id'=>$nco_bat_id
                    ,'nco_bat_name'=>$nco_bat_name
                    ,'updated_at'=>$updated_at






                ]);
                //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
                }


            });
        //   } catch (\Throwable $th) {

        //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
        //  }

        return redirect('/nco/excel')->with(['success' => "Users imported successfully."]);

    }
 /////////////////////////////////////////////////////////////////////////////////////////ss

 public function importcco(Request $request)
 {

    $excel_import= $request->file('excel_import');
 //


 if(!$excel_import){

     return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
 }

 // $line->$soldier_dep_id = $soldier_dep_id;
   //   try {
         $cco = (new FastExcel)->import($excel_import, function ($line) {

             $cco_dep_id=$line['cco_dep_id'];


             $Dep=Department::where('dep_id','=',$cco_dep_id)->first();

             $cco_dep_name      =$Dep->department_name;
             $cco_bat_id        =$Dep->battalion_id ;
             $cco_bat_name      =$Dep->battalion_name;

             $cco_rank  = trim($line['cco_rank']);

             $nco_rank_iput_name=Rank::where('rank_name','=',$cco_rank  )->first();
             $cco_rank_index = isset($nco_rank_iput_name->nco_rank_index ) ? $nco_rank_iput_name->nco_rank_index   : 0;


             $created_at=Carbon::now()->format("Y-m-d H:i:s");
             $updated_at =Carbon::now()->format("Y-m-d H:i:s");

             try {
             return Cco::insert([

                'cco_id' =>trim($line['cco_id'])
                    ,'cco_name'=>trim($line['cco_name'])
                    ,'cco_job'=>trim($line['cco_job'])
                    ,'cco_rank'=>trim($line['cco_rank'])
                    ,'cco_rank_index'=>$cco_rank_index
                    ,'cco_corp'=>trim($line['cco_corp'])
                    ,'cco_education'=>trim($line['cco_education'])
                    ,'cco_education_study'=>trim($line['cco_education_study'])
                    ,'cco_address'=>trim($line['cco_address'])
                    ,'cco_amphoe'=>trim($line['cco_amphoe'])
                    ,'cco_province'=>trim($line['cco_province'])
                    ,'cco_wantto'=>trim($line['cco_wantto'])
                    ,'cco_wantto_about'=>trim($line['cco_wantto_about'])
                    ,'cco_health'=>trim($line['cco_health'])
                    ,'cco_health_about'=>trim($line['cco_health_about'])
                    ,'cco_wife_name'=>trim($line['cco_wife_name'])
                    ,'cco_child_name1'=>trim($line['cco_child_name1'])
                    ,'cco_child_name2'=>trim($line['cco_child_name2'])
                    ,'cco_child_name3'=>trim($line['cco_child_name3'])
                    ,'cco_child_name4'=>trim($line['cco_child_name4'])
                    ,'cco_child_name5'=>trim($line['cco_child_name5'])
                    ,'cco_skill_work'=>trim($line['cco_skill_work'])
                    ,'cco_skill'=>trim($line['cco_skill'])
                    ,'cco_phone'=>trim($line['cco_phone'])

                    ,'cco_dep_id'=>$cco_dep_id
                    ,'cco_dep_name'=>$cco_dep_name
                    ,'cco_bat_id'=>$cco_bat_id
                    ,'cco_bat_name'=>$cco_bat_name
                    ,'updated_at'=>$updated_at
                    ,'created_at'=>$created_at


             ]);
         } catch (\Throwable $th) {
             return

             Cco::where('cco_id','=',trim($line['cco_id']))->update([

                 //'soldier_id' =>$line['soldier_id']


                    'cco_name'=>trim($line['cco_name'])
                    ,'cco_job'=>trim($line['cco_job'])
                    ,'cco_rank'=>trim($line['cco_rank'])
                    ,'cco_rank_index'=>$cco_rank_index
                    ,'cco_corp'=>trim($line['cco_corp'])
                    ,'cco_education'=>trim($line['cco_education'])
                    ,'cco_education_study'=>trim($line['cco_education_study'])
                    ,'cco_address'=>trim($line['cco_address'])
                    ,'cco_amphoe'=>trim($line['cco_amphoe'])
                    ,'cco_province'=>trim($line['cco_province'])
                    ,'cco_wantto'=>trim($line['cco_wantto'])
                    ,'cco_wantto_about'=>trim($line['cco_wantto_about'])
                    ,'cco_health'=>trim($line['cco_health'])
                    ,'cco_health_about'=>trim($line['cco_health_about'])
                    ,'cco_wife_name'=>trim($line['cco_wife_name'])
                    ,'cco_child_name1'=>trim($line['cco_child_name1'])
                    ,'cco_child_name2'=>trim($line['cco_child_name2'])
                    ,'cco_child_name3'=>trim($line['cco_child_name3'])
                    ,'cco_child_name4'=>trim($line['cco_child_name4'])
                    ,'cco_child_name5'=>trim($line['cco_child_name5'])
                    ,'cco_skill_work'=>trim($line['cco_skill_work'])
                    ,'cco_skill'=>trim($line['cco_skill'])
                    ,'cco_phone'=>trim($line['cco_phone'])

                    ,'cco_dep_id'=>$cco_dep_id
                    ,'cco_dep_name'=>$cco_dep_name
                    ,'cco_bat_id'=>$cco_bat_id
                    ,'cco_bat_name'=>$cco_bat_name
                    ,'updated_at'=>$updated_at




             ]);
             //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
             }


         });
     //   } catch (\Throwable $th) {

     //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
     //  }

     return redirect('/cco/excel')->with(['success' => "Users imported successfully."]);

 }
/////////////////////////////////////////////////////////////////////////////////////////ss
    public function importlaw(Request $request)
    {

       $excel_import= $request->file('excel_import');
    //


    if(!$excel_import){

        return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
    }

    // $line->$soldier_dep_id = $soldier_dep_id;
      //   try {
            $law = (new FastExcel)->import($excel_import, function ($line) {

                $law_dep_id=trim($line['law_dep_id']);


                $Dep=Department::where('dep_id','=',$law_dep_id)->first();
                //  dd( $Dep);
                    // เอาค่าแรง
                    $law_dep_name  = isset($Dep->department_name) ? $Dep->department_name   : '';

                    $law_bat_name = isset($Dep->battalion_name) ? $Dep->battalion_name   : '';
                    $law_bat_id= isset($Dep->battalion_id) ? $Dep->battalion_id   : '';

                    // $law_bat_name  =$Dep->battalion_name;

                    // $law_bat_id   =$Dep->battalion_id ;

                $law_rank  = trim($line['law_rank']);

                    $nco_rank_iput_name=Rank::where('rank_name','=',$law_rank  )->first();
                    $nco_rank_index = isset($nco_rank_iput_name->nco_rank_index ) ? $nco_rank_iput_name->nco_rank_index   : 0;

                    //  dd( $Dep->department_name);


                // dd( $law_dep_name,$law_bat_id,$law_bat_name );

                $created_at=Carbon::now()->format("Y-m-d H:i:s");
                $updated_at =Carbon::now()->format("Y-m-d H:i:s");

                try {
                return Law::insert([

                    'law_id' =>$line['law_id']
                    ,'law_name'=>trim($line['law_name'])
                    ,"law_rank" => trim($line['law_rank'])
                    ,'law_rank_index' =>trim($line['law_rank_index'])
                    ,'law_rank_index_name' =>$nco_rank_index
                    ,"law_index" => trim($line['law_index'])
                    ,"law_defective" =>trim($line['law_defective'])
                    ,"law_defective_about" =>trim($line['law_defective_about'])
                    ,"law_m3_join" =>trim($line['law_m3_join'])
                    ,"law_m7_join" =>trim($line['law_m7_join'])
                    ,"law_reward" =>trim($line['law_reward'])
                    ,'law_address'=>trim($line['law_address'])
                    ,'law_province'=>trim($line['law_province'])
                    ,'law_amphoe'=>trim($line['law_amphoe'])
                    ,"law_parent_about" =>trim($line['law_parent_about'])
                    ,'law_phone'=>trim($line['law_phone'])
                    ,'law_about'=>trim($line['law_about'])

                    ,"law_parent_rank" =>trim($line['law_parent_rank'])
                    ,"law_parent_name" =>trim($line['law_parent_name'])



                    ,'law_dep_id'=>$law_dep_id
                    ,'law_dep_name'=>$law_dep_name
                    ,'law_bat_id'=>$law_bat_id
                    ,'law_bat_name'=>$law_bat_name
                    ,'updated_at'=>$updated_at
                    ,'created_at'=>$created_at

                ]);
            } catch (\Throwable $th) {
                return

                Law::where('law_id','=',trim($line['law_id']))->update([

                    'law_name'=>trim($line['law_name'])
                    ,"law_rank" => trim($line['law_rank'])
                    ,'law_rank_index' =>trim($line['law_rank_index'])
                    ,'law_rank_index_name' =>$nco_rank_index
                    ,"law_index" => trim($line['law_index'])
                    ,"law_defective" =>trim($line['law_defective'])
                    ,"law_defective_about" =>trim($line['law_defective_about'])
                    ,"law_m3_join" =>trim($line['law_m3_join'])
                    ,"law_m7_join" =>trim($line['law_m7_join'])
                    ,"law_reward" =>trim($line['law_reward'])
                    ,'law_address'=>trim($line['law_address'])
                    ,'law_province'=>trim($line['law_province'])
                    ,'law_amphoe'=>trim($line['law_amphoe'])
                    ,"law_parent_about" =>trim($line['law_parent_about'])
                    ,'law_phone'=>trim($line['law_phone'])
                    ,'law_about'=>trim($line['law_about'])

                    ,"law_parent_rank" =>trim($line['law_parent_rank'])
                    ,"law_parent_name" =>trim($line['law_parent_name'])


                    ,'law_dep_id'=>$law_dep_id
                    ,'law_dep_name'=>$law_dep_name
                    ,'law_bat_id'=>$law_bat_id
                    ,'law_bat_name'=>$law_bat_name
                    ,'updated_at'=>$updated_at





                ]);
                //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
                }


            });
        //   } catch (\Throwable $th) {

        //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
        //  }

        return redirect('/law/excel')->with(['success' => "Users imported successfully."]);

    }
    /////////////////////////////////////////////////////////////////////////////////////////ss
    public function importpay(Request $request)
    {

       $excel_import= $request->file('excel_import');
    //


    if(!$excel_import){

        return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
    }

    // $line->$soldier_dep_id = $soldier_dep_id;
      //   try {
            $pay = (new FastExcel)->import($excel_import, function ($line) {

                $pay_dep_id=trim($line['pay_dep_id']);


                $Dep=Department::where('dep_id','=',$pay_dep_id)->first();
                //  dd( $Dep);
                    // เอาค่าแรง
                    $pay_dep_name  = isset($Dep->department_name) ? $Dep->department_name   : '';

                    $pay_bat_name = isset($Dep->battalion_name) ? $Dep->battalion_name   : '';
                    $pay_bat_id= isset($Dep->battalion_id) ? $Dep->battalion_id   : '';

                    // $pay_bat_name  =$Dep->battalion_name;

                    // $pay_bat_id   =$Dep->battalion_id ;

                $pay_rank  = trim($line['pay_rank']);

                    $nco_rank_iput_name=Rank::where('rank_name','=',$pay_rank  )->first();
                    $nco_rank_index = isset($nco_rank_iput_name->nco_rank_index ) ? $nco_rank_iput_name->nco_rank_index   : 0;

                    //  dd( $Dep->department_name);


                // dd( $pay_dep_name,$pay_bat_id,$pay_bat_name );

                $created_at=Carbon::now()->format("Y-m-d H:i:s");
                $updated_at =Carbon::now()->format("Y-m-d H:i:s");

                try {
                return Pay::insert([

                    'pay_id' =>$line['pay_id']
                    ,'pay_name'=>trim($line['pay_name'])
                    ,"pay_rank" => trim($line['pay_rank'])
                    ,'pay_rank_index' =>trim($line['pay_rank_index'])
                    ,'pay_rank_index_name' =>$nco_rank_index
                    // ,"pay_index" => trim($line['pay_index'])
                    ,"pay_defective" =>trim($line['pay_defective'])
                    ,"pay_defective_about" =>trim($line['pay_defective_about'])
                    // ,"pay_m3_join" =>trim($line['pay_m3_join'])
                    // ,"pay_m7_join" =>trim($line['pay_m7_join'])
                    ,"pay_reward" =>trim($line['pay_reward'])
                    ,'pay_address'=>trim($line['pay_address'])
                    ,'pay_province'=>trim($line['pay_province'])
                    ,'pay_amphoe'=>trim($line['pay_amphoe'])
                    ,"pay_parent_about" =>trim($line['pay_parent_about'])
                    ,'pay_phone'=>trim($line['pay_phone'])
                    ,'pay_payout'=>trim($line['pay_payout'])
                    ,'pay_about'=>trim($line['pay_about'])

                    ,"pay_parent_rank" =>trim($line['pay_parent_rank'])
                    ,"pay_parent_name" =>trim($line['pay_parent_name'])



                    ,'pay_dep_id'=>$pay_dep_id
                    ,'pay_dep_name'=>$pay_dep_name
                    ,'pay_bat_id'=>$pay_bat_id
                    ,'pay_bat_name'=>$pay_bat_name
                    ,'updated_at'=>$updated_at
                    ,'created_at'=>$created_at

                ]);
            } catch (\Throwable $th) {
                return

                Pay::where('pay_id','=',trim($line['pay_id']))->update([

                    'pay_name'=>trim($line['pay_name'])
                    ,"pay_rank" => trim($line['pay_rank'])
                    ,'pay_rank_index' =>trim($line['pay_rank_index'])
                    // ,"pay_index" => trim($line['pay_index'])
                    ,"pay_defective" =>trim($line['pay_defective'])
                    ,"pay_defective_about" =>trim($line['pay_defective_about'])
                    // ,"pay_m3_join" =>trim($line['pay_m3_join'])
                    // ,"pay_m7_join" =>trim($line['pay_m7_join'])
                    ,"pay_reward" =>trim($line['pay_reward'])
                    ,'pay_address'=>trim($line['pay_address'])
                    ,'pay_province'=>trim($line['pay_province'])
                    ,'pay_amphoe'=>trim($line['pay_amphoe'])
                    ,"pay_parent_about" =>trim($line['pay_parent_about'])
                    ,'pay_phone'=>trim($line['pay_phone'])
                    ,'pay_payout'=>trim($line['pay_payout'])
                    ,"pay_parent_rank" =>trim($line['pay_parent_rank'])
                    ,"pay_parent_name" =>trim($line['pay_parent_name'])


                    ,'pay_dep_id'=>$pay_dep_id
                    ,'pay_dep_name'=>$pay_dep_name
                    ,'pay_bat_id'=>$pay_bat_id
                    ,'pay_bat_name'=>$pay_bat_name
                    ,'updated_at'=>$updated_at





                ]);
                //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
                }


            });
        //   } catch (\Throwable $th) {

        //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
        //  }

        return redirect('/pay/excel')->with(['success' => "Users imported successfully."]);

    }

/////////////////////////////////////////////////////////////////////////////////////////

    public function export()
    {
        return (new FastExcel(User::all()))->download('users.xlsx', function ($user) {
            return [
                'Name' => $user->name,
                'Email' => $user->email,

            ];
        });
    }
    public function importuser (Request $request)
{

   $excel_import= $request->file('excel_import');
//


if(!$excel_import){

    return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
}

// $line->$soldier_dep_id = $soldier_dep_id;
  //   try {
        $pay = (new FastExcel)->import($excel_import, function ($line) {



            $created_at=Carbon::now()->format("Y-m-d H:i:s");
            $updated_at =Carbon::now()->format("Y-m-d H:i:s");

            try {
            return User::insert([

                'name' =>$line['name']
                ,'email'=>trim($line['email'])
                ,"password" => Hash::make(trim($line['password']))

                ,'updated_at'=>$updated_at
                ,'created_at'=>$created_at
                ,"is_admin" => trim($line['is_admin'])

            ]);
        } catch (\Throwable $th) {
            return
            User::where('email','=',trim($line['email']))->update([

                'name' =>$line['name']
                ,"password" => Hash::make(trim($line['password']))

                ,'updated_at'=>$updated_at
                ,'created_at'=>$created_at
                ,"is_admin" => trim($line['is_admin'])

            ]);
            //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
            }


        });
    //   } catch (\Throwable $th) {

    //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
    //  }

    return redirect('/user/excel')->with(['success' => "Users imported successfully."]);

}

}
//////////////////////////////////////////////////////////////////////////////////////

