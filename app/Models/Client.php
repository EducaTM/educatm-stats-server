<?php

namespace App\Models;

use App\Models\Usage;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{


    protected $fillable = [
        'hostname'
    ];

    protected $casts = [
        'raid' => 'array'
    ];
    
    public function usage(){
        return $this->hasMany(Usage::class);
    }

}
