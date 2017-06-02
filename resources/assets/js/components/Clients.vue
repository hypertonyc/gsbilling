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
                        <td>{{device.imei}}</td>
                        <td>{{device.number}}</td>
                        <td>{{device.last_date}}</td>                        
                    </tr>
                  </tbody>
                </table>
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
          this.clients = response.data.clients
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
