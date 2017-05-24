@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="clients-info panel panel-default" v-for="client of clients">
          <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><strong>Информация по клиенту @{{client.name}}</strong></h4>
            <button class="btn btn-primary pull-right" @click.prevent="editClient(client, $event)">Edit<i class="glyphicon glyphicon-pencil"></i></button>
          </div>
          <div class="panel-body">
              <p><strong>ИД:</strong> @{{client.remote_id}}</p>
              <p><strong>НАИМЕНОВАНИЕ:</strong> @{{client.name}}</p>
              <p><strong>ТАРИФ:</strong> @{{client.price}}</p>
              <p><strong>БАЛАНС:</strong> @{{client.balance}}</p>
              <table class="table table-hover">
                <thead>
                  <tr>
                      <th>IMEI</th>
                      <th>НОМЕР</th>
                      <th>ПОСЛЕДНИЕ ДАННЫЕ</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="device of client.devices">
                      <td>@{{device.imei}}</td>
                      <td>@{{device.number}}</td>
                      <td>@{{device.last_date}}</td>
                  </tr>
                </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit client</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" v-on:submit.prevent="updateClient(fillItem.id)">
          <div class="form-group">
            <label for="remote-id" class="col-sm-2 control-label">Remote id</label>
            <div class="col-sm-10">
              <p>@{{fillItem.remote_id}}</p>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" placeholder="Name" v-model="fillItem.name">
            </div>
          </div>
          <div class="form-group">
            <label for="price" class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10">
              <input type="number" step="10.00" class="form-control" id="price" v-model="fillItem.price">
            </div>
          </div>
          <div class="form-group">
            <label for="balance" class="col-sm-2 control-label">Balance</label>
            <div class="col-sm-10">
              <p>@{{fillItem.balance}}</p>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
