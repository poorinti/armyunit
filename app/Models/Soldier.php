<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Soldier extends Model
{
    use HasFactory;

    protected $primaryKey = "soldier_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'soldiers';

    protected $fillable = [
        'soldier_id', 'soldier_name', 'soldier_image', 'soldier_address'
        , 'soldier_country', 'soldier_state', 'soldier_zip', 'soldier_intern'
        , 'soldier_corp', 'soldier_education', 'soldier_skill', 'soldier_startdate'
        , 'soldier_enddate', 'soldier_phone', 'soldier_about', 'soldier_dep_id'
        , 'created_at', 'updated_at','soldier_year'
        ,'soldiers_dep_name','soldiers_bat_id','soldiers_bat_name'
        ,'soldiers_teacher', 'soldiers_now', 'soldiers_term', 'soldier_course','dep_index','soldier_province','soldier_amphoe'
        ,'soldier_education_study', 'soldier_education_end', 'soldier_wantto', 'soldier_health', 'soldier_want_nco', 'soldier_want_skill', 'soldier_disease', 'soldier_relative_name1', 'soldier_relative_phone1'
        , 'soldier_relative_add1', 'soldier_relative_name2', 'soldier_relative_phone2', 'soldier_relative_add2'
        ,'soldier_disease_about','soldier_wantto_about'
        ,'soldier_job'

   ];
}
