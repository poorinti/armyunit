<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cco extends Model
{
    use HasFactory;

    protected $primaryKey = "cco_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'ccos';

    protected $fillable = [

        'cco_id', 'cco_rank', 'cco_rank_index', 'cco_name', 'cco_rtanumber', 'cco_image', 'cco_address'
        , 'cco_province', 'cco_amphoe', 'cco_zip', 'cco_intern', 'cco_corp', 'cco_startdate', 'cco_phone'
        , 'cco_about', 'cco_sick_have', 'cco_sick'


        , 'nco_law_index', 'nco_law_id', 'nco_law_rank_index'
        , 'nco_law_rank', 'nco_law_name', 'nco_law_defective', 'nco_law_defective_about', 'nco_law_m3_join'
        , 'nco_law_m7_join', 'nco_law_reward', 'nco_law_parent'


        , 'dep_index', 'cco_dep_id', 'cco_dep_name'

        ,'cco_job','cco_wantto_about','cco_health_about'

        , 'cco_bat_id', 'cco_bat_name', 'cco_year', 'created_at', 'updated_at'
   ];
}
