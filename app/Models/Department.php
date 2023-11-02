<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'dep_id', 'department_name', 'battalion_id', 'battalion_name', 'created_at', 'updated_at', 'deleted_at','dep_index'
   ];

   public function user(){
    return true;
   //  return $this->hasOne(User::class,'id','user_id');
     //return $ตัวโมเดลนี้->เชื่อมต่อ 1:1(ที่โมเดล User,'ที่ โร id','เชื่อมกัม ฟอเรนคีย์ user_id ใน ดีพาสเม้น');
   }

}
