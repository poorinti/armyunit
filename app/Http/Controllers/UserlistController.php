<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Soldier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Userdep;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;


class UserlistController extends Controller
{
    public function index(Request $request){
        if(!Auth::user()->isAdmin()){

            return view('error.403');
        }

        $users= User::all();

        return view('admin.userlist.index',compact('users'));
    }

    public function store(Request $request){
        // dd($request->all());
        $user_id = isset($request->user_id)? $request->user_id : '';
        $dep_id = isset($request->dep_id)? $request->dep_id : '';

        $check =Userdep::where('user_id','=',$user_id)->where('dep_id','=',$dep_id)->count();
        $act =false;

      if($check==0 ){

            $act= Userdep::insert([
                'user_id' =>$user_id
                ,'dep_id' =>$dep_id
            ]);


      }
      $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

      $Department=Department::where('dep_id','!=','')->orderBy('dep_id')->get();

    return view('admin.userlist.add',compact('Department','user_id','userdep'));
    }




    public function delete(Request $request,$user_id){

        //  dd($request->all(),$user_id);

        $dep_id = isset($request->dep_id)? $request->dep_id : '';
        $check =Userdep::where('user_id','=',$user_id)->where('dep_id','=',$dep_id)->count();

        if($check ){

        Userdep::where('user_id','=',$user_id)->where('dep_id','=',$dep_id)->delete();


      }

        $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

        $Department=Department::where('dep_id','!=','')->orderBy('dep_id')->get();

        return view('admin.userlist.add',compact('Department','user_id','userdep'));
    }



       public function dep($user_id){

             $userdep =Userdep::where('user_id','=',$user_id)->orderBy('dep_id')->get();

            $Department=Department::where('dep_id','!=','')->orderBy('dep_id')->get();

            // $showDepartment=Department::where('dep_id','!=','' )->orderBy('dep_id')->get();

          return view('admin.userlist.add',compact('Department','user_id','userdep'));
         }





}
