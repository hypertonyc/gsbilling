@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Настройки</h4>
          </div>
          <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (isset($saved) && $saved['success'])
                <div class="alert alert-success">
                    <p>Изменения сохранены!</p>
                </div>
            @endif
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="clock" class="col-sm-4 control-label">Часовой пояс (смещение от UTC)</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control" name="clock" min="-12" max="14" step="1" value="{{ $settings['clock'] }}">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-2">
                  <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
