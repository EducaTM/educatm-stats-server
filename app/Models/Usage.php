<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    protected $fillable = [
        'date',
        'usage'
    ];


    protected $table = 'usage';

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
