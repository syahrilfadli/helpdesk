<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city';
    protected $fillable = [
        'name','created_by'
    ];

    public function province(){
        return $this->hasOne('App\Models\Province','province_id','id');
    }
}
