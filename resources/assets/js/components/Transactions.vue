<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Новая транзакция</strong></div>
            <div class="panel-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" v-on:submit.prevent="addTransaction()">
                <div class="form-group">
                  <label for="name" class="col-sm-4 control-label">Клиент</label>
                  <div class="col-sm-4">
                    <select class="form-control" id="client" v-model="fillItem.client_id">
                      <option v-for="client of clients" v-bind:value="client.id">{{client.name}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="radio col-sm-offset-4 col-sm-4">
                    <label>
                      <input type="radio" name="transaction-type" id="deposit" value="0" v-model="fillItem.type" checked>
                      Пополнить
                    </label>
                  </div>
                  <div class="radio col-sm-offset-4 col-sm-4">
                    <label>
                      <input type="radio" name="transaction-type" id="withdraw" value="1" v-model="fillItem.type">
                      Снять
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="price" class="col-sm-4 control-label">Сумма</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="amount" v-model="fillItem.amount">
                  </div>
                </div>
                <div class="form-group">
                  <label for="balance" class="col-sm-4 control-label">Описание</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" rows="3" id="description" v-model="fillItem.description"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-2">
                    <button type="submit" class="btn btn-success">Провести</button>
                  </div>
                </div>
              </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Журнал проведенных транзакций</strong></div>
            <div class="panel-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                      <th>ДАТА</th>
                      <th>КЛИЕНТ</th>
                      <th>СУММА</th>
                      <th>ОПИСАНИЕ</th>
                      <th>ПОЛЬЗОВАТЕЛЬ</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="transaction of transactions" v-bind:class="{ withdraw: (transaction.amount < 0) }">
                    <td>{{transaction.created_at}}</td>
                    <td>{{clients[transaction.client_id].name}}</td>
                    <td>{{transaction.amount}}</td>
                    <td>{{transaction.description}}</td>
                    <td v-if="transaction.user_id">{{users[transaction.user_id].name}}</td>
                    <td v-else>Автомат</td>                    
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
    <modal v-bind:fillItem="fillItem" v-on:update="updateTransactions"></modal>
  </div>
</template>

<script>
  import axios from 'axios';
  import moment from 'moment';
  import modalComponent from './ModalConfirmation.vue';

  export default {
    data() {
      return {
        fillItem: {client_id: '', client_name: '', type: '', amount: '', description: ''},
        clients: [],
        transactions: [],
        users: [],
        errors: []
      }
    },

    methods: {
      getTransactions() {
        axios.get('/api/transactions')
        .then(response => {
          var transactions = [];
          this.clients = response.data.clients_with_transactions.clients;
          this.transactions = response.data.clients_with_transactions.transactions;
          this.users = response.data.clients_with_transactions.users;
        })
        .catch(e => {
          this.errors.push(e)
        })
      },
      addTransaction(event) {
        this.fillItem.client_name = this.clients[this.fillItem.client_id].name;

        $('#confirm-item').modal('show');
      },
      updateTransactions(input) {

        // for(var idx = 0, l = this.clients.length; this.clients[idx] && this.clients[idx].id !== input.id;idx++);
        // if(idx !== this.clients.length) {
        //   this.clients[idx].name = input.name;
        //   this.clients[idx].price = input.price;
        // }

      }
    },

    components: {
      'modal': modalComponent
    },

    created() {
      this.getTransactions()
    }
  }
</script>
