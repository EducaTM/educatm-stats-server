<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Usage;
use App\Models\Client;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request){
        $lava = new Lavacharts();
        $chart = $lava->DataTable();

        $result = [];

        Usage::all()->groupBy('date')->map(function ($row, $key) use (&$result) {
            $item[] = $key;
            $item[] = $row->sum('usage');
            $item[] = $row->count();

            array_push($result, $item);
        });
        



        $chart->addDateColumn('Day')
            ->addNumberColumn('Usage by date')
            ->addNumberColumn('# Clients')
            ->addRows($result);

        $lava->ColumnChart('Usage', $chart, [
            'title' => 'Usage',
            'height' => 500
        ]);

        $data['lava'] = $lava;

        $data['clients'] = Client::with('usage')->get();
        $data['new_reports'] = $data["clients"]->where('updated_at', '>=', Carbon::now()->subDay())->count();
        return view('dashboard', $data);
    }
}
