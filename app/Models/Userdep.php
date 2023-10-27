<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userdep extends Model
{
    use HasFactory;

    protected $primaryKey = ['user_id','dep_id'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'userdeps';

    protected $fillable = [

        'user_id',
        'dep_id'
   ];
}
