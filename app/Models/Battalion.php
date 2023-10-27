<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battalion extends Model
{
    use HasFactory;
    protected $fillable = [
        'battalion_id', 'battalion_name', 'created_at', 'updated_at'
   ];

}
