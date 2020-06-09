<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Usage;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    // store the incoming report
    public function store(Request $request){

        $this->validate($request, [
            'hostname' => ['required', 'size:20', 'regex:/^educatm-\w+/'],
            'usage' => ['required', 'array']
        ]);


        $client = Client::firstOrCreate([
            'hostname' => $request->hostname,
        ]);
        
        foreach($request->usage as $usagePerDay){
            $client->usage()->firstOrCreate(['date' => $usagePerDay['date']], ['usage' => $usagePerDay['time']]);
        }

        return response()->json();
    }
}
