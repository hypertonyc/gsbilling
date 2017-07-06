@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Отчеты по списаниям</strong></div>
            <div class="panel-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                      <th>ДАТА</th>
                      <th>ВСЕГО КЛИЕНТОВ</th>
                      <th>ВСЕГО УСТРОЙСТВ</th>
                      <th>АКТИВНЫХ УСТРОЙСТВ</th>
                      <th>СУММА СПИСАНИЯ</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($billings as $billing)
                    <tr>
                      <td><a href="{{ route('billing', $billing->id) }}">{{$billing->created_at}}</a></td>
                      <td>{{$billing->clients}}</td>
                      <td>{{$billing->devices}}</td>
                      <td>{{$billing->active_devices}}</td>
                      <td>{{$billing->amount}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
