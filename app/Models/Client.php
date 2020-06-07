<?php

namespace App\Models;

use App\Models\Usage;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'hostname'
    ];
    
    public function usage(){
        return $this->hasMany(Usage::class);
    }
}
