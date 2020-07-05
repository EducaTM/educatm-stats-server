@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card mb-3">
                <div class="card-header">Add client</div>

                <div class="card-body">
                <form method="POST" action="{{ route('create-client') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="hostname" class="col-md-4 col-form-label text-md-right">{{ __('Hostname') }}</label>
                            <div class="col-md-6">
                                <input id="hostname" type="text" class="form-control @error('hostname') is-invalid @enderror" name="hostname" value="{{ old('hostname') }}" required autofocus>

                                @error('hostname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hostname" class="col-md-4 col-form-label text-md-right">{{ __('Remote access ID') }}</label>
                            <div class="col-md-3">
                                <select class="form-control" name="raid[1][key]">
                                    <option value="">-</option>
                                    <option value="Anydesk">Anydesk</option>
                                    <option value="TeamViewer">TeamViewer</option>
                                </select>
                            </div>
                            <div class="col-md-3">    
                                <input id="id" type="text" class="form-control" name="raid[1][value]" placeholder="12345">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="card mb-3">
                <div class="card-header">Clients list</div>

                <div class="card-body">
                    <form class="" method="GET" action="{{route('clients')}}">
                    @csrf
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="d-flex">                               
                                <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Live 24h</a>
                                    <a class="dropdown-item" href="#">Unactivated</a>
                                </div>
                            </div>
                            </div>
                            <div>
                                <input class="form-control form-control-lg" value="{{$search_term}}" name="search_term" type="text" placeholder="Search...">
                            </div>
                        </div>
                    </form>  
                    <hr />  
                    <div class="accordion" id="accordionExample">
                    @foreach($clients as $client)
                        <div class="card">
                            <div class="card-header" id="{{$client->id}}">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left d-flex justify-content-between" type="button" data-toggle="collapse" data-target="#{{$client->hostname}}" aria-expanded="true" aria-controls="{{$client->hostname}}">
                                    {{$client->hostname}}
                                    <div class="">
                                        @if($client->last_active >= Carbon\Carbon::now()->subDays(1))
                                        <span class="badge badge-pill badge-success">&#8226;</span>
                                        @elseif($client->usage->count() == 0)
                                        <span class="badge badge-pill badge-danger">&#8226;</span>
                                        @else
                                        <span class="badge badge-pill badge-secondary">&#8226;</span>
                                        @endif 
                                    </div>
                                </button>
                                </h2>
                            </div>

                            <div id="{{$client->hostname}}" class="collapse" aria-labelledby="{{$client->id}}" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if(is_array($client->raid))
                                        <p>Remote access ID:</p>
                                        @foreach($client->raid as $service)
                                            <p>{{$service['key']}} - {{$service['value']}}</p>
                                        @endforeach
                                    @endif
                                    <ul>    
                                    @foreach($client->usage as $usage)
                                        <li>{{$usage->date}} - {{$usage->usage}} ore</li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        {{ $clients->links() }}
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection