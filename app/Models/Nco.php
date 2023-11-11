<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nco extends Model
{
    use HasFactory;

    protected $primaryKey = "nco_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'ncos';

    protected $fillable = [

        'nco_id', 'nco_rank', 'nco_rank_index', 'nco_name', 'nco_rtanumber', 'nco_image', 'nco_address'
        , 'nco_province', 'nco_amphoe', 'nco_zip', 'nco_intern', 'nco_corp', 'nco_startdate'
        , 'nco_phone', 'nco_about'

        , 'nco_law_index', 'nco_law_id', 'nco_law_rank','nco_law_rank_index'
        , 'nco_law_name'
        , 'nco_law_defective', 'nco_law_defective_about', 'nco_law_m3_join', 'nco_law_m7_join', 'nco_law_reward'
        , 'nco_law_parent', 'dep_index', 'nco_dep_id', 'nco_dep_name', 'nco_bat_id', 'nco_bat_name'
        , 'nco_year'
        , 'created_at', 'updated_at'
   ];
}
