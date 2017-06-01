<template>
  <div class="modal fade" id="confirm-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Подтвердите транзакцию</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" enctype="multipart/form-data" v-on:submit.prevent="addTransaction()">
            <div class="form-group">
              <label for="client" class="col-sm-4 control-label">Клиент:</label>
              <div class="col-sm-8">
                <p>{{fillItem.client_name}}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="type" class="col-sm-4 control-label">Тип транзакции:</label>
              <div class="col-sm-8">
                <p>{{fillItem.type}}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="amount" class="col-sm-4 control-label">Сумма:</label>
              <div class="col-sm-8">
                <p>{{fillItem.amount}}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="amount" class="col-sm-4 control-label">Описание:</label>
              <div class="col-sm-8">
                <p>{{fillItem.description}}</p>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-2">
                <button type="submit" class="btn btn-success">Провести</button>
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default" v-on:click.prevent="cancelTransaction">Отмена</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    props: ['fillItem'],
    methods: {
      addTransaction() {
        var input = this.fillItem;
        axios.post('/api/transactions', input)
        .then(response => {
          $('#confirm-item').modal('hide');
          toastr.success('Транзакция успешна проведена.', 'Транзакция проведена', { timeout:5000 });
          this.$emit('update', input);
        })
        .catch(e => {
          toastr.error(e, 'Произошла ошибка', {timeout:5000});
        });
      },
      cancelTransaction() {
        $('#confirm-item').modal('hide');
      }
    }
  }
</script>
