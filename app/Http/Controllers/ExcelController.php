<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Rap2hpoutre\FastExcel\FastExcel;

class ExcelController extends Controller
{
    public function index()
    {
        return view('admin.soldier.excel');
    }

    public function import(Request $request)
    {


     try {
        $users = (new FastExcel)->import($request->file('users'), function ($line) {
            return User::create([
                'name' => $line['Name'],
                'email' => $line['Email'],
                'password'=>'D1',
            ]);
        });
        return redirect('/soldier/excel')->with(['success' => "Users imported successfully."]);

     } catch (\Throwable $th) {

        return redirect('/soldier/excel')->with(['success' => "ไม่สำเร็จครับ"]);

     }


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
