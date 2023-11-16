<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    protected $primaryKey = "rank_id";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'ranks';

    protected $fillable = [
        'rank_id',
        'rank_name',
        'nco_rank_index',
        'cco_rank_index'
   ];
}
