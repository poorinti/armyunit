<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ans extends Model
{
    use HasFactory;

    protected $primaryKey = "ans_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'anss';

    protected $fillable = [

        'ans_id', 'ans_name', 'ans_image', 'ans_index_name'
        , 'ans_index', 'ans_dep_id', 'ans_dep_name', 'ans_bat_id'
        , 'ans_bat_name', 'ans_year', 'created_at', 'updated_at'
   ];
}
