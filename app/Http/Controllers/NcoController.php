<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use App\Models\Soldier;
use App\Models\Userdep;
use App\Models\Department;
use App\Models\Nco;
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

        $nco= Nco::where('nco_id','!=','')->get()->toQuery()->paginate(1);;



        return view('admin.nco.index',compact('nco'));
    }

    public function edit(Request $request){
        //   dd($request->all());

        $nco= Nco::where('nco_id','!=','')->first();
        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();

    // dd($soldier_provinces);

            return view('admin.nco.edit',compact('nco','provinces','amphoes'));



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


          return view('admin.nco.add',compact('Department'));
         }

         public function delete($soldier_id){
            $act=true;
            $soldier_id  =isset($soldier_id) ? $soldier_id : '' ;

            $delete = Soldier::Where('soldier_id','=',$soldier_id)->Delete();
            if($act){
                return redirect()->back()->with("success","ลบข้อมูลถาวรเรียบร้อย");
            } else{
                return redirect()->back()->with("error","ไม่ลบสามารถลบข้อมูลได้");
            }
        }
        public function update(Request $request,$dep_id){

        }

}
