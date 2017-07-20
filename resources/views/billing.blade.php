@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Отчет по списанию {{ $billing->created_at }}</strong></div>
            <div class="panel-body">
              <table class="table table-hover">
              	<thead>
              	  <tr>
              		  <th>КЛИЕНТ</th>
              		  <th>ВСЕГО УСТРОЙСТВ</th>
              		  <th>АКТИВНЫХ УСТРОЙСТВ</th>
              		  <th>СУММА СПИСАНИЯ</th>
              	  </tr>
              	</thead>
              	<tbody>
              	  @foreach ($billing->billingclients as $client)
              		<tr>
              		  <td>{{$client->name}}</td>
              		  <td>{{$client->devices_count}}</td>
              		  <td>{{$client->active_devices_count}}</td>
              		  <td>{{$client->billing_amount}}</td>
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
