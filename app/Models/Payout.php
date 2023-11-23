<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $primaryKey = "payout_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'payouts';

    protected $fillable = [

        'payout_id', 'payout_name', 'created_at', 'updated_at'
   ];
}
