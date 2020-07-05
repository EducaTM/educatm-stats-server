<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(Request $request){
        if($request->has('search_term') && !empty($request->search_term)){
            $data['clients'] = Client::with('usage')->where('hostname', 'LIKE', '%'.$request->search_term.'%')->paginate(20);   
        }else{
            $data['clients'] = Client::with('usage')->paginate(20);
        }
        
        $data['search_term'] = $request->search_term;

        return view('clients.index', $data);
    }


    public function create(Request $request){
        $this->validate($request, [
            'hostname' => ['required', 'size:20', 'regex:/^educatm-\w+/', 'unique:clients']
        ]);


        $client = Client::firstOrCreate([
            'hostname' => $request->hostname,
        ]);

        $client->raid = $request->raid;

        $client->save();

        return back();
    }

    public function edit($id){
        $data['client'] = Client::findOrFail($id);

        return view('clients.edit', $data);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'hostname' => ['required', 'size:20', 'regex:/^educatm-\w+/']
        ]);

        $client = Client::findOrFail($id);

        $client->hostname = $request->hostname;
        $client->raid = $request->raid;
        $client->save();

        return back()->with('success', 'Update successful!');
    }
}
