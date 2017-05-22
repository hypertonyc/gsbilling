@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Новый запрос</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="">                        
                        <div class="form-group">                            
                            <label for="debug" class="col-md-4 control-label">Debug</label>

                            <div class="col-md-6">
                                <input id="debug" type="text" class="form-control" name="debug">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button id="sync-devices" type="submit" class="btn btn-primary">
                                    Отправить запрос
                                </button>                         
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
