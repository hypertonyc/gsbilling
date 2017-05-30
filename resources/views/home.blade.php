@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Информация</div>
                <div class="panel-body">
                    <p>
                      <strong>Получение токена: </strong>
                      @if(isset($api_requests_dates['authoruze']))
                        {{$api_requests_dates['authoruze']}}
                      @else
                        Никогда
                      @endif
                    </p>
                    <p>
                      <strong>Получение данных по клиентам и терминалам: </strong>
                      @if(isset($api_requests_dates['update']))
                        {{$api_requests_dates['update']}}
                      @else
                        Никогда
                      @endif
                    </p>
                    <p>
                      <strong>Актуализация данных: </strong>
                      @if(isset($api_requests_dates['actualize']))
                        {{$api_requests_dates['actualize']}}
                      @else
                        Никогда
                      @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
