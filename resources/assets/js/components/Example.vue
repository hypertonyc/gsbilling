<template>
  
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        fillItem: {id: '', remote_id: '', name: '', price: '', balance: ''},
        clients: [],
        errors: []
      }
    },

    methods: {

      editClient(item, event) {
        this.fillItem.id = item.id;
        this.fillItem.remote_id = item.remote_id;
        this.fillItem.name = item.name;
        this.fillItem.price = item.price;
        this.fillItem.balance = item.balance;
        $('#edit-item').modal('show');
      },
    },

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
