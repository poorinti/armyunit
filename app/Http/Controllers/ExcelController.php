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
                    ,'soldier_name'=>$line['soldier_name']
                    ,'soldier_intern'=>$line['soldier_intern']
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
                return Soldier::where('soldier_id','=',$line['soldier_id'])->update([

                    //'soldier_id' =>$line['soldier_id']
                    'soldier_name'=>$line['soldier_name']
                    ,'soldier_intern'=>$line['soldier_intern']
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
                //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
                }


            });
        //   } catch (\Throwable $th) {

        //  //  return redirect()->back()->with(['error' => "ไม่สำเร็จครับ"]);
        //  }

        return redirect('/soldier/excel')->with(['success' => "Users imported successfully."]);

    }



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
