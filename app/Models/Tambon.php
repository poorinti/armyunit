<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tambon extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = true;
    public $table = 'tambons';
    protected $fillable = [
        'id', 'tambon', 'amphoe', 'province', 'zipcode',
        'tambon_code', 'amphoe_code', 'province_code'
   ];

}
