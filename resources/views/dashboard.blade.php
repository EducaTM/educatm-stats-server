@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h3>Total number of activated clients: {{$clients->count()}}</h3> 
                    <h3>Reports submitted in the last 24 hours: {{$new_reports}}</h3>
                    <div id="chart"></div>
                     <?= $lava->render("ColumnChart", "Usage", "chart") ?>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
