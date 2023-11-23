<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paytopayout extends Model
{
    use HasFactory;

    protected $primaryKey = ['pay_id','payout_id'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'paytopayouts';

    protected $fillable = [

        'pay_id', 'payout_id', 'payout_date'
   ];
}
