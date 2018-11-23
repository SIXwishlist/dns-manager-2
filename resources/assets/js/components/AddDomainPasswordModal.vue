<template>
  <div class="modal fade" :id="'add-password-modal-' + id" tabindex="-1" role="dialog" :aria-labelledby="'add-password-modal-' + id + '-label'">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" :id="'add-password-modal-' + id + '-label'">
            <template v-if="change">
              Đổi mật khẩu của tên miền {{domain}}
            </template>
            <template v-else>
              Đặt mật khẩu cho tên miền {{domain}}
            </template>
          </h4>
        </div>
        <div class="modal-body">
          <div class="form-group xs-pt-10">
            <label for="password">
              Mật khẩu
            </label>
            <input id="password" type="password" class="form-control" v-model="newPassword">
          </div>

          <div class="form-group">
            <label for="password-confirm">
              Xác nhận mật khẩu
            </label>
            <input id="password-confirm" type="password" class="form-control" v-model="newPasswordConfirmation">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ bỏ</button>
          <button type="button" class="btn btn-primary" @click="add()">
            <template v-if="change">
              Cập nhật
            </template>
            <template v-else>
              Xác nhận
            </template>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['change', 'domain', 'id'],

    data() {
      return {
        newPassword: null,
        newPasswordConfirmation: null
      }
    },

    methods: {
      add() {
        let data = {
          password: this.newPassword,
          password_confirmation: this.newPasswordConfirmation
        };

        this.$http.post('/ajax/domains/' + this.domain + '/password', data)
          .then(response => {
            if (this.change) {
              alert('Thay đổi mật khẩu thành công');
            } else {
              alert('Đã đặt mật khẩu cho tên miền ' + this.domain);
            }

            location.reload();
          })
          .catch(response => {
            let msg = "Lỗi:";

            for (let i in response.body) {
              msg += "\n" + response.body[i][0];
            }

            alert(msg);
          });
      }
    }
  }
</script>
