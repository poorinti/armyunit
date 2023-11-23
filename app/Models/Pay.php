<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $primaryKey = "pay_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'pays';

    protected $fillable = [

        'pay_id', 'pay_rank', 'pay_name', 'pay_rank_index', 'pay_rank_index_name', 'pay_image', 'pay_index', 'pay_rtanumber'
        , 'pay_province', 'pay_amphoe', 'pay_intern', 'pay_corp', 'pay_startdate', 'pay_phone', 'pay_about', 'pay_address'
        , 'pay_zip', 'pay_defective', 'pay_defective_about', 'pay_m3_join', 'pay_m7_join', 'pay_reward', 'pay_parent_about'
        , 'pay_parent_id', 'pay_parent_rank', 'pay_parent_rank_index', 'pay_parent_name', 'pay_parent_phone', 'pay_nco_index'
        , 'pay_cco_index', 'pay_payout_index', 'pay_payout', 'dep_index', 'pay_dep_id', 'pay_dep_name', 'pay_bat_id', 'pay_bat_name'
        , 'pay_year', 'created_at', 'updated_at'
   ];
}
