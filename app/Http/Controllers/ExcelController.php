<?php

namespace App\Http\Controllers;

use App\Models\Soldier;
use App\Models\Department;
use Illuminate\Http\Request;
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
                    ,'soldier_intern'=>trim($line['soldier_intern'])
                    ,'soldier_corp'=>$line['soldier_corp']
                    ,'soldier_address'=>$line['soldier_address']
                    ,'soldier_phone'=>$line['soldier_phone']
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
                    ,'soldier_intern'=> trim($line['soldier_intern'])
                    ,'soldier_corp'=>$line['soldier_corp']
                    ,'soldier_address'=>$line['soldier_address']
                    ,'soldier_phone'=>$line['soldier_phone']
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
                    ,'soldier_intern'=>trim($line['soldier_intern'])
                    ,'soldier_corp'=>$line['soldier_corp']
                    ,'soldier_address'=>$line['soldier_address']
                    ,'soldier_phone'=>$line['soldier_phone']
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
                    ,'soldier_intern'=> trim($line['soldier_intern'])
                    ,'soldier_corp'=>$line['soldier_corp']
                    ,'soldier_address'=>$line['soldier_address']
                    ,'soldier_phone'=>$line['soldier_phone']
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
                    ,'soldier_intern'=>trim($line['soldier_intern'])
                    ,'soldier_corp'=>$line['soldier_corp']
                    ,'soldier_address'=>$line['soldier_address']
                    ,'soldier_phone'=>$line['soldier_phone']
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
                    ,'soldier_intern'=> trim($line['soldier_intern'])
                    ,'soldier_corp'=>$line['soldier_corp']
                    ,'soldier_address'=>$line['soldier_address']
                    ,'soldier_phone'=>$line['soldier_phone']
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

                $law_dep_id=$line['law_dep_id'];


                $Dep=Department::where('dep_id','=',$law_dep_id)->first();

                $law_dep_name      =$Dep->department_name;
                $law_bat_id        =$Dep->battalion_id ;
                $law_bat_name      =$Dep->battalion_name;

                $created_at=Carbon::now()->format("Y-m-d H:i:s");
                $updated_at =Carbon::now()->format("Y-m-d H:i:s");

                try {
                return Law::insert([

                    'law_id' =>$line['law_id']
                    ,'law_name'=>trim($line['law_name'])
                    ,"law_rank" => trim($line['law_rank'])
                    ,'law_rank_index' =>trim($line['law_rank_index'])
                    ,"law_index" => trim($line['law_index'])
                    ,"law_defective" =>trim($line['law_defective'])
                    ,"law_defective_about" =>trim($line['law_defective_about'])
                    ,"law_m3_join" =>trim($line['law_m3_join'])
                    ,"law_m7_join" =>trim($line['law_m7_join'])
                    ,"law_reward" =>trim($line['law_reward'])
                    ,'law_address'=>$line['law_address']
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
                    ,"law_index" => trim($line['law_index'])
                    ,"law_defective" =>trim($line['law_defective'])
                    ,"law_defective_about" =>trim($line['law_defective_about'])
                    ,"law_m3_join" =>trim($line['law_m3_join'])
                    ,"law_m7_join" =>trim($line['law_m7_join'])
                    ,"law_reward" =>trim($line['law_reward'])
                    ,'law_address'=>$line['law_address']
                    ,"law_parent_about" =>trim($line['law_parent_about'])
                    ,'law_phone'=>$line['law_phone']
                    ,"law_parent_rank" =>trim($line['law_parent_rank'])
                    ,"law_parent_name" =>trim($line['law_parent_name'])


                    ,'law_dep_id'=>$law_dep_id
                    ,'law_dep_name'=>$law_dep_name
                    ,'law_bat_id'=>$law_bat_id
                    ,'law_bat_name'=>$law_bat_name
                    ,'updated_at'=>$updated_at
                    ,'created_at'=>$created_at




                ]);
                //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
                }


            });
        //   } catch (\Throwable $th) {

        //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
        //  }

        return redirect('/law/excel')->with(['success' => "Users imported successfully."]);

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
}
