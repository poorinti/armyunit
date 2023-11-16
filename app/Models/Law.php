<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    use HasFactory;

    protected $primaryKey = "law_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'laws';

    protected $fillable = [

        'law_id', 'law_rank', 'law_name', 'law_rank_index', 'law_rank_index_name', 'law_image'
        , 'law_index', 'law_rtanumber', 'law_province', 'law_amphoe', 'law_intern', 'law_corp'
        , 'law_startdate', 'law_phone', 'law_about', 'law_address', 'law_zip', 'law_defective'
        , 'law_defective_about', 'law_m3_join', 'law_m7_join', 'law_reward', 'law_parent'
        , 'law_nco_index', 'law_cco_index', 'dep_index', 'law_dep_id'
        , 'law_dep_name', 'law_bat_id', 'law_bat_name','law_parent_about'
        , 'law_year', 'created_at', 'updated_at'

        ,'law_parent_id', 'law_parent_rank', 'law_parent_rank_index', 'law_parent_name', 'law_parent_phone'
   ];
}
