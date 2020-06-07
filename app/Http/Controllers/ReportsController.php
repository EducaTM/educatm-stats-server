<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Usage;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function store(Request $request){

        $this->validate($request, [
            'hostname' => ['required'],
            'usage' => ['required']
        ]);


        $client = Client::create([
            'hostname' => $request->hostname,
        ]);
        
        $client->usage()->createMany($request->usage);

        return response()->json('ok!');
    }
}
