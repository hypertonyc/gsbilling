<template>
  <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Редактирование данных по клиенту</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" enctype="multipart/form-data" v-on:submit.prevent="updateClient(fillItem.id)">
            <div class="form-group">
              <label for="remote-id" class="col-sm-4 control-label">ИД на сервере</label>
              <div class="col-sm-8">
                <p>{{fillItem.remote_id}}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Наименование</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="name" placeholder="Name" v-model="fillItem.name">
              </div>
            </div>
            <div class="form-group">
              <label for="price" class="col-sm-4 control-label">Тариф</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="price" v-model="fillItem.price">
              </div>
            </div>
            <div class="form-group">
              <label for="balance" class="col-sm-4 control-label">Баланс</label>
              <div class="col-sm-8">
                <p>{{fillItem.balance}}</p>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-2">
                <button type="submit" class="btn btn-success">Сохранить</button>
              </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-default" v-on:click="cancelEdit">Отмена</button>
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
      updateClient(id) {
        var input = this.fillItem;
        axios.put('/api/clients/' + id, input)
        .then(response => {
          $('#edit-item').modal('hide');
          toastr.success('Изменения данных по клиенту сохранены.', 'Изменения приняты', {timeout:5000});
          this.$emit('update', input);
        })
        .catch(e => {
          toastr.error(e, 'Произошла ошибка', {timeout:5000});
        });
      },
      cancelEdit() {
        $('#edit-item').modal('hide');
      }
    }
  }
</script>
