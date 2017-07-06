@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Отчет по списанию {{ $billing->created_at }}</strong></div>
            <div class="panel-body">
              {{ $billing->id }}
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
