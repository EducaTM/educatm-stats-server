<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Usage;
use App\Models\Client;
use Illuminate\Http\Request;
use Khill\Lavacharts\Charts\Chart;
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

        if($request->has('from') && $request->has('to')) {
            $from = Carbon::create($request->input('from'));
            $to = Carbon::create($request->input('to'));
        }else{
            $from = Carbon::now()->subDays(90);
            $to = Carbon::now();
        }

        $data['from'] = $from->format('Y-m-d');
        $data['to'] = $to->format('Y-m-d'); 

    
        $usage = Usage::whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();

        $usage->groupBy('date')->map(function ($row, $key) use (&$result) {
            $item[] = $key;
            $item[] = $row->sum('usage');
            $item[] = $row->count();

            array_push($result, $item);
        });


        $usage2= DB::table('usage')
        ->select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(`usage`) as sum'),
        )
        ->whereBetween('date', [Carbon::now()->subMonths(12), Carbon::now()])
        ->groupBy('year', 'month')
        ->get(); 
        
        $result2 = [];
        $usage2->map(function ($row, $key) use (&$result2) {
            $item[] = Carbon::now()->year($row->year)->month($row->month)->endOfMonth();
            $item[] = $row->sum;

            array_push($result2, $item);
        });
        


        $chart->addDateColumn('Day')
            ->addNumberColumn('Usage (h)')
            ->addNumberColumn('# Clients')
            ->addRows($result);

        $lava->ColumnChart('Usage', $chart, [
            'title' => '',
            'height' => 500
        ]);

        //$data['lava'] = $lava;

        $chart = $lava->DataTable();

        $chart->addDateColumn('Month')
        ->addNumberColumn('Usage (h)')
        ->addRows($result2);

        $lava->ColumnChart('usageByMonth', $chart, [
            'title' => '',
            'height' => 500
        ]);


        $data['lava'] = $lava;

        $data['clients'] = Client::with('usage')->get();
        $data['new_reports'] = $data["clients"]->where('updated_at', '>=', Carbon::now()->subDay())->count();
        $data['total_usage'] = Usage::sum('usage');
        return view('dashboard', $data);
    }
}
