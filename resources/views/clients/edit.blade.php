@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit client</div>

                <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{route('clients')}}"><- Back to clients</a>
                    </div>    
                    <div class="col-md-6">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('update-client', $client->id) }}">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                        <div class="form-group row">
                            <label for="hostname" class="col-md-4 col-form-label text-md-right">{{ __('Hostname') }}</label>
                            <div class="col-md-6">
                                <input id="hostname" type="text" class="form-control @error('hostname') is-invalid @enderror" name="hostname" value="{{ $client->hostname }}" required autofocus>

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
                                    <option value="" @if(!empty($client->raid) && $client->raid[1]['key'] == '') {{'selected'}} @endif>-</option>
                                    <option value="Anydesk" @if(!empty($client->raid) && $client->raid[1]['key'] == 'Anydesk') {{'selected'}} @endif >Anydesk</option>
                                    <option value="TeamViewer" @if(!empty($client->raid) && $client->raid[1]['key'] == 'TeamViewer') {{'selected'}} @endif >TeamViewer</option>
                                </select>
                            </div>
                            <div class="col-md-3">    
                                <input id="id" type="text" class="form-control" name="raid[1][value]" @if (!empty($client->raid))value="{{$client->raid[1]['value']}}" @endif placeholder="12345">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                                <a href="{{route('clients')}}" class="btn btn-danger">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>    
    </div>
</div>
@endsection
