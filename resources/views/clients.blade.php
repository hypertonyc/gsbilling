@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div id="clients-list" class="list-group">
                @foreach($clients as $client)
                <a class="list-group-item" id-client-data="{{ $client['id'] }}">
                    <span class="badge">{{ count($client['devices']) }}</span>
                    {{$client['name']}}
                </a>                        
                @endforeach                
            </div>
        </div>
        <div class="col-md-8">        
            @foreach($clients as $client)
            <div class="clients-info panel panel-default" id-client-data="{{ $client['id'] }}">                
                <div class="panel-heading"><strong>Информация по клиенту {{$client['name']}}</strong></div>
                <div class="panel-body">
                    <p><strong>ИД:</strong> {{$client['remote_id']}}</p>
                    <p><strong>НАИМЕНОВАНИЕ:</strong> {{$client['name']}}</p>
                    <p><strong>ТАРИФ:</strong> {{$client['price']}}</p>
                    <p><strong>БАЛАНС:</strong> {{$client['balance']}}</p>
                    <table class="table table-hover">
                        <tr>
                            <th>IMEI</th>
                            <th>НОМЕР</th>
                            <th>ПОСЛЕДНИЕ ДАННЫЕ</th>
                        </tr>
                        @foreach($client['devices'] as $device)
                        <tr>
                            <td>{{$device->imei}}</td>
                            <td>{{$device->number}}</td>
                            <td>{{$device->last_date}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>                
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
