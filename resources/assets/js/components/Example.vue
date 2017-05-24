<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="clients-info panel panel-default" v-for="client of clients">
            <div class="panel-heading"><strong>Информация по клиенту {{client.name}}</strong></div>
            <div class="panel-body">
                <p><strong>ИД:</strong>  {{client.remote_id}}</p>
                <p><strong>НАИМЕНОВАНИЕ:</strong> {{client.name}}</p>
                <p><strong>ТАРИФ:</strong> {{client.price}}</p>
                <p><strong>БАЛАНС:</strong> {{client.balance}}</p>
                <table class="table table-hover">
                    <tr>
                        <th>IMEI</th>
                        <th>НОМЕР</th>
                        <th>ПОСЛЕДНИЕ ДАННЫЕ</th>
                    </tr>
                    <tr v-for="device of client.devices">
                        <td>{{device.imei}}</td>
                        <td>{{device.number}}</td>
                        <td>{{device.last_date}}</td>
                    </tr>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data: () => ({
    clients: [],
    errors: []
  }),

  // Fetches posts when the component is created.
  created() {
    axios.get('/api/clients')
    .then(response => {
      this.clients = response.data.clients
    })
    .catch(e => {
      this.errors.push(e)
    })
  }
}
</script>
