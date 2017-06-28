<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="clients-info panel panel-default" v-for="client of clients">
            <div class="panel-heading clearfix">
              <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><strong>Информация по клиенту: {{client.name}}</strong></h4>
              <button class="btn btn-primary pull-right" @click.prevent="editClient(client, $event)"><i class="glyphicon glyphicon-pencil"></i> Редактировать</button>
            </div>
            <div class="panel-body">
                <p><strong>ИД:</strong> {{client.remote_id}}</p>
                <p><strong>НАИМЕНОВАНИЕ:</strong> {{client.name}}</p>
                <p><strong>ТАРИФ:</strong> {{client.price}}</p>
                <p><strong>БАЛАНС:</strong> <span v-bind:class="{ positive: (client.balance > 0), negative: (client.balance < 0) }">{{client.balance}}</span></p>
                <table class="table table-hover devices-table">
                  <thead>
                    <tr>
                        <th>IMEI</th>
                        <th>НОМЕР</th>
                        <th>ПОСЛЕДНИЕ ДАННЫЕ</th>
                        <th v-on:click.prevent="onIsFreeAllClick(client)">НЕ ТАРИФИЦИРОВАТЬ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="device of client.devices" v-bind:class="{ isfree: device.is_free }">
                        <td>{{device.imei}}</td>
                        <td>{{device.number}}</td>
                        <td>{{device.last_date}}</td>
                        <td v-if="device.is_free" v-on:click.prevent="onIsFreeClick(client, device)"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></td>
                        <td v-else v-on:click.prevent="onIsFreeClick(client, device)"><span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span></td>
                    </tr>
                  </tbody>
                </table>
                <div class="text-right" v-if="client.hasChanges">
                  <button class="btn btn-success" v-on:click.prevent="onIsFreeSaveClick(client)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Сохранить</button>
                </div>
            </div>
        </div>
      </div>
    </div>
    <modal v-bind:fillItem="fillItem" v-on:update="updateEditedClient"></modal>
  </div>
</template>

<script>
  import axios from 'axios';
  import moment from 'moment';
  import modalComponent from './Modal.vue';

  export default {
    data() {
      return {
        fillItem: {id: '', remote_id: '', name: '', price: '', balance: ''},
        clients: [],
        errors: []
      }
    },

    methods: {
      getClients() {
        axios.get('/api/clients')
        .then(response => {
          this.clients = response.data.clients;
          this.clients.forEach(function(obj) { obj.hasChanges = false; });
        })
        .catch(e => {
          this.errors.push(e)
        })
      },
      editClient(item, event) {
        this.fillItem.id = item.id;
        this.fillItem.remote_id = item.remote_id;
        this.fillItem.name = item.name;
        this.fillItem.price = item.price;
        this.fillItem.balance = item.balance;
        $('#edit-item').modal('show');
      },
      updateEditedClient(input) {
        for(var idx = 0, l = this.clients.length; this.clients[idx] && this.clients[idx].id !== input.id;idx++);
        if(idx !== this.clients.length) {
          this.clients[idx].name = input.name;
          this.clients[idx].price = input.price;
        }
      },
      onIsFreeClick(client, device) {
        device.is_free = !device.is_free;
        client.hasChanges = true;
      },
      onIsFreeAllClick(client) {
        if (client.devices.length > 0) {
          var i;
          var curIsFree = client.devices[0].is_free;
          for(i = 0; i < client.devices.length; i++) {
            client.devices[i].is_free = !curIsFree;
          }
          client.hasChanges = true;
        }
      },
      onIsFreeSaveClick(client) {

        var input = {devices: []};

        if (client.devices.length > 0) {
          var i;

          for(i = 0; i < client.devices.length; i++) {
            input.devices.push({
              id_device: client.devices[i].id,
              is_free: client.devices[i].is_free,
            });
          }
        }

        axios.put('/api/devices', input)
        .then(response => {

          toastr.success('Изменения данных по терминалам сохранены.', 'Изменения приняты', {timeout:5000});
          client.hasChanges = false;
        })
        .catch(e => {
          toastr.error(e, 'Произошла ошибка', {timeout:5000});
        });
      }
    },

    components: {
      'modal': modalComponent
    },

    created() {
      this.getClients()
    }
  }
</script>
