@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card text-white bg-info mb-3" >
                <div class="card-body">
                    <h3 class="card-title"><i class="bi bi-people mr-2"></i>{{$clients->count()}}</h3>
                    <p class="card-text">Activated clients.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-white bg-info mb-3" >
                <div class="card-body">
                    <h3 class="card-title"><i class="bi bi-clipboard-check mr-2"></i>{{$new_reports}}</h3>
                    <p class="card-text">Reports in the last 24 hours.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-white bg-info mb-3" >
                <div class="card-body">
                    <h3 class="card-title"><i class="bi bi-clock mr-2"></i>{{$total_usage}}</h3>
                    <p class="card-text">Total usage.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header"><h4 class="my-auto d-inline">Usage by day</h3>
                    <form action="{{url('dashboard')}}" method="GET" class="form-inline float-right">
                        <h5 class="mr-2 my-auto">Filter:</h5>
                        <input class="form-control" type="date" name="from" value="{{$from}}">
                        <h5 class="mr-2 ml-2"> - </h5>
                        <input class="form-control" type="date" name="to" value="{{$to}}">
                        <button class="btn btn-success ml-2" type="submit">Filter</button>
                        <a href="/dashboard" class="btn btn-info ml-2">Reset</a>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">                            
                            <div id="chart"></div>
                            <?= $lava->render("ColumnChart", "Usage", "chart") ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header"><h4 class="my-auto d-inline">Usage by month</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">                            
                            <div id="chart2"></div>
                            <?= $lava->render("ColumnChart", "usageByMonth", "chart2") ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

