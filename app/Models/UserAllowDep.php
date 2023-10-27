<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAllowDep extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'userallowdeps';

    protected $fillable = [
        'id',
        'user_id',
        'dep_id'
   ];
}
