<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Tambon;


class TambonController  extends Controller{

    public function getProvinces()    {
        $provinces = Tambon::select('province')
            ->distinct()
            ->get();
        return $provinces;
        //return response()->json($provinces, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
       // JSON_UNESCAPED_UNICODE);

    }
    public function getAmphoes(Request $request)
    {
        $province = $request->get('province');
        $amphoes = Tambon::select('amphoe')
            ->where('province', 'like', "%$province%")
            ->distinct()
            ->get();
        return $amphoes;
    }
    public function getTambons(Request $request)
    {
        $province = $request->get('province');
        $amphoe = $request->get('amphoe');
        $tambons = Tambon::select('tambon')
            ->where('province', 'like', "%$province%")
            ->where('amphoe', 'like', "%$amphoe%")
            ->distinct()
            ->get();
        return $tambons;
    }
    public function getZipcodes(Request $request)
    {
        $province = $request->get('province');
        $amphoe = $request->get('amphoe');
        $tambon = $request->get('tambon');
        $zipcodes = Tambon::select('zipcode')
            ->where('province', $province)
            ->where('amphoe', $amphoe)
            ->where('tambon', $tambon)
            ->get();
        return $zipcodes;
    }
}
